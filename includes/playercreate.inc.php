<?php
session_start();
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if user has squad
    if (!isset($_SESSION['user']['Squad_ID']) || empty($_SESSION['user']['Squad_ID'])) {
        $_SESSION['error'] = "You must create a squad first!";
        header("Location: ../squadCreation.php");
        exit();
    }

    // Get form data
    $ign = trim($_POST['IGN']);
    $fullName = trim($_POST['Full_Name']);
    $gameID = trim($_POST['Game_ID']);
    $currentRank = trim($_POST['Current_Rank']);
    $currentStar = (int)$_POST['Current_Star'];
    $highestRank = trim($_POST['Highest_Rank']);
    $highestStar = (int)$_POST['Highest_Star'];
    $role = trim($_POST['Role']);
    $heroNames = array_map('trim', [$_POST['Hero_1'], $_POST['Hero_2'], $_POST['Hero_3']]);

    // Validate required fields
    if (empty($ign) || empty($fullName) || empty($gameID) || empty($role)) {
        $_SESSION['error'] = "Please fill in all required player fields";
        header("Location: ../squadCreation.php");
        exit();
    }

    try {
        $pdo->beginTransaction();

        // Get hero names directly from form submission
        $hero1 = trim($_POST['Hero_1']);
        $hero2 = trim($_POST['Hero_2']);
        $hero3 = trim($_POST['Hero_3']);

        // Assign hero names directly
        $heroNames = [$hero1, $hero2, $hero3];

        // Insert player
        $sql = "INSERT INTO tbl_playerprofile (
                    Squad_ID, IGN, Full_Name, Game_ID, 
                    Current_Rank, Current_Star, Highest_Rank, Highest_Star, Role,
                    Hero_1, Hero_2, Hero_3
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_SESSION['user']['Squad_ID'],
            $ign,
            $fullName,
            $gameID,
            $currentRank,
            $currentStar,
            $highestRank,
            $highestStar,
            $role,
            $hero1,  
            $hero2,
            $hero3
        ]);

        $pdo->commit();

        $_SESSION['success'] = "Player added successfully!";
        header("Location: ../squadCreation.php");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Error adding player: " . $e->getMessage();
        header("Location: ../squadCreation.php");
        exit();
    }
} else {
    header("Location: ../squadCreation.php");
    exit();
}
