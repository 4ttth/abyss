<?php
session_start();
require_once 'dbh.inc.php'; // Make sure this path is correct


// Clear any previous output
ob_clean();


header('Content-Type: application/json');


try {
    // Validate session and permissions
    if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['Moderator' || 'Admin'])) {
        throw new Exception('Access Denied');
    }


    // Validate input
    if (!isset($_POST['squad_id']) || !is_numeric($_POST['squad_id'])) {
        throw new Exception('Invalid Squad ID');
    }


    $squadId = (int)$_POST['squad_id'];
   
    // Query database
    $stmt = $pdo->prepare("
        SELECT IGN, First_Name, Last_Name, Game_ID, Current_Rank, Current_Star, Highest_Rank, Highest_Star, Role, Hero_1, Hero_2, Hero_3
        FROM tbl_playerprofile
        WHERE Squad_ID = ?
    ");
    $stmt->execute([$squadId]);
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // Return JSON response
    die(json_encode([
        'success' => true,
        'data' => $players
    ]));


} catch (Exception $e) {
    // Return error response
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]));
}
?>