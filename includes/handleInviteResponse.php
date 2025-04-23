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
    
    // 2. If accepted, create scrim record and conversation
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
            
            // Insert into conversations table
            $stmtConvo = $pdo->prepare("INSERT INTO tbl_conversations 
                (Squad1_ID, Squad2_ID, Last_Message_ID, Last_Message_Time, Updated_At, Squad1_Unread, Squad2_Unread) 
                VALUES (?, ?, NULL, NULL, CURRENT_TIMESTAMP, 0, 0)");
            $stmtConvo->execute([
                $invite['Challenger_Squad_ID'],
                $invite['Squad_ID']
            ]);

            // AUTOMATED PART 2 ATE
            // 1. Get last inserted conversation ID
            $conversationId = $pdo->lastInsertId();

            // 2. Prepare the system message
            $systemMessage = "Match accepted!\n\n" .
            "Challenger Squad ID: {$invite['Challenger_Squads_ID']}\n" .
            "Opponent Squad ID: {$invite['Squad_ID']}\n" .
            "Scheduled on: {$invite['Scrim_Date']} at {$invite['Scrim_Time']}\n" .
            "Number of Games: {$invite['No_Of_Games']}\n\n" .
            "You can now chat and prepare with each other here!";        

            // 3. Insert the system message into tbl_messages
            $stmtMessage = $pdo->prepare("INSERT INTO tbl_messages 
                (Conversation_ID, Sender_Squad_ID, Recipient_Squad_ID, Content, Is_Read, Created_At) 
                VALUES (?, ?, ?, ?, 0, NOW())");
            $stmtMessage->execute([
                $conversationId,
                1, // Use 0 or another special value to indicate "System"
                $invite['Challenger_Squad_ID'],
                $systemMessage
            ]);


            // 4. Get the message ID
            $messageId = $pdo->lastInsertId();

            // 5. Update tbl_conversations with message info
            $stmtUpdateConvo = $pdo->prepare("UPDATE tbl_conversations 
                SET Last_Message_ID = ?, Last_Message_Time = NOW(), 
                    Squad1_Unread = Squad1_Unread + 1, 
                    Squad2_Unread = Squad2_Unread + 1 
                WHERE Conversation_ID = ?");
            $stmtUpdateConvo->execute([$messageId, $conversationId]);
        }
    }
    
    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Error processing invite: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);

}