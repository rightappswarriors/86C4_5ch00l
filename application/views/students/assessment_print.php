    <?php
    $row = $query->row();
    $defaultAssessment = $default_ass->row();

    $usertype = $this->session->userdata('current_usertype');
    $isLandscape = in_array($usertype, ['Accounting', 'Registrar', 'Admin', 'Super Admin']);

    $gradeBand = static function ($gradeLevel) {
        $value = strtoupper(trim((string) $gradeLevel));
        if ($value === '') return 'G4-10';
        if (preg_match('/\b(?:LEVEL|GRADE)\s*-?\s*(?:10|11|12|[4-9])\b/i', $value)) return 'G4-10';
        if (preg_match('/\b(?:LEVEL|GRADE)\s*-?\s*[1-3]\b/i', $value)) return 'RR-G3';
        $tokens = preg_split('/[^A-Z0-9]+/', $value, -1, PREG_SPLIT_NO_EMPTY);
        if (in_array('RR', $tokens, true) || in_array('ABCS', $tokens, true) || in_array('K1', $tokens, true) || in_array('K2', $tokens, true)) return 'RR-G3';
        if (preg_match('/\b(10|11|12|[4-9])\b/', $value)) return 'G4-10';
        if (preg_match('/(?:GRADE|LEVEL)?\s*-?\s*(\d{1,2})/i', $value, $match)) return ((int) $match[1] <= 3) ? 'RR-G3' : 'G4-10';
        return 'G4-10';
    };

    $formatMoney = static function ($amount) {
        return '₱ ' . number_format((float) $amount, 2);
    };

    $parseCsvNumbers = static function ($csv) {
        $parts = array_map('trim', explode(',', (string) $csv));
        $parts = array_filter($parts, static function ($value) { return $value !== ''; });
        return array_map('floatval', $parts);
    };

    $g4_10_incidentals = array(
        'PACEs', 'TLE', 'HELE', 'MAPEH', 'Parent Orientation', 'Handbook',
        'Goal/Progress Chart Cover', 'Flags', 'ID', 'Notebook', 'Closing Fee',
        "Fetcher's ID", "Founder's Day", 'Graduation Fee', 'Congress Fee', 'Late Fee', 'CEM'
    );

    $incidentalsLabels = explode(',', $defaultAssessment->incidentals);
    $miscellaneousLabels = array_map('trim', explode(',', $defaultAssessment->miscellaneous));

    $currentGradeBand = $gradeBand($row->gradelevel ?? '');
    if ($currentGradeBand === 'G4-10' && count($incidentalsLabels) === count($g4_10_incidentals)) {
        $incidentalsLabels = $g4_10_incidentals;
    }

    $gradeLabel = $gradeBand($row->gradelevel);
    $studentName = htmlspecialchars(strtoupper($row->lastname . ', ' . $row->firstname), ENT_QUOTES, 'UTF-8');
    $currentDate = date('n/d/Y');
    $schoolYear = date('Y') . '-' . (date('Y') + 1);

    $logoDataUri = '';
    $assetBaseUrl = rtrim(dirname(site_url()), '/\\');
    $logoSrc = $assetBaseUrl . '/assets/images/logo_portal.png';

    $assessmentSource = $query_ass->num_rows() > 0 ? $query_ass->row() : null;

    $tuition = (float) ($assessmentSource ? $assessmentSource->tuition : $defaultAssessment->tuition);
    $registration = (float) ($assessmentSource ? $assessmentSource->registration : $defaultAssessment->registration);

    $miscellaneousValues = $assessmentSource
        ? $parseCsvNumbers($assessmentSource->miscellaneous)
        : $parseCsvNumbers($defaultAssessment->miscellaneous_val);
    $incidentalValues = $assessmentSource
        ? $parseCsvNumbers($assessmentSource->incidentals)
        : $parseCsvNumbers($defaultAssessment->incidentals_val);

    $totalMiscellaneous = array_sum($miscellaneousValues);
    $totalIncidentals = array_sum($incidentalValues);
    $totalAssessment = $tuition + $registration + $totalMiscellaneous + $totalIncidentals;

    $paymentEnroll = (float) ($assessmentSource ? $assessmentSource->payment : $defaultAssessment->payment_enroll);
    $balance = $totalAssessment - $paymentEnroll;
    $monthlyDue = $balance / 9;

    $promissoryPayment = (float) ($assessmentSource ? ($assessmentSource->promissory_payment ?? 0) : 0);
    $promissoryMonthly = $promissoryPayment;

    /* ---------- reusable render helpers ---------- */

    $renderIncidentalsWithValues = static function () use ($incidentalsLabels, $incidentalValues, $formatMoney) {
        foreach ($incidentalsLabels as $i => $label) {
            $val = isset($incidentalValues[$i]) ? (float) $incidentalValues[$i] : 0;
            if ($val == 0) continue;
            ?>
            <div class="row-line">
                <span class="left-label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></span>
                <span class="right-fill"><?= $formatMoney($val); ?></span>
            </div>
            <?php
        }
    };

    $renderMiscellaneousWithValues = static function () use ($miscellaneousLabels, $miscellaneousValues, $formatMoney) {
        foreach ($miscellaneousLabels as $i => $label) {
            $val = isset($miscellaneousValues[$i]) ? (float) $miscellaneousValues[$i] : 0;
            if ($val == 0) continue;
            ?>
            <div class="row-line print-hide-misc">
                <span class="left-label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></span>
                <span class="right-fill"><?= $formatMoney($val); ?></span>
            </div>
            <?php
        }
    };

    $renderComputation = static function () use ($formatMoney, $tuition, $registration, $totalMiscellaneous, $totalIncidentals) {
        ?>
        <div class="comp-line"><span>TUITION</span><span class="comp-fill"><?= $formatMoney($tuition); ?></span></div>
        <div class="comp-line"><span>REGISTRATION</span><span class="comp-fill"><?= $formatMoney($registration); ?></span></div>
        <div class="comp-line"><span>TOTAL MISCELLANEOUS</span><span class="comp-fill"><?= $formatMoney($totalMiscellaneous); ?></span></div>
        <div class="comp-line"><span>TOTAL INCIDENTALS</span><span class="comp-fill"><?= $formatMoney($totalIncidentals); ?></span></div>
        <?php
    };

    $renderSummary = static function () use ($formatMoney, $totalAssessment, $paymentEnroll, $balance, $monthlyDue, $promissoryPayment, $promissoryMonthly) {
        ?>
        <div class="summary-box">
            <div class="s-row"><span class="s-label">TOTAL ASSESSMENT:</span><span class="s-fill"><?= $formatMoney($totalAssessment); ?></span></div>
            <div class="s-row"><span class="s-label">Paid upon enrolment:</span><span class="s-fill"><?= $formatMoney($paymentEnroll); ?></span></div>
            <div class="s-row"><span class="s-label">Balance:</span><span class="s-fill"><?= $formatMoney($balance); ?></span></div>
            <div class="s-row"><span class="s-label">Due every month:</span><span class="s-fill"><?= $formatMoney($monthlyDue + $promissoryMonthly); ?></span></div>
            <div class="s-row"><span class="s-label" style="color: #000 !important;">Monthly Promissory Note Payment:</span><span class="s-fill"><?= $formatMoney($promissoryMonthly); ?></span></div>
            <div class="s-row s-due"><span class="s-label">Total Amount:</span><span class="s-fill"><?= $formatMoney($monthlyDue + $promissoryMonthly); ?></span></div>
            <div class="s-row"><span class="s-label">Payment received by:</span><span class="s-fill"></span></div>
        </div>
        <?php
    };

    $renderMeta = static function ($nameWidth, $dateWidth, $gradeWidth, $syWidth) use ($studentName, $currentDate, $gradeLabel, $schoolYear) {
        ?>
        <div class="meta-row">
            <div>NAME: <span class="meta-ul"><?= $studentName; ?></span></div>
            <div>DATE: <span class="meta-ul"><?= $currentDate; ?></span></div>
        </div>
        <div class="meta-row">
            <div>GRADE: (<?= htmlspecialchars($gradeLabel, ENT_QUOTES, 'UTF-8'); ?>) <span class="meta-ul"><?= htmlspecialchars($row->gradelevel ?? '', ENT_QUOTES, 'UTF-8'); ?></span></div>
            <div>S.Y.: <span class="meta-ul"><?= $schoolYear; ?></span></div>
        </div>
        <?php
    };
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Financial Assessment Print</title>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/Dashboard/students_assessment_print.css">
        <?php if ($isLandscape): ?>
        <style>
            @media print {
                @page { size: letter landscape; margin: 0; }
            }
        </style>
        <?php else: ?>
        <style>
            @media print {
                @page { size: letter portrait; margin: 0; }
            }
        </style>
        <?php endif; ?>
        <style>
            @media print {
                .print-hide-misc {
                    display: none !important;
                }
            }
        </style>
    </head>
    <body class="<?= $isLandscape ? 'landscape-mode' : '' ?>">
    <div class="toolbar">
        <button onclick="window.print()">PRINT / SAVE PDF</button>
        <button onclick="window.close()">CLOSE</button>
    </div>

    <div class="page">
        <div class="grid">
            <!-- ========== LEFT COLUMN: Parent / Main Copy ========== -->
            <div class="left-copy">
                <div class="school-header">
                    <img src="<?= htmlspecialchars($logoSrc, ENT_QUOTES, 'UTF-8'); ?>" alt="School Logo">
                    <div class="school-lines">
                        <div class="school-name">CEBU BOB HUGHES CHRISTIAN ACADEMY, INC.</div>
                        <div class="small">a Ministry of Cebu Bible Baptist Church, Inc.</div>
                        <div class="small">55 Katipunan street, Brgy. Calamba, Cebu City 6000</div>
                        <div class="small">Tel No. 032-422-0700</div>
                    </div>
                </div>

                <div class="form-title">FINANCIAL ASSESSEMENT FORM</div>

                <?php $renderMeta(220, 80, 80, 80); ?>

                <div class="section-grid">
                    <div class="col-left">
                        <div class="section-head">INCIDENTALS & MISCELLANEOUS</div>
                        <?php $renderIncidentalsWithValues(); ?>
                        <?php $renderMiscellaneousWithValues(); ?>
                    </div>
                    <div class="col-right">
                        <div class="section-head">TOTAL COMPUTATION</div>
                        <?php $renderComputation(); ?>
                        <?php $renderSummary(); ?>
                    </div>
                </div>

                <div class="pledge">
                    We the undersigned pledge to abide by the CHURCH-SCHOOL POLICY,<br>
                    DISCIPLINE, RULES AND REGULATIONS and the NO PAYMENT; NO STAMPING<br>
                    OF PACEs policy (1 month overdue) without reservations.
                </div>

                <div class="signature">
                    <div class="sig-line-block"></div>
                    <div class="sig-caption">Father's Signature over Printed Name</div>
                </div>
                <div class="signature sig-mother">
                    <div class="sig-line-block"></div>
                    <div class="sig-caption">Mother's Signature Over Printed Name</div>
                </div>
            </div>

            <!-- ========== RIGHT COLUMN ========== -->
            <div class="right-copy">

                <!-- Student Copy -->
                <div class="right-top">
                    <div class="copy-label">STUDENT COPY</div>

                    <?php $renderMeta(140, 60, 60, 60); ?>

                    <div class="form-title mini-title">FINANCIAL ASSESSEMENT FORM</div>

                    <div class="section-grid mini-grid">
                        <div class="col-left">
                            <div class="section-head">INCIDENTALS & MISC</div>
                            <?php $renderIncidentalsWithValues(); ?>
                            <?php $renderMiscellaneousWithValues(); ?>
                        </div>
                        <div class="col-right">
                            <div class="section-head">TOTAL COMPUTATION</div>
                            <?php $renderComputation(); ?>
                            <?php $renderSummary(); ?>
                        </div>
                    </div>
                </div>

                <!-- Accounting Office Copy -->
                <div class="right-bottom">
                    <div class="copy-label">ACCOUNTING OFFICE COPY</div>

                    <?php $renderMeta(140, 60, 60, 60); ?>

                    <div class="form-title mini-title">FINANCIAL ASSESSEMENT FORM</div>

                    <div class="section-grid mini-grid">
                        <div class="col-left">
                            <div class="section-head">INCIDENTALS & MISC</div>
                            <?php $renderIncidentalsWithValues(); ?>
                            <?php $renderMiscellaneousWithValues(); ?>
                        </div>
                        <div class="col-right">
                            <div class="section-head">TOTAL COMPUTATION</div>
                            <?php $renderComputation(); ?>
                            <?php $renderSummary(); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>