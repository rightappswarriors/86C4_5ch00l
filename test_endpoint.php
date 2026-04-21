<?php
// Quick test script
$url = 'http://localhost/86C4_5ch00L/index.php/interviews/ajax_get_by_date';
$data = ['date' => '2026-04-21'];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ],
];
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
echo "Response length: " . strlen($result) . "\n";
echo "First 500 chars:\n";
echo substr($result, 0, 500);