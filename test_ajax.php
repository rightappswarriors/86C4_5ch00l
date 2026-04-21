<?php
echo "Testing endpoint...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost/86C4_5ch00L/index.php/interviews/ajax_get_by_date");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, ['date' => '2026-04-21']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$response = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "HTTP Code: " . $info['http_code'] . "\n";
echo "Response:\n";
echo $response;