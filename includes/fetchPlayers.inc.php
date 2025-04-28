<?php
require_once 'dbh.inc.php';

// Fetch hero paths
$heroPaths = [];
try {
    $heroQuery = "SELECT Hero_Name, Path FROM tbl_heroimages";
    $heroStmt = $pdo->query($heroQuery);
    $heroPaths = $heroStmt->fetchAll(PDO::FETCH_KEY_PAIR); 
} catch (PDOException $e) {
    die("Error fetching hero data: " . $e->getMessage());
}

$squadID = $_GET['squad_id'] ?? null;

if ($squadID) {
    $stmt = $pdo->prepare("SELECT * FROM tbl_playerprofile WHERE Squad_ID = ?");
    $stmt->execute([$squadID]);
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($players as $index => $player) {
        echo '<div class="memberProfile">';
        echo '<div class="role">' . htmlspecialchars($player['Role']) . ' // player 00' . ($index + 1) . '</div>';
        echo '<div class="IGN">' . htmlspecialchars($player['IGN']) . '</div>';
        echo '<div class="detailsTitle">NAME</div>';
        echo '<div class="detailsDescription">' . htmlspecialchars($player['Full_Name']) . '</div>';
        echo '<div class="detailsTitle">GAME ID</div>';
        echo '<div class="detailsDescription">' . htmlspecialchars($player['Game_ID']) . '</div>';
        echo '<div class="detailsTitle">CURRENT RANK</div>';
        echo '<div class="detailsDescription">' . htmlspecialchars($player['Current_Rank']) . ' ' . htmlspecialchars($player['Current_Star']) . '<i class="bi bi-star-fill star"></i></div>';
        echo '<div class="detailsTitle">HIGHEST RANK</div>';
        echo '<div class="detailsDescription">' . htmlspecialchars($player['Highest_Rank']) . ' ' . htmlspecialchars($player['Highest_Star']) . '<i class="bi bi-star-fill star"></i></div>';
        echo '<div class="detailsTitle">HERO POOL</div>';
        echo '<div class="heroCircles">';
        foreach (['Hero_1', 'Hero_2', 'Hero_3'] as $heroField) {
            $heroName = $player[$heroField] ?? '';
            $heroImage = $heroName ? ($heroPaths[$heroName] ?? '') : '';
            echo '<img src="' . htmlspecialchars($heroImage) . '" class="hero-icon" alt="' . htmlspecialchars($heroName) . '" title="' . htmlspecialchars($heroName) . '">';
        }
        echo '</div>';
        echo '</div>';
    }
}
?>