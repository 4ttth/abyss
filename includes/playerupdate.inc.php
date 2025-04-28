<?php
session_start();
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $pdo->beginTransaction();
        
        $sql = "UPDATE tbl_playerprofile SET
            IGN = ?,
            First_Name = ?,
            Last_Name = ?,
            Game_ID = ?,
            Current_Rank = ?,
            Current_Star = ?,
            Highest_Rank = ?,
            Highest_Star = ?,
            Role = ?,
            Hero_1 = ?,
            Hero_2 = ?,
            Hero_3 = ?
            WHERE Player_ID = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['IGN'],
            $_POST['First_Name'],
            $_POST['Last_Name'],
            $_POST['Game_ID'],
            $_POST['Current_Rank'],
            $_POST['Current_Star'],
            $_POST['Highest_Rank'],
            $_POST['Highest_Star'],
            $_POST['Role'],
            $_POST['Hero_1'],
            $_POST['Hero_2'],
            $_POST['Hero_3'],
            $_POST['player_id']
        ]);
        
        $pdo->commit();
        $_SESSION['success'] = "Player updated successfully!";
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Error updating player: " . $e->getMessage();
    }
    header("Location: ../editSquad.php");
    exit();
}