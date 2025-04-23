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

    $baseScores = [
        'Warrior I' => 0,
        'Warrior II' => 0,
        'Warrior III' => 0,
        'Elite I' => 100,
        'Elite II' => 100,
        'Elite III' => 100,
        'Elite IV' => 100,
        'Master I' => 200,
        'Master II' => 200,
        'Master III' => 200,
        'Master IV' => 200,
        'Grandmaster I' => 300,
        'Grandmaster II' => 300,
        'Grandmaster III' => 300,
        'Grandmaster IV' => 300,
        'Grandmaster V' => 300,
        'Epic I' => 400,
        'Epic II' => 400,
        'Epic III' => 400,
        'Epic IV' => 400,
        'Epic V' => 400,
        'Legend I' => 500,
        'Legend II' => 500,
        'Legend III' => 500,
        'Legend IV' => 500,
        'Legend V' => 500,
        'Mythic' => 600,
        'Mythical Honor' => 600,
        'Mythical Glory' => 600,
        'Mythical Immortal' => 600
    ];


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

    $highestScore = isset($baseScores[$highestRank]) ? $baseScores[$highestRank] + $highestStar : $highestStar;

    // Validate required fields
    if (empty($ign) || empty($fullName) || empty($gameID) || empty($role)) {
        $_SESSION['error'] = "Please fill in all required player fields";
        header("Location: ../squadCreation.php");
        exit();
    }

    // ====== VALIDATION CONFIGURATION ======
    $rankConfig = [
        // Warrior
        'Warrior I' => ['min' => 0, 'max' => 3, 'tier' => 1],
        'Warrior II' => ['min' => 0, 'max' => 3, 'tier' => 1],
        'Warrior III' => ['min' => 0, 'max' => 3, 'tier' => 1],
        // Elite
        'Elite I' => ['min' => 0, 'max' => 3, 'tier' => 2],
        'Elite II' => ['min' => 0, 'max' => 3, 'tier' => 2],
        'Elite III' => ['min' => 0, 'max' => 3, 'tier' => 2],
        'Elite IV' => ['min' => 0, 'max' => 3, 'tier' => 2],
        // Master
        'Master I' => ['min' => 0, 'max' => 4, 'tier' => 3],
        'Master II' => ['min' => 0, 'max' => 4, 'tier' => 3],
        'Master III' => ['min' => 0, 'max' => 4, 'tier' => 3],
        'Master IV' => ['min' => 0, 'max' => 4, 'tier' => 3],
        // Grandmaster
        'Grandmaster I' => ['min' => 0, 'max' => 5, 'tier' => 4],
        'Grandmaster II' => ['min' => 0, 'max' => 5, 'tier' => 4],
        'Grandmaster III' => ['min' => 0, 'max' => 5, 'tier' => 4],
        'Grandmaster IV' => ['min' => 0, 'max' => 5, 'tier' => 4],
        'Grandmaster V' => ['min' => 0, 'max' => 5, 'tier' => 4],
        // Epic
        'Epic I' => ['min' => 0, 'max' => 5, 'tier' => 5],
        'Epic II' => ['min' => 0, 'max' => 5, 'tier' => 5],
        'Epic III' => ['min' => 0, 'max' => 5, 'tier' => 5],
        'Epic IV' => ['min' => 0, 'max' => 5, 'tier' => 5],
        'Epic V' => ['min' => 0, 'max' => 5, 'tier' => 5],
        // Legend
        'Legend I' => ['min' => 0, 'max' => 5, 'tier' => 6],
        'Legend II' => ['min' => 0, 'max' => 5, 'tier' => 6],
        'Legend III' => ['min' => 0, 'max' => 5, 'tier' => 6],
        'Legend IV' => ['min' => 0, 'max' => 5, 'tier' => 6],
        'Legend V' => ['min' => 0, 'max' => 5, 'tier' => 6],
        // Mythic
        'Mythic' => ['min' => 0, 'max' => 24, 'tier' => 7],
        'Mythical Honor' => ['min' => 25, 'max' => 49, 'tier' => 8],
        'Mythical Glory' => ['min' => 50, 'max' => 99, 'tier' => 9],
        'Mythical Immortal' => ['min' => 100, 'max' => PHP_INT_MAX, 'tier' => 10]
    ];

    // Validate Current Rank
    if (!isset($rankConfig[$currentRank])) {
        $_SESSION['error'] = "Invalid current rank: $currentRank";
        header("Location: ../squadCreation.php");
        exit();
    }

    // Validate Current Stars
    $currentConf = $rankConfig[$currentRank];
    if ($currentStar < $currentConf['min'] || ($currentConf['max'] !== PHP_INT_MAX && $currentStar > $currentConf['max'])) {
        $_SESSION['error'] = "Current stars for $currentRank must be {$currentConf['min']}-{$currentConf['max']}";
        header("Location: ../squadCreation.php");
        exit();
    }

    // Validate Highest Rank
    if (!isset($rankConfig[$highestRank])) {
        $_SESSION['error'] = "Invalid highest rank: $highestRank";
        header("Location: ../squadCreation.php");
        exit();
    }

    // Validate Highest Stars
    $highestConf = $rankConfig[$highestRank];
    if ($highestStar < $highestConf['min'] || ($highestConf['max'] !== PHP_INT_MAX && $highestStar > $highestConf['max'])) {
        $_SESSION['error'] = "Highest stars for $highestRank must be {$highestConf['min']}-{$highestConf['max']}";
        header("Location: ../squadCreation.php");
        exit();
    }

    // Tier Validation: Highest rank cannot be lower than current rank NEEDED BA TO
    if ($rankConfig[$highestRank]['tier'] < $rankConfig[$currentRank]['tier']) {
        $_SESSION['error'] = "Highest rank ($highestRank) cannot be lower than current rank ($currentRank)";
        header("Location: ../squadCreation.php");
        exit();
    }

    // Same-Tier Star Validation
    if ($rankConfig[$highestRank]['tier'] == $rankConfig[$currentRank]['tier']) {
        if ($highestStar < $currentStar) {
            $_SESSION['error'] = "Highest stars ($highestStar) cannot be less than current stars ($currentStar) for the same tier";
            header("Location: ../squadCreation.php");
            exit();
        }
    }
    // ====== VALIDATION END ======

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
                    Current_Rank, Current_Star, Highest_Rank, Highest_Star, Highest_Score, Role,
                    Hero_1, Hero_2, Hero_3
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
            $highestScore,
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
