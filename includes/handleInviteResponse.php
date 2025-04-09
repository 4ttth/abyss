<?php
session_start();
require_once 'dbh.inc.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$scheduleId = $data['schedule_id'] ?? null;
$action = $data['action'] ?? null;

if (!$scheduleId || !in_array($action, ['Accepted', 'Declined'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

try {
    $pdo->beginTransaction();
    
    // 1. Update the invite response
    $stmt = $pdo->prepare("UPDATE tbl_inviteslog SET Response = ? WHERE Schedule_ID = ?");
    $stmt->execute([$action, $scheduleId]);
    
    // 2. If accepted, create scrim record
    if ($action === 'Accepted') {
        // Get invite details
        $stmtInvite = $pdo->prepare("SELECT * FROM tbl_inviteslog WHERE Schedule_ID = ?");
        $stmtInvite->execute([$scheduleId]);
        $invite = $stmtInvite->fetch(PDO::FETCH_ASSOC);
        
        if ($invite) {
            // Determine status based on current time
            $currentTime = time();
            $scrimTime = strtotime($invite['Scrim_Date'] . ' ' . $invite['Scrim_Time']);
            $status = ($currentTime > $scrimTime) ? 'Finished' : 'Upcoming';
            
            // Insert into scrims log
            $stmtScrim = $pdo->prepare("INSERT INTO tbl_scrimslog 
                (Squad1_ID, Squad2_ID, Scheduled_Time, No_Of_Games, Status) 
                VALUES (?, ?, ?, ?, ?)");
            $stmtScrim->execute([
                $invite['Challenger_Squad_ID'],
                $invite['Squad_ID'],
                $invite['Scrim_Date'],
                $invite['No_Of_Games'] . ' ' .$invite['Scrim_Time'],
                $status
            ]);
        }
    }
    
    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Error processing invite: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error']);
}