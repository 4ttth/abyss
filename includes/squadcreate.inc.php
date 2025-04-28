<?php
session_start();
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $squadName = trim($_POST['Squad_Name']);
    $squadAcr = trim($_POST['Squad_Acronym']);
    $squadDesc = trim($_POST['Squad_Description']);
    $squadLevel = trim($_POST['Squad_Level']);
    $userID = $_SESSION['user_id'];

    if (empty($squadName) || empty($squadAcr) || empty($squadLevel)) {
        $_SESSION['error'] = "Please fill in all required squad fields.";
        header("Location: ../squadCreation.php");
        exit();
    }

    try {
        $pdo->beginTransaction();

        // Generate a new Squad_ID if it doesn't exist in the session
        if (!isset($_SESSION['Squad_ID']) || empty($_SESSION['Squad_ID'])) {
            // Insert squad profile without Squad_ID (let the database generate it)
            $sql = "INSERT INTO tbl_squadprofile (Squad_Name, Squad_Acronym, Squad_Description, Squad_Level, User_ID)
                    VALUES (:squadName, :squadAcr, :squadDesc, :squadLevel, :userID)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':squadName' => $squadName,
                ':squadAcr' => $squadAcr,
                ':squadDesc' => $squadDesc,
                ':squadLevel' => $squadLevel,
                ':userID' => $userID
            ]);

            // Get the newly created Squad_ID
            $squadID = $pdo->lastInsertId();

            // Update the session with the new Squad_ID
            $_SESSION['Squad_ID'] = $squadID;
        } else {
            $squadID = $_SESSION['Squad_ID'];
        }

        // Calculations for Player Count and Total Stars
        $query = "SELECT COUNT(*) AS Player_Count, SUM(Highest_Score) AS Total_Stars FROM tbl_playerprofile WHERE Squad_ID = :squadID";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':squadID' => $squadID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $playerCount = $result['Player_Count'] ?? 0;
        $totalStars = $result['Total_Stars'] ?? 0;
        $averageStar = ($playerCount > 0) ? ($totalStars / $playerCount) : 0;

        // Update squad profile with computed values
        $updateSql = "UPDATE tbl_squadprofile SET Player_Count = :playerCount, Total_Stars = :totalStars, Average_Star = :averageStar WHERE Squad_ID = :squadID";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([
            ':playerCount' => $playerCount,
            ':totalStars' => $totalStars,
            ':averageStar' => $averageStar,
            ':squadID' => $squadID
        ]);

        $pdo->commit();

        $_SESSION['success'] = "Squad created successfully!";
        header("Location: ../userHomepage.php");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Error creating squad: " . $e->getMessage();
        header("Location: ../squadCreation.php");
        exit();
    }
}
