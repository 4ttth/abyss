<?php
$config = include('/includes/config.php');
$cloudflareToken = $config['CLOUDFLARE_TOKEN'];
$zoneId = 'your-zone-id';

// Fetch Cloudflare analytics
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/$zoneId/analytics/dashboard");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $cloudflareToken",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
$data = json_decode($response, true);

if ($data && $data['success']) {
    $analytics = $data['result']['timeseries'];
    $totals = $data['result']['totals'];
    
    // Calculate metrics
    $uniqueVisitors = $totals['uniques']['all'];
    $totalRequests = $totals['requests']['all'];
    $percentCached = ($totals['cached']['all'] / $totalRequests) * 100;
    
    // Country traffic data
    $countryQuery = json_encode([
        'query' => '
            query {
                viewer {
                    zones(filter: { zoneTag: "'.$zoneId.'" }) {
                        httpRequests1dGroups(limit: 10, orderBy: [sum_Requests_DESC]) {
                            sum {
                                countryMap {
                                    clientCountryName
                                    requests
                                }
                            }
                        }
                    }
                }
            }'
    ]);
    
    curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/graphql");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $countryQuery);
    $countryResponse = curl_exec($ch);
    $countryData = json_decode($countryResponse, true);
    
    $countries = [];
    $countryRequests = [];
    if ($countryData['data']['viewer']['zones'][0]['httpRequests1dGroups']) {
        foreach ($countryData['data']['viewer']['zones'][0]['httpRequests1dGroups'] as $group) {
            foreach ($group['sum']['countryMap'] as $country) {
                $countries[] = $country['clientCountryName'];
                $countryRequests[] = $country['requests'];
            }
        }
    }
    
    echo json_encode([
        'uniqueVisitors' => $uniqueVisitors,
        'totalRequests' => $totalRequests,
        'percentCached' => round($percentCached, 1),
        'countries' => $countries,
        'countryRequests' => $countryRequests
    ]);
} else {
    echo json_encode(['error' => 'Failed to fetch analytics']);
}
curl_close($ch);
?>