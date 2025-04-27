<?php
session_start();
require_once '../includes/dbh.inc.php';
header('Content-Type: application/json'); // Add this

error_reporting(E_ALL);
ini_set('display_errors', 1);


try {
    // Validate session first
    if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['Moderator'])) {
        throw new Exception("Access Denied: Invalid permissions");
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method");
    }

    // Validate inputs
    $requestId = filter_input(INPUT_POST, 'request_id', FILTER_VALIDATE_INT);
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
    
    if (!$requestId || !in_array($action, ['approve', 'reject'])) {
        throw new Exception("Invalid parameters: request_id=$requestId, action=$action");
    }

    // Database update
    $status = ($action === 'approve') ? 'Approved' : 'Rejected';
    $dateReviewed = date('Y-m-d H:i:s');
    
    $stmt = $pdo->prepare("UPDATE tbl_verificationrequests 
                          SET Status = :status, Date_Reviewed = :date_reviewed
                          WHERE Request_ID = :request_id");
    $stmt->execute([
        ':status' => $status,
        ':date_reviewed' => $dateReviewed,
        ':request_id' => $requestId
    ]);

    if ($stmt->rowCount() === 0) {
        throw new Exception("No rows affected - invalid Request_ID?");
    }

    echo json_encode(['success' => true]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage(),
        'trace' => $e->getTrace() // Remove in production
    ]);
}