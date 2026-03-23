<?php
$row = $query->row();
$defaultAssessment = $default_ass->row();

$gradeBand = static function ($gradeLevel) {
    $value = strtoupper(trim((string) $gradeLevel));

    if ($value === '') {
        return 'G4-10';
    }

    // Explicit handling for known labels used in this system.
    if (preg_match('/\b(?:LEVEL|GRADE)\s*-?\s*(?:10|11|12|[4-9])\b/i', $value)) {
        return 'G4-10';
    }

    if (preg_match('/\b(?:LEVEL|GRADE)\s*-?\s*[1-3]\b/i', $value)) {
        return 'RR-G3';
    }

    // Strict token matching prevents accidental substring matches.
    $tokens = preg_split('/[^A-Z0-9]+/', $value, -1, PREG_SPLIT_NO_EMPTY);
    if (in_array('RR', $tokens, true) || in_array('ABCS', $tokens, true) || in_array('K1', $tokens, true) || in_array('K2', $tokens, true)) {
        return 'RR-G3';
    }

    if (preg_match('/\b(10|11|12|[4-9])\b/', $value)) {
        return 'G4-10';
    }

    if (preg_match('/(?:GRADE|LEVEL)?\s*-?\s*(\d{1,2})/i', $value, $match)) {
        return ((int) $match[1] <= 3) ? 'RR-G3' : 'G4-10';
    }

    return 'G4-10';
};

$formatMoney = static function ($amount) {
    return number_format((float) $amount, 2);
};

$parseCsvNumbers = static function ($csv) {
    $parts = array_map('trim', explode(',', (string) $csv));
    $parts = array_filter($parts, static function ($value) {
        return $value !== '';
    });

    return array_map('floatval', $parts);
};

$incidentalsLabels = array(
    'PACEs',
    'TLE',
    'HELE',
    'MAPEH',
    'Parent Orientation',
    'Handbook',
    'Goal/Progress Chart Cover',
    'Flags',
    'ID',
    'Notebook',
    'Closing Fee',
    "Fetcher\'s ID",
    "Founder\'s Day",
    'Graduation Fee',
    'Congress Fee',
    'Late Fee',
    'CEM'
);

$gradeLabel = $gradeBand($row->gradelevel);
$assetBaseUrl = rtrim(dirname(site_url()), '/\\');

$logoDataUri = '';
$logoCandidates = array(
    FCPATH . 'assets/images/logo_portal.png',
    FCPATH . 'assets/images/dashboard_logo.png'
);

foreach ($logoCandidates as $logoPath) {
    if (is_readable($logoPath)) {
        $logoContent = @file_get_contents($logoPath);
        if ($logoContent !== false) {
            $logoDataUri = 'data:image/png;base64,' . base64_encode($logoContent);
            break;
        }
    }
}

$logoSrc = $logoDataUri !== '' ? $logoDataUri : ($assetBaseUrl . '/assets/images/logo_portal.png');

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

$line = static function ($width = 120) {
    return '<span class="fill" style="width:' . (int) $width . 'px;"></span>';
};

$renderIncidentals = static function () use ($incidentalsLabels) {
    foreach ($incidentalsLabels as $label) {
        ?>
        <div class="row-line"><span class="left-label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></span><span class="right-fill"></span></div>
        <?php
    }
};

$renderComputation = static function () use ($formatMoney, $tuition, $registration, $totalMiscellaneous, $totalIncidentals) {
    ?>
    <div class="row-line"><span class="left-label">TUITION</span><span class="money"><?= $formatMoney($tuition); ?></span></div>
    <div class="row-line"><span class="left-label">REGISTRATION</span><span class="money"><?= $formatMoney($registration); ?></span></div>
    <div class="row-line"><span class="left-label">TOTAL MISCELLANEOUS</span><span class="money"><?= $formatMoney($totalMiscellaneous); ?></span></div>
    <div class="row-line"><span class="left-label">TOTAL INCIDENTALS</span><span class="money"><?= $formatMoney($totalIncidentals); ?></span></div>
    <?php
};

$renderSummary = static function () use ($formatMoney, $totalAssessment) {
    ?>
    <div class="summary-box">
        <div class="s-row"><span>TOTAL ASSESSMENT:</span><span class="money"><?= $formatMoney($totalAssessment); ?></span></div>
        <div class="s-row"><span>Paid upon enrolment:</span><span class="s-fill"></span></div>
        <div class="s-row"><span>Balance:</span><span class="s-fill"></span></div>
        <div class="s-row due"><span>Due every 5<sup>th</sup> of the month:</span><span class="s-fill"></span></div>
        <div class="s-row"><span>Payment received by:</span><span class="s-fill"></span></div>
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
</head>
<body>
<div class="toolbar">
    <button onclick="window.print()">PRINT / SAVE PDF</button>
    <button onclick="window.close()">CLOSE</button>
</div>

<div class="page">
    <section class="single-copy">
        <div class="school-header">
            <img src="<?= htmlspecialchars($logoSrc, ENT_QUOTES, 'UTF-8'); ?>" alt="School Logo">
            <div class="school-lines">
                <div>CEBU BOB HUGHES CHRISTIAN ACADEMY, INC.</div>
                <div class="small">a Ministry of Cebu Bible Baptist Church, Inc.</div>
                <div class="small">55 Katipunan street, Brgy. Calamba, Cebu City 6000</div>
                <div class="small">Tel NO. 032-422-0700</div>
            </div>
        </div>

        <div class="copy-caption">FINANCIAL ASSESSEMENT FORM</div>

        <div class="meta-row">
            <div>NAME: <?= $line(245); ?></div>
            <div>DATE: <?= $line(95); ?></div>
        </div>
        <div class="meta-row">
            <div>GRADE:(<?= htmlspecialchars($gradeLabel, ENT_QUOTES, 'UTF-8'); ?>)<?= $line(90); ?></div>
            <div>S.Y.: <?= $line(95); ?></div>
        </div>

        <div class="section-grid">
            <div>
                <div class="section-head">INCIDENTALS</div>
                <?php $renderIncidentals(); ?>
            </div>
            <div>
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
            <div class="line"></div>
            Father's Signature over Printed Name
        </div>
        <div class="signature signature-mother">
            <div class="line"></div>
            Mother's Signature Over Printed Name
        </div>
    </section>
</div>

<div class="page">
    <section class="single-copy mini">
        <div class="mini-copy-label">STUDENT COPY</div>

        <div class="meta-row">
            <div>NAME: <?= $line(245); ?></div>
            <div>DATE: <?= $line(95); ?></div>
        </div>
        <div class="meta-row">
            <div>GRADE:(<?= htmlspecialchars($gradeLabel, ENT_QUOTES, 'UTF-8'); ?>)<?= $line(90); ?></div>
            <div>S.Y.: <?= $line(95); ?></div>
        </div>

        <div class="copy-caption">FINANCIAL ASSESSEMENT FORM</div>

        <div class="section-grid">
            <div>
                <div class="section-head">INCIDENTALS</div>
                <?php $renderIncidentals(); ?>
            </div>
            <div>
                <div class="section-head">TOTAL COMPUTATION</div>
                <?php $renderComputation(); ?>
                <?php $renderSummary(); ?>
            </div>
        </div>
    </section>
</div>

<div class="page">
    <section class="single-copy mini">
        <div class="office-label">ACCOUNTING OFFICE COPY</div>

        <div class="meta-row">
            <div>NAME: <?= $line(245); ?></div>
            <div>DATE: <?= $line(95); ?></div>
        </div>
        <div class="meta-row">
            <div>GRADE:(<?= htmlspecialchars($gradeLabel, ENT_QUOTES, 'UTF-8'); ?>)<?= $line(90); ?></div>
            <div>S.Y.: <?= $line(95); ?></div>
        </div>

        <div class="copy-caption">FINANCIAL ASSESSEMENT FORM</div>

        <div class="section-grid">
            <div>
                <div class="section-head">INCIDENTALS</div>
                <?php $renderIncidentals(); ?>
            </div>
            <div>
                <div class="section-head">TOTAL COMPUTATION</div>
                <?php $renderComputation(); ?>
                <?php $renderSummary(); ?>
            </div>
        </div>
    </section>
</div>
</body>
</html>
