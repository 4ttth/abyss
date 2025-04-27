<?php
session_start();
require_once 'dbh.inc.php';
require_once 'sendEmail.inc.php';
require 'config.php'; // Include the email function

// Get raw POST data
$data = json_decode(file_get_contents('php://input'), true);
$hostname = $config['HOST_NAME'];

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
    // Fetch challenger squad details
    $challengerQuery = "SELECT Squad_Acronym, Squad_Description, Squad_Level FROM tbl_squadprofile WHERE Squad_ID = ?";
    $challengerStmt = $pdo->prepare($challengerQuery);
    $challengerStmt->execute([$challengerSquadId]);
    $challengerDetails = $challengerStmt->fetch(PDO::FETCH_ASSOC);

    if (!$challengerDetails) {
        throw new Exception("Challenger squad details not found.");
    }

    $challengerAcronym = htmlspecialchars($challengerDetails['Squad_Acronym']);
    $challengerDescription = htmlspecialchars($challengerDetails['Squad_Description']);
    $challengerLevel = htmlspecialchars($challengerDetails['Squad_Level']);

    // Insert scrim details into the database
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
        // Prepare email details
        $subject = "Scrim Match Invitation";
        $body = "
            <h1>Scrim Match Invitation</h1>
            <p>Your squad has been invited to a scrim match by:</p>
            <ul>
                <li><strong>Squad Acronym:</strong> $challengerAcronym</li>
                <li><strong>Squad Description:</strong> $challengerDescription</li>
                <li><strong>Squad Level:</strong> $challengerLevel</li>
            </ul>
            <p>Scrim Details:</p>
            <ul>
                <li><strong>Date:</strong> $scrimDate</li>
                <li><strong>Time:</strong> $scrimTime</li>
                <li><strong>Number of Games:</strong> $scrimNotes</li>
            </ul>
            <p>Please <a href='https://$hostname'>log in</a> to your account to respond to the invitation.</p>
        ";

        // Send email to the target squad
        sendEmailToSquad($pdo, $squadId, $subject, $body);

        // Respond with success
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to schedule scrim."]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Email error: " . $e->getMessage()]);
}