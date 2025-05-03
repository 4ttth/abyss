<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json');

$cloudflareToken = 'G5o5Hsy8myNXtNjy7ge8hAWCmmsN47kD90beFxqF';
$zoneId = '06f62b29f5cdc6aa62ea7c2a02c1812f';

// Fetch Cloudflare analytics
$analyticsUrl = "https://api.cloudflare.com/client/v4/zones/$zoneId/analytics/dashboard";
$options = [
    'http' => [
        'method' => 'GET',
        'header' => "Authorization: Bearer $cloudflareToken\r\n" .
                    "Content-Type: application/json\r\n"
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($analyticsUrl, false, $context);

if ($response === false) {
    echo json_encode(['error' => 'Failed to fetch analytics data']);
    exit;
}

$data = json_decode($response, true);

if ($data && $data['success']) {
    $totals = $data['result']['totals'];
    
    // Calculate metrics
    $totalRequests = $totals['requests']['all'];
    $uniqueVisitors = $totals['uniques']['all'];
    $percentCached = $totalRequests > 0 
        ? round(($totals['cached']['all'] / $totalRequests) * 100, 1)
        : 0;

    // Country traffic data
    $graphqlQuery = json_encode([
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

    $graphqlOptions = [
        'http' => [
            'method' => 'POST',
            'header' => "Authorization: Bearer $cloudflareToken\r\n" .
                        "Content-Type: application/json\r\n",
            'content' => $graphqlQuery
        ]
    ];

    $graphqlContext = stream_context_create($graphqlOptions);
    $countryResponse = file_get_contents(
        'https://api.cloudflare.com/client/v4/graphql',
        false,
        $graphqlContext
    );

    $countries = [];
    $countryRequests = [];
    
    if ($countryResponse !== false) {
        $countryData = json_decode($countryResponse, true);
        if (isset($countryData['data']['viewer']['zones'][0]['httpRequests1dGroups'])) {
            foreach ($countryData['data']['viewer']['zones'][0]['httpRequests1dGroups'] as $group) {
                foreach ($group['sum']['countryMap'] as $country) {
                    $countries[] = $country['clientCountryName'];
                    $countryRequests[] = $country['requests'];
                }
            }
        }
    }

    echo json_encode([
        'uniqueVisitors' => $uniqueVisitors,
        'totalRequests' => $totalRequests,
        'percentCached' => $percentCached,
        'countries' => $countries,
        'countryRequests' => $countryRequests
    ]);
} else {
    echo json_encode(['error' => 'Invalid analytics response']);
}
?>