<?php
session_start();
require_once '../../includes/dbh.inc.php';

header('Content-Type: application/json'); // Set JSON response

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Authorization check
        if (!isset($_SESSION['user']['Role']) || $_SESSION['user']['Role'] !== 'Moderator') {
            throw new Exception("Access Denied!");
        }

        // Input validation
        if (empty($_POST['report_id']) || empty($_POST['penalty_type'])) {
            throw new Exception("Missing required fields!");
        }

        if (empty($_POST['report_id'])) {
            throw new Exception("Report ID is missing!");
        }
        if (empty($_POST['penalty_type'])) {
            throw new Exception("Penalty type is missing!");
        }
        if (!isset($_POST['reason']) || trim($_POST['reason']) === '') {
            throw new Exception("Reason is missing or empty!");
        }

        $reportId = $_POST['report_id'];
        $penaltyType = $_POST['penalty_type'];
        $duration = $_POST['duration'] ?? 0;
        $reason = $_POST['reason'];

        // Get Squad ID from report
        $stmt = $pdo->prepare("SELECT Reported_User_ID FROM tbl_reports WHERE Report_ID = ?");
        $stmt->execute([$reportId]);
        $squadId = $stmt->fetchColumn();

        // Insert penalty
        $stmt = $pdo->prepare("INSERT INTO tbl_penalties 
                            (Squad_ID, Penalty_Type, Duration_Days, Start_Date, End_Date, Reason)
                            VALUES (?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL ? DAY), ?)");
        $stmt->execute([$squadId, $penaltyType, $duration, $duration, $reason]);

        // Update report status
        $stmt = $pdo->prepare("UPDATE tbl_reports 
                            SET Report_Status = 'Action Taken', 
                                Reviewed_By = ?, 
                                Date_Reviewed = NOW() 
                            WHERE Report_ID = ?");
        $stmt->execute([$_SESSION['user']['User_ID'], $reportId]);

        // Return success response
        echo json_encode([
            'status' => 'success',
            'message' => 'Penalty applied successfully!'
        ]);
        
    } catch (Exception $e) {
        // Return error response
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
    exit();
}