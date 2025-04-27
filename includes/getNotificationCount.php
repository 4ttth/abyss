<?php
session_start();
require_once 'dbh.inc.php';

header('Content-Type: application/json');

try {
    $count = 0;
    if (isset($_SESSION['user']['Squad_ID'])) {
        $stmt = $pdo->prepare("SELECT COUNT(*) 
                              FROM tbl_inviteslog 
                              WHERE Squad_ID = ? AND Response = 'Pending'");
        $stmt->execute([$_SESSION['user']['Squad_ID']]);
        $count = $stmt->fetchColumn();
    }
    echo json_encode(['count' => $count]);
} catch (PDOException $e) {
    echo json_encode(['count' => 0]);
}