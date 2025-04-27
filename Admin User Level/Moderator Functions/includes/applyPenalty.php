<?php
session_start();
header('Content-Type: application/json'); // Must be first output
error_reporting(0); // Disable error display

require_once 'includes/dbh.inc.php';

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method");
    }

    // Validate required fields
    $required = ['report_id', 'penalty_type', 'reason'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    $reportId = $_POST['report_id'];
    $penaltyType = $_POST['penalty_type'];
    $duration = $_POST['duration'] ?? 0;
    $reason = $_POST['reason'];

    // Get Squad ID from the report
    $stmt = $pdo->prepare("SELECT Reported_User_ID FROM tbl_reports WHERE Report_ID = ?");
    $stmt->execute([$reportId]);
    $squadId = $stmt->fetchColumn();

    // Calculate penalty duration
    $startDate = date('Y-m-d H:i:s');
    $endDate = ($penaltyType === 'ban') ? null : date('Y-m-d H:i:s', strtotime("+$duration days"));

    // Insert into penalties table
    $stmt = $pdo->prepare("INSERT INTO tbl_penalties 
                        (Squad_ID, Penalty_Type, Duration_Days, Start_Date, End_Date, Reason)
                        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$squadId, $penaltyType, $duration, $startDate, $endDate, $reason]);

    // Update report status
    $stmt = $pdo->prepare("UPDATE tbl_reports 
                        SET Report_Status = 'Action Taken', 
                            Reviewed_By = ?, 
                            Date_Reviewed = NOW() 
                        WHERE Report_ID = ?");
    $stmt->execute([$_SESSION['user_id'], $reportId]);
    
    echo json_encode(['status' => 'success', 'message' => 'Penalty applied successfully']);
} catch (Throwable $e) { // Catch all errors
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}