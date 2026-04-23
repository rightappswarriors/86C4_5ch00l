<?php 
// ===== SAFE DATA DECODING =====
$fetcher_data = json_decode($record->fetcher_data ?? '[]', true);
$student_data = json_decode($record->student_data ?? '[]', true);
$reg_date     = date('F j, Y', strtotime($record->registered_date ?? 'now'));
$app_no       = str_pad($record->id ?? 0, 3, '0', STR_PAD_LEFT);

// ===== BUILD FULL NAME HELPER =====
function getFullName($row) {
    if (!is_array($row)) return '';
    if (!empty(trim($row['fullname'] ?? ''))) return trim($row['fullname']);
    return trim(($row['firstname'] ?? '') . ' ' . ($row['middlename'] ?? '') . ' ' . ($row['lastname'] ?? ''));
}

// ===== FETCHERS (EXACTLY 2 SLOTS - TOP) =====
$fetchers = [null, null];
if (is_array($fetcher_data)) {
    $i = 0;
    foreach ($fetcher_data as $f) {
        if ($i >= 2) break;
        $name = getFullName($f);
        if ($name !== '') {
            $fetchers[$i] = [
                'name' => $name,
                'rel'  => trim($f['relationship'] ?? '')
            ];
            $i++;
        }
    }
}

$fetcher1_photo = $record->fetcher_1_photo ?? '';
$fetcher2_photo = $record->fetcher_2_photo ?? '';
$fetcher1_photo_url = $fetcher1_photo ? base_url() . 'assets/images/fetcher_photos/' . $fetcher1_photo : '';
$fetcher2_photo_url = $fetcher2_photo ? base_url() . 'assets/images/fetcher_photos/' . $fetcher2_photo : '';

// ===== STUDENTS (ALL - BOTTOM) =====
$students = [];
if (is_array($student_data)) {
    foreach ($student_data as $s) {
        $name = getFullName($s);
        if ($name !== '') {
            $students[] = [
                'name'    => $name,
                'grade'   => trim($s['grade'] ?? ''),
                'section' => trim($s['section'] ?? '')
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fetcher ID - #<?= $app_no ?></title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        @page{size:letter;margin:0.5in}
        body{font-family:Arial,sans-serif;background:#fff;padding:20px}
        .sheet{width:8.5in;min-height:11in;background:#fff;margin:0 auto;padding:0.5in}
        
         /* School Header */
         .school-header{display:flex;align-items:center;margin-bottom:20px;border-bottom:2px solid #1e40af;padding-bottom:10px}
         .school-logo{width:55px;height:55px;margin-right:12px}
         .school-logo img{width:100%;height:auto;border-radius:50%}
         .school-info h1{font-size:13px;font-weight:700;color:#1e40af;margin-bottom:2px}
         .school-info p{font-size:8px;color:#555;line-height:1.3}
        
         /* Main ID Card */
         .id-card{width:4.75in;height:5.5in;border:3px solid #1e40af;padding:15px;margin:0 auto 25px;page-break-inside:avoid;background:#fff;display:flex;flex-direction:column}
         .card-header{display:flex;align-items:center;border-bottom:2px solid #1e40af;padding-bottom:8px;margin-bottom:12px}
         .card-logo{width:50px;height:50px;margin-right:10px}
         .card-logo img{width:100%;height:auto;border-radius:50%}
         .card-school h2{font-size:12px;font-weight:700;color:#1e40af;margin-bottom:1px}
         .card-school p{font-size:8px;color:#666}
        .card-title{text-align:center;font-size:22px;font-weight:700;color:#1e40af;margin:5px 0 10px;text-decoration:underline;text-transform:uppercase}
        
        .photo-boxes{display:flex;justify-content:space-around;margin-bottom:10px}
        .photo-box{width:2in;height:2in;border:2px solid #333;background:#fff;display:flex;align-items:center;justify-content:center;font-size:10px;color:#999;font-weight:600}
        
        .name-boxes{display:flex;justify-content:space-around;margin-bottom:8px}
        .name-box{width:2in;text-align:center;font-size:11px;font-weight:900;color:#000;padding:5px;border-bottom:1px solid #333;min-height:30px;display:flex;align-items:center;justify-content:center;text-transform:uppercase}
        
        .address-box{border:1px solid #333;padding:6px;text-align:center;font-size:9px;margin-bottom:15px;background:#f9fafb}
        
        .sig-boxes{display:flex;justify-content:space-around;margin-top:auto;margin-bottom:10px}
        .sig-box{width:1.8in;text-align:center;font-size:8px;font-weight:700;color:#333;border-top:1.5px solid #333;padding-top:3px;text-transform:uppercase}
        
        .card-footer{display:flex;justify-content:space-between;font-size:8px;font-weight:700;color:#333;border-top:2px solid #1e40af;padding-top:6px}
        
        /* Bottom Grid Section (BACK) */
        .grid-section{width:4.75in;height:5.5in;border:3px solid #1e40af;padding:20px;margin:0 auto;background:#fff}
        .grid-wrapper{display:grid;grid-template-columns:1fr 1fr;gap:15px 25px;justify-items:center;align-content:start}
        .grid-item{text-align:center;padding:5px}
        .grid-photo{width:1in;height:1in;border:1.5px solid #333;background:#fff;margin:0 auto 4px;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}
        .silhouette{width:100%;height:100%;position:relative}
        .silhouette:before{content:'';position:absolute;top:15%;left:50%;transform:translateX(-50%);width:35%;height:35%;background:#333;border-radius:50%}
        .silhouette:after{content:'';position:absolute;bottom:0;left:50%;transform:translateX(-50%);width:80%;height:45%;background:#333;border-radius:50% 50% 0 0}
        .grid-name{font-size:9px;font-weight:700;color:#000;text-transform:uppercase;line-height:1.2}
        
        /* Print Button */
        .print-btn{position:fixed;top:15px;right:15px;padding:10px 20px;background:#1e40af;color:#fff;border:none;border-radius:5px;cursor:pointer;font-size:13px;font-weight:600;z-index:999}
        .print-btn:hover{background:#1d4ed8}
        
        /* Back Button */
        .back-btn{position:fixed;top:15px;right:155px;padding:10px 20px;background:#6b7280;color:#fff;border:none;border-radius:5px;cursor:pointer;font-size:13px;font-weight:600;z-index:999;text-decoration:none}
        .back-btn:hover{background:#4b5563}
        
        @media print{
            body{background:#fff;padding:0}
            .sheet{box-shadow:none;margin:0;padding:0.5in}
            .print-btn,.back-btn{display:none}
        }
    </style>
</head>
<body>
    <a href="<?= site_url('students/fetcher_list') ?>" class="back-btn">← Back</a>
    <button class="print-btn" onclick="window.print()">🖨️ Print</button>
    <div class="sheet">
        
        <!-- School Header -->
        <div class="school-header">
            <div class="school-logo">
                <img src="<?=base_url()?>assets/images/logo_portal.png" alt="School Logo">
            </div>
            <div class="school-info">
                <h1>CEBU BOB HUGHES CHRISTIAN ACADEMY, INC.</h1>
                <p>a Ministry of Cebu Bible Baptist Church, Inc.<br>
                55 Katipunan street, Brgy. Calamba, Cebu City 6000<br>
                Tel No. 032-422-0700</p>
            </div>
        </div>

        <!-- ========== MAIN ID CARD ========== -->
        <div class="id-card">
            <div class="card-header">
                <div class="card-logo">
                    <img src="<?=base_url()?>assets/images/logo_portal.png" alt="School Logo">
                </div>
                <div class="card-school">
                    <h2>CEBU BOB HUGHES CHRISTIAN ACADEMY INC.</h2>
                    <p>55 Katipunan St. Brgy. Calamba Cebu City, 6000 Philippines</p>
                </div>
            </div>
            
            <div class="card-title">FETCHER</div>
            
            <div class="photo-boxes">
                <?php if ($fetcher1_photo): ?>
                <div class="photo-box"><img src="<?= $fetcher1_photo_url ?>" alt="Fetcher 1 Photo" style="width:100%;height:100%;object-fit:cover;"></div>
                <?php else: ?>
                <div class="photo-box">PHOTO</div>
                <?php endif; ?>
                <?php if ($fetcher2_photo): ?>
                <div class="photo-box"><img src="<?= $fetcher2_photo_url ?>" alt="Fetcher 2 Photo" style="width:100%;height:100%;object-fit:cover;"></div>
                <?php else: ?>
                <div class="photo-box">PHOTO</div>
                <?php endif; ?>
            </div>
            
            <div class="name-boxes">
                <div class="name-box"><?= htmlspecialchars(strtoupper($fetchers[0]['name'] ?? '')) ?></div>
                <div class="name-box"><?= htmlspecialchars(strtoupper($fetchers[1]['name'] ?? '')) ?></div>
            </div>
            
            <div class="address-box">
                55 Katipunan St. Brgy. Calamba<br>
                Cebu City Philippines
            </div>
            
            <div class="sig-boxes">
                <div class="sig-box">AUTHORIZED SIGNATURE</div>
                <div class="sig-box">AUTHORIZED SIGNATURE</div>
            </div>
            
            <div class="card-footer">
                <span>Valid for SY 2025-2026</span>
                <span>Control # <?= $app_no ?></span>
            </div>
        </div>

        <!-- ========== BOTTOM GRID: ALL FETCHERS ========== -->
        <div class="grid-section">
            <div class="grid-wrapper">

                <?php foreach ($students as $s): ?>
                <div class="grid-item">
                    <div class="grid-photo">
                        <div class="silhouette"></div>
                    </div>
                    <div class="grid-name"><?= htmlspecialchars(strtoupper($s['name'])) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
    </div>
</body>
</html>