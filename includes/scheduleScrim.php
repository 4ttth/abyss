<?php
session_start();
require_once 'dbh.inc.php';

// Get raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Extract data
$squadId = $data['squadId']; // Opponent squad (Squad_ID)
$scrimDate = $data['date'];
$scrimTime = $data['time'];
$scrimNotes = $data['notes'];

// Get challenger's squad ID from session
$challengerSquadId = $_SESSION['user']['Squad_ID']; // Challenger_Squad_ID

// Default values
$status = "Pending"; // Default status
$createdAt = date('Y-m-d H:i:s'); // Current timestamp

try {
    $query = "INSERT INTO tbl_inviteslog 
              (Challenger_Squad_ID, Squad_ID, Scrim_Date, Scrim_Time, No_Of_Games, Status, Created_At) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
              
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        $challengerSquadId,
        $squadId,
        $scrimDate,
        $scrimTime,
        $scrimNotes,
        $status,
        $createdAt
    ]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to schedule scrim."]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
}