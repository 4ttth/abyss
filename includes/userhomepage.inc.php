<?php
require_once 'dbh.inc.php';

// Check if the user is logged in and has a Squad_ID
if (!isset($_SESSION['user']['Squad_ID']) || empty($_SESSION['user']['Squad_ID'])) {
    // If no squad, set default values
    $squadDetails = [
        'Squad_Acronym' => 'N/A',
        'Squad_Name' => 'N/A',
        'Squad_ID' => 'N/A',
        'Squad_Level' => 'N/A',
        'Squad_Description' => 'N/A'
    ];
} else {
    // Fetch squad details from the database
    try {
        $squadID = $_SESSION['user']['Squad_ID'];
        $stmt = $pdo->prepare("SELECT * FROM tbl_squadprofile WHERE Squad_ID = ?"); // Ensure the table name is correct
        $stmt->execute([$squadID]);
        $squadDetails = $stmt->fetch(PDO::FETCH_ASSOC);


        // If no squad is found, set default values
        if (!$squadDetails) {
            $squadDetails = [
                'Squad_Acronym' => 'N/A',
                'Squad_Name' => 'N/A',
                'Squad_ID' => 'N/A',
                'Squad_Level' => 'N/A',
                'Squad_Description' => 'N/A'
            ];
        }
    } catch (PDOException $e) {
        // Handle database errors
        die("Database error: " . $e->getMessage());
    }
}

// Pass squad details to the session for use in userHomepage.php
$_SESSION['squad_details'] = $squadDetails;
?>



