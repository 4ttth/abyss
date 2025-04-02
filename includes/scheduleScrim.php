<?php
// Database connection
session_start(); // Start the session
    require_once 'includes/dbh.inc.php'; 

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Extract data from the request
$squadId = $data['squadId'];
$date = $data['date'];
$time = $data['time'];
$notes = $data['notes'];

// Insert the scrim schedule into the database
try {
    $query = "INSERT INTO tbl_scrimschedules (Squad_ID, Scrim_Date, Scrim_Time, Scrim_Notes) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$squadId, $date, $time, $notes]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to schedule scrim."]);
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Database error"]);
}

?>