<?php
// Test the endpoint
$url = 'http://localhost/86C4_5ch00L/index.php/interviews/ajax_get_by_date';
$postData = http_build_query(['date' => '2026-04-21']);

$options = [
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                    "Content-Length: " . strlen($postData) . "\r\n",
        'content' => $postData,
        'ignore_errors' => true // Fetch response even on 404/500
    ]
];
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

echo "=== Response ===\n";
echo $result;
echo "\n=== End Response ===\n";