<?php
require_once '../../includes/dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reportId = $_POST['report_id'];
    $penaltyType = $_POST['penalty_type'];
    $duration = $_POST['duration'] ?? 0;
    $reason = $_POST['reason'];
    
    try {
        // Get Squad ID from the report
        $stmt = $pdo->prepare("SELECT Reported_User_ID FROM tbl_reports WHERE Report_ID = ?");
        $stmt->execute([$reportId]);
        $squadId = $stmt->fetchColumn();

        // Calculate penalty duration
        $startDate = date('Y-m-d H:i:s');
        $endDate = date('Y-m-d H:i:s', strtotime("+$duration days"));
        
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
        
        echo "success";
    } catch (PDOException $e) {
        die("Error applying penalty: " . $e->getMessage());
    }
}