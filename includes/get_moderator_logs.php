<?php
session_start();
require_once 'dbh.inc.php';


header('Content-Type: application/json');


if (!in_array($_SESSION['user_role'], ['Admin'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}


if (!isset($_POST['moderator_id'])) {
    echo json_encode(['error' => 'Moderator ID missing']);
    exit;
}


$modId = (int)$_POST['moderator_id'];


$sql = "SELECT Date, Time, Action FROM tbl_auditlogs WHERE Moderator_ID = ? ORDER BY Date DESC, Time DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$modId]);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($logs);
?>