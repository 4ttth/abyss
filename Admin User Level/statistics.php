<!-- filepath: c:\xampp\htdocs\abyss\includes\statistics.php -->
<?php
require_once '../includes/dbh.inc.php';

$statistics = [];

// Fetch counts for each table
$queries = [
    'Players' => "SELECT COUNT(*) AS count FROM tbl_playerprofile",
    'Users' => "SELECT COUNT(*) AS count FROM tbl_useraccount",
    'Reports (Pending)' => "SELECT COUNT(*) AS count FROM tbl_reports WHERE Status = 'Pending'",
    'Reports (Action Taken)' => "SELECT COUNT(*) AS count FROM tbl_reports WHERE Status = 'Action Taken'",
    'Reports (Total)' => "SELECT COUNT(*) AS count FROM tbl_reports",
    'Scrim Invites (Pending)' => "SELECT COUNT(*) AS count FROM tbl_inviteslog WHERE Response = 'Pending'",
    'Scrim Invites (Accepted)' => "SELECT COUNT(*) AS count FROM tbl_inviteslog WHERE Response = 'Accepted'",
    'Scrim Invites (Declined)' => "SELECT COUNT(*) AS count FROM tbl_inviteslog WHERE Response = 'Declined'",
    'Scrim Invites (Total)' => "SELECT COUNT(*) AS count FROM tbl_inviteslog",
    'Scrims (Finished)' => "SELECT COUNT(*) AS count FROM tbl_scrimslog WHERE Status = 'Finished'",
    'Scrims (Upcoming)' => "SELECT COUNT(*) AS count FROM tbl_scrimslog WHERE Status = 'Upcoming'",
    'Scrims (Total)' => "SELECT COUNT(*) AS count FROM tbl_scrimslog",
    'Squad Posts (Public)' => "SELECT COUNT(*) AS count FROM tbl_squadposts WHERE Visibility = 'Public'",
    'Squad Posts (Private)' => "SELECT COUNT(*) AS count FROM tbl_squadposts WHERE Visibility = 'Private'",
    'Squad Posts (Total)' => "SELECT COUNT(*) AS count FROM tbl_squadposts",
    'Squads (Amateur)' => "SELECT COUNT(*) AS count FROM tbl_squadprofile WHERE Type = 'Amateur'",
    'Squads (Professional)' => "SELECT COUNT(*) AS count FROM tbl_squadprofile WHERE Type = 'Professional'",
    'Squads (Collegiate)' => "SELECT COUNT(*) AS count FROM tbl_squadprofile WHERE Type = 'Collegiate'",
    'Squads (Total)' => "SELECT COUNT(*) AS count FROM tbl_squadprofile",
    'Conversations' => "SELECT COUNT(*) AS count FROM tbl_conversations",
    'Messages' => "SELECT COUNT(*) AS count FROM tbl_messages",
    'Match Verifications (Pending)' => "SELECT COUNT(*) AS count FROM tbl_matchverifications WHERE Status = 'Pending'",
    'Match Verifications (Approved)' => "SELECT COUNT(*) AS count FROM tbl_matchverifications WHERE Status = 'Approved'",
    'Match Verifications (Rejected)' => "SELECT COUNT(*) AS count FROM tbl_matchverifications WHERE Status = 'Rejected'",
    'Penalties' => "SELECT COUNT(*) AS count FROM tbl_penalties",
    'Verification Requests (Pending)' => "SELECT COUNT(*) AS count FROM tbl_verificationrequests WHERE Status = 'Pending'",
    'Verification Requests (Approved)' => "SELECT COUNT(*) AS count FROM tbl_verificationrequests WHERE Status = 'Approved'",
    'Verification Requests (Rejected)' => "SELECT COUNT(*) AS count FROM tbl_verificationrequests WHERE Status = 'Rejected'",
    'Verification Requests (Total)' => "SELECT COUNT(*) AS count FROM tbl_verificationrequests"
];

foreach ($queries as $label => $query) {
    $result = $pdo->query($query);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $statistics[] = ['label' => $label, 'value' => $row['count']];
}

// Prepare data for Chart.js
$labels = array_column($statistics, 'label');
$values = array_column($statistics, 'value');

echo json_encode(['labels' => $labels, 'values' => $values]);
?>