<?php
session_start();
require_once '/includes/dbh.inc.php';

// 1. Validate session FIRST
if (!isset($_SESSION['user']['Role']) || !in_array($_SESSION['user']['Role'], ['Moderator'])) {
    header('Content-Type: application/json');
    die(json_encode(['success' => false, 'error' => 'Unauthorized']));
}

// 2. Validate POST parameters
if (empty($_POST['request_id']) || empty($_POST['action'])) {
    header('Content-Type: application/json');
    die(json_encode(['success' => false, 'error' => 'Missing parameters']));
}

try {
    // 3. Prepare SQL statement
    $stmt = $pdo->prepare("
        UPDATE tbl_verificationrequests 
        SET Status = :status, 
            Date_Reviewed = NOW() 
        WHERE Request_ID = :request_id
    ");

    // 4. Bind parameters explicitly
    $status = ($_POST['action'] === 'approve') ? 'Approved' : 'Rejected';
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':request_id', $_POST['request_id']);

    // 5. Execute and check result
    if (!$stmt->execute()) {
        throw new Exception('Database update failed');
    }

    // 6. Return SUCCESS response
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // 7. Proper error handling
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'error' => 'Server error: ' . $e->getMessage()
    ]);
}