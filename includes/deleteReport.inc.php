<?php
session_start();
require_once 'dbh.inc.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['Moderator'])) {
    exit("Access Denied!");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $report_id = $_POST['report_id'];
    $moderator_id = $_SESSION['user_id'];

    try {
        $pdo->beginTransaction();
        
        // Update report status and add moderator info
        $sql = "UPDATE tbl_reports 
                SET Report_Status = 'Deleted',
                    Reviewed_By = ?,
                    Date_Reviewed = CURRENT_TIMESTAMP 
                WHERE Report_ID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$moderator_id, $report_id]);

        $pdo->commit();
        $_SESSION['success'] = "Report deleted successfully!";
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Error deleting report: " . $e->getMessage();
    }
    header("Location: /Moderator User Level/modReports.php");
    exit();
}