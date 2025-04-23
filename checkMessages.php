<?php
session_start();
require_once 'dbh.inc.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

if (!isset($_GET['conversation_id'])) {
    echo json_encode(['error' => 'No conversation ID']);
    exit();
}

$conversationId = $_GET['conversation_id'];
$lastId = $_GET['last_id'] ?? 0;
$currentSquadId = $_SESSION['user']['Squad_ID'];

// Verify the current squad is part of this conversation
$stmt = $pdo->prepare("SELECT * FROM tbl_conversations 
                      WHERE Conversation_ID = ? 
                      AND (Squad1_ID = ? OR Squad2_ID = ?)");
$stmt->execute([$conversationId, $currentSquadId, $currentSquadId]);
$conversation = $stmt->fetch();

if (!$conversation) {
    echo json_encode(['error' => 'Invalid conversation']);
    exit();
}

// Get new messages
$stmt = $pdo->prepare("SELECT m.*, s.Squad_Name as Sender_Name
                      FROM tbl_messages m
                      JOIN tbl_squadprofile s ON m.Sender_Squad_ID = s.Squad_ID
                      WHERE m.Conversation_ID = ? AND m.Message_ID > ?
                      ORDER BY m.Created_At ASC");
$stmt->execute([$conversationId, $lastId]);
$newMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mark messages as read
if (!empty($newMessages)) {
    $stmt = $pdo->prepare("UPDATE tbl_messages 
                          SET Is_Read = TRUE 
                          WHERE Conversation_ID = ? 
                          AND Recipient_Squad_ID = ?
                          AND Message_ID > ?");
    $stmt->execute([$conversationId, $currentSquadId, $lastId]);
    
    // Update unread count in conversation
    $stmt = $pdo->prepare("UPDATE tbl_conversations 
                          SET Squad1_Unread = IF(Squad1_ID = ?, 0, Squad1_Unread),
                              Squad2_Unread = IF(Squad2_ID = ?, 0, Squad2_Unread)
                          WHERE Conversation_ID = ?");
    $stmt->execute([$currentSquadId, $currentSquadId, $conversationId]);
}

echo json_encode(['newMessages' => $newMessages]);
?>