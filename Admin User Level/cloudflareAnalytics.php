<!-- filepath: c:\xampp\htdocs\abyss\includes\cloudflareAnalytics.php -->
<?php
$config = include('config.php');
$cloudflareToken = $config['CLOUDFLARE_TOKEN'];
$zoneId = 'your-zone-id'; // Replace with your Cloudflare Zone ID

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/$zoneId/analytics/dashboard");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $cloudflareToken",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if ($data && $data['success']) {
    $analytics = $data['result']['timeseries'];
    $labels = [];
    $requests = [];
    $bandwidth = [];

    foreach ($analytics as $point) {
        $labels[] = $point['since'];
        $requests[] = $point['requests']['all'];
        $bandwidth[] = $point['bandwidth']['all'] / (1024 * 1024); // Convert to MB
    }

    echo json_encode([
        'labels' => $labels,
        'requests' => $requests,
        'bandwidth' => $bandwidth
    ]);
} else {
    echo json_encode(['error' => 'Failed to fetch analytics']);
}
?>