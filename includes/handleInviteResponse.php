<?php
session_start();
header('Content-Type: application/json');

require_once 'dbh.inc.php';

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

    // Debugging: Log the schedule ID and action
    error_log("Processing invite: Schedule ID = $scheduleId, Action = $action");

    // Update the invite response
    $stmt = $pdo->prepare("UPDATE tbl_inviteslog SET Response = ? WHERE Schedule_ID = ?");
    $stmt->execute([$action, $scheduleId]);

    // Debugging: Check if the update was successful
    if ($stmt->rowCount() === 0) {
        throw new Exception("No rows updated in tbl_inviteslog for Schedule_ID = $scheduleId");
    }

    if ($action === 'Accepted') {
        $stmtInvite = $pdo->prepare("SELECT * FROM tbl_inviteslog WHERE Schedule_ID = ?");
        $stmtInvite->execute([$scheduleId]);
        $invite = $stmtInvite->fetch(PDO::FETCH_ASSOC);

        // Debugging: Check if the invite was fetched
        if (!$invite) {
            throw new Exception("Invite not found for Schedule_ID = $scheduleId");
        }

        $currentTime = time();
        $scrimTime = strtotime($invite['Scrim_Date'] . ' ' . $invite['Scrim_Time']);
        $status = ($currentTime > $scrimTime) ? 'Finished' : 'Upcoming';

        $stmtScrim = $pdo->prepare("INSERT INTO tbl_scrimslog 
            (Squad1_ID, Squad2_ID, Scheduled_Time, No_Of_Games, Status) 
            VALUES (?, ?, ?, ?, ?)");
        $stmtScrim->execute([
            $invite['Challenger_Squad_ID'],
            $invite['Squad_ID'],
            $invite['Scrim_Date'] . ' ' . $invite['Scrim_Time'],
            $invite['No_Of_Games'],
            $status
        ]);

        // Debugging: Check if the scrim was inserted
        if ($stmtScrim->rowCount() === 0) {
            throw new Exception("Failed to insert scrim into tbl_scrimslog");
        }

        $stmtConvo = $pdo->prepare("INSERT INTO tbl_conversations 
            (Squad1_ID, Squad2_ID, Last_Message_ID, Last_Message_Time, Updated_At, Squad1_Unread, Squad2_Unread) 
            VALUES (?, ?, NULL, NULL, CURRENT_TIMESTAMP, 0, 0)");
        $stmtConvo->execute([
            $invite['Challenger_Squad_ID'],
            $invite['Squad_ID']
        ]);

        // Debugging: Check if the conversation was inserted
        $conversationId = $pdo->lastInsertId();
        if (!$conversationId) {
            throw new Exception("Failed to insert conversation into tbl_conversations");
        }

        $systemMessage = "Match accepted!\n\n" .
            "Challenger Squad ID: {$invite['Challenger_Squad_ID']}\n" .
            "Opponent Squad ID: {$invite['Squad_ID']}\n" .
            "Scheduled on: {$invite['Scrim_Date']} at {$invite['Scrim_Time']}\n" .
            "Number of Games: {$invite['No_Of_Games']}\n\n" .
            "You can now chat and prepare with each other here!";

        $stmtMessage = $pdo->prepare("INSERT INTO tbl_messages 
            (Conversation_ID, Sender_Squad_ID, Recipient_Squad_ID, Content, Is_Read, Created_At) 
            VALUES (?, ?, ?, ?, 0, NOW())");
        $stmtMessage->execute([
            $conversationId,
            1,
            $invite['Challenger_Squad_ID'],
            $systemMessage
        ]);

        // Debugging: Check if the message was inserted
        $messageId = $pdo->lastInsertId();
        if (!$messageId) {
            throw new Exception("Failed to insert message into tbl_messages");
        }

        $stmtUpdateConvo = $pdo->prepare("UPDATE tbl_conversations 
            SET Last_Message_ID = ?, Last_Message_Time = NOW(), 
                Squad1_Unread = Squad1_Unread + 1, 
                Squad2_Unread = Squad2_Unread + 1 
            WHERE Conversation_ID = ?");
        $stmtUpdateConvo->execute([$messageId, $conversationId]);
    }

    $pdo->commit();
    echo json_encode(['success' => true]);
    exit;
} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Error processing invite: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing the invite']);
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Error processing invite: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing the invite']);
    exit;
}