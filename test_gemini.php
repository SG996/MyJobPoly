<?php
// Test Gemini với model alias và X-goog-api-key header
$apiKey = 'AIzaSyDkvyi2L_Afln2e6A3pw1LqQ48IPv77lIE';

$models = [
    'gemini-flash-latest',
    'gemini-2.0-flash',
    'gemini-2.0-flash-lite',
    'gemini-pro-latest',
    'gemini-1.5-flash-latest',
];

$payload = json_encode([
    'contents' => [['parts' => [['text' => 'Say OK in one word']]]],
    'generationConfig' => ['maxOutputTokens' => 10],
]);

echo "=== Gemini API Test (X-goog-api-key header) ===\n\n";

foreach ($models as $model) {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            "X-goog-api-key: {$apiKey}",
        ],
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $body   = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err    = curl_error($ch);
    curl_close($ch);

    $data = json_decode($body, true);

    if ($err) {
        echo "[ $model ] ❌ cURL error: $err\n";
    } elseif ($status === 200) {
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '(no text)';
        echo "[ $model ] ✅ HOẠT ĐỘNG! Response: " . trim($text) . "\n";
    } elseif ($status === 429) {
        $msg = $data['error']['message'] ?? '';
        // Trich thong tin limit cu the
        preg_match('/limit: (\d+)/', $msg, $m);
        $limit = $m[1] ?? '?';
        echo "[ $model ] ⚠️  429 Quota exceeded (limit={$limit})\n";
        if (str_contains($msg, 'limit: 0')) {
            echo "          → Free tier bị vô hiệu hoá trên key này\n";
        }
    } elseif ($status === 403) {
        echo "[ $model ] ❌ 403 Forbidden: " . ($data['error']['message'] ?? '') . "\n";
    } elseif ($status === 404) {
        echo "[ $model ] ❌ 404 Model không tồn tại\n";
    } else {
        echo "[ $model ] ❌ HTTP $status: " . substr($body, 0, 200) . "\n";
    }

    usleep(300000);
}
echo "\n=== Done ===\n";
