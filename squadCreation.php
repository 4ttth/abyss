<?php
session_start();
require_once '/includes/dbh.inc.php';

use chillerlan\QRCode\{QRCode, QROptions};
require_once 'vendor/autoload.php';


// Initialize user data from sessions
$user = $_SESSION['user'] ?? ['username' => 'Guest', 'Squad_ID' => 'N/A'];
if (!$_SESSION['user']['verified']) {
    $_SESSION['error'] = "Please verify your email to proceed.";
    header("Location: verifyEmail.php");
    exit();
}
try {
    if (isset($_SESSION['user']['username'])) {
        // Fetch ALL user data from database using session username
        $query = "SELECT * FROM tbl_useraccount WHERE Username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $_SESSION['user']['username'], PDO::PARAM_STR);
        $stmt->execute();
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_data) {
            // Update session with latest data (including Squad_ID)
            $_SESSION['user'] = $user_data;
            $user = $user_data; // For direct use in HTML
        }
    }
} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}

// Verification check
$verificationStatus = 'Pending';
if (isset($_SESSION['user']['Squad_ID']) && !empty($_SESSION['user']['Squad_ID'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM tbl_verificationrequests WHERE Squad_ID = ? ORDER BY Date_Submitted DESC LIMIT 1");
        $stmt->execute([$_SESSION['user']['Squad_ID']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $verificationStatus = $result['Status'] ?? 'Not Submitted';
        $verificationLevel = $result['Squad_Level'] ?? 'Amateur';
    } catch (PDOException $e) {
        // Handle error if needed
    }
}

// Hero check
$heroPaths = [];
try {
    $heroQuery = "SELECT Hero_Name, Path FROM tbl_heroimages";
    $heroStmt = $pdo->query($heroQuery);
    $heroPaths = $heroStmt->fetchAll(PDO::FETCH_KEY_PAIR); // Creates [Hero_Name => Path]
} catch (PDOException $e) {
    // Handle error if needed
    die("Error fetching hero data: " . $e->getMessage());
}

if (isset($_SESSION['user']['Squad_ID'])) {
    $stmtPlayers = $pdo->prepare("SELECT * FROM tbl_playerprofile WHERE Squad_ID = ?");
    $stmtPlayers->execute([$_SESSION['user']['Squad_ID']]);
    $players = $stmtPlayers->fetchAll(PDO::FETCH_ASSOC);
} else {
    $players = [];
}

// Generate QR Code URL
$config = include('/includes/config.php');
$hostName = "https://" . $config['HOST_NAME'];
$squadID = $_SESSION['user']['Squad_ID'] ?? 'N/A';
$encodedsquadID = base64_encode($squadID);
$encodedUsername = base64_encode($user['Username'] ?? 'Guest');
$qrURL = $hostName . "/playerCreation.php?squad_id=" . $encodedsquadID . "&username=" . $encodedUsername;
$options = new QROptions([
    'version' => 5,
    'eccLevel' => QRCode::ECC_H,
    'scale' => 5,
    'imageBase64' => true,
    'imageTransparent' => false,
    'foregroundColor' => '#000000',
    'backgroundColor' => '#ffffff'
]);

$qrcode = (new QRCode)->render($qrURL);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Squad Creation</title>
    <link rel="stylesheet" type="text/css" href="CSS/squadCreationStyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="IMG/essentials/whiteVer.PNG">
</head>

<body class="customPageBackground">
    <div class="introScreen">
        <div class="loadingAnimation"></div>
    </div>
    <div class="pageContent hiddenContent">
        <!-- Navigation Bar -->
        <div class="container-fluid jos">        
            <div class="row">
                <div class="container-fluid navigationBar">
                    <!-- Logo Layer -->
                    <div class="logoLayer">
                        <!-- Logo and Name -->
                        <a class="navbar-brand" href="index.php">
                            <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                            <div class="logoText">abyss</div>
                        </a>
                        
                        <form class="searchBar" aria-disabled="true" style="opacity: 0.5; pointer-events: none;">
                            <input class="searchInput" type="search" name="query" placeholder="Search Squads" aria-label="Search" disabled>
                            <button class="searchButton" type="submit" disabled>
                                <img src="IMG/essentials/whiteVer.PNG" alt="Search">
                            </button>
                        </form>              
                    
                        <!-- Navbar Toggle Button -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="guestDiscoverPage.php">DISCOVER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="aboutUsPage.php">ABOUT US</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid jis">
            <div class="row w-100">
                <div class="col content">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['error'];
                            unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['success'];
                            unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>
                    <!-- Account Information -->
                    <div class="row">

                        <div class="accountUsername">
                            <?php echo htmlspecialchars($user['Username']); ?>
                        </div>
                        <div class="accountNumber">
                            <?php echo htmlspecialchars($user['Squad_ID']); ?>
                        </div>

                        <div class="text">
                            <form action="/includes/logout.inc.php" method="post">
                                <button class="logoutButton"> LOGOUT </button>
                            </form>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="row textBlockLeft">
                        <div class="descriptionLeft">
                            REGISTER YOUR COMRADES AS OFFICIAL
                        </div>
                        <div class="titleLeft">
                            SQUAD PLAYERS
                        </div>
                        <div class="subtitleLeft">
                            CREATE SEPARATE PROFILES FOR EACH PLAYERS
                        </div>
                    </div>

                    <!-- Static QR Code -->
                    <div class="qr-wrapper">
                        <div class="qr-code">
                            <?php printf('<img width="150px" height="150px" src="%s" alt="$s" />', $qrcode, $qrURL);;?>
                            <div class="qr-text">Scan to Add Player</div>
                        </div>
                    </div>

                    <!-- Squad Members Profile -->
                    <div class="profiles-wrapper">
                        <div class="profiles">
                            <?php $playerIndex = 1; ?>
                            <?php foreach ($players as $player): ?>
                                <div class="memberProfile">
                                    
                                    <div class="role"><?= htmlspecialchars($player['Role']) ?> &nbsp; // &nbsp; <?= htmlspecialchars($player['View_ID']) ?></div>
                                    <div class="IGN"><?= htmlspecialchars($player['IGN']) ?></div>
                                    <div class="detailsTitle">NAME</div>
                                    <div class="detailsDescription"><?= htmlspecialchars($player['Full_Name']) ?></div>
                                    <div class="detailsTitle">GAME ID</div>
                                    <div class="detailsDescription"><?= htmlspecialchars($player['Game_ID']) ?></div>
                                    <div class="detailsTitle">CURRENT RANK</div>
                                    <div class="detailsDescription"><?= htmlspecialchars($player['Current_Rank']) ?> &nbsp; <?= htmlspecialchars($player['Current_Star']) ?><i class="bi bi-star-fill star"></i></div>
                                    <div class="detailsTitle">HIGHEST RANK</div>
                                    <div class="detailsDescription"><?= htmlspecialchars($player['Highest_Rank']) ?> &nbsp; <?= htmlspecialchars($player['Highest_Star']) ?><i class="bi bi-star-fill star"></i></div>
                                    <div class="detailsTitle">HERO POOL</div>
                                    <div class="heroCircles">
                                        <?php foreach (['Hero_1', 'Hero_2', 'Hero_3'] as $heroField): ?>
                                            <?php
                                            $heroName = $player[$heroField] ?? '';
                                            $heroImage = $heroName ? ($heroPaths[$heroName] ?? '') : '';
                                            ?>
                                            <img src="<?= $heroImage ?>" class="hero-icon" alt="<?= $heroName ?>" title="<?= $heroName ?>">
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php $playerIndex += 1; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Title -->
                    <?php if ($verificationStatus === 'Pending') : ?>
                    <div class="titleLeft">
                        CREATE YOUR SQUAD PROFILE
                    </div>
                    <?php else : ?>
                        <div class="titleLeft">
                        VERIFY YOUR SQUAD LEVEL
                    </div>
                    <?php endif;?>
                    <form action="/includes/squadcreate.inc.php" method="post">
                        <?php if ($verificationStatus === 'Pending') : ?>
                        <div class="row">
                            <!-- Squad Name Field -->
                            <div class="form-group mt-3 col-8">
                                <label class="form-label title">SQUAD NAME</label>
                                <input type="text" name="Squad_Name" class="form-control plchldr"
                                    placeholder="Enter Squad Name">
                            </div>

                            <!-- Squad Aronym Field -->
                            <div class="form-group mt-3 col-4">
                                <label class="form-label title">SQUAD ACRONYM</label>
                                <input type="text" name="Squad_Acronym" class="form-control plchldr"
                                    placeholder="Enter Squad Acronym">
                            </div>
                        </div>

                        <!-- Squad Description Field -->
                        <div class="form-group mt-3">
                            <label class="form-label title">SQUAD DESCRIPTION</label>
                            <input type="text" name="Squad_Description" class="form-control plchldr"
                                placeholder="Enter Squad Description">
                        </div>
                        <div class="row align-items-center">
                            <!-- Squad Level Field -->
                            <div class="form-group mt-3 col-4">
                                <label class="form-label title">SQUAD LEVEL</label>
                                <div class="verifyLevel d-flex align-items-center">
                                    <!-- Dropdown with Caret -->
                                    <?php if (!($verificationStatus === 'Pending')) : ?>
                                    <div class="dropdown-wrapper">
                                        <select name="Squad_Level" class="form-control plchldr squadLevelDropdown">
                                            <option value="Amateur">Amateur</option>
                                            <option value="Collegiate">Collegiate</option>
                                            <option value="Professional">Professional</option>
                                        </select>
                                        <i class="bi bi-caret-down-fill dropdown-icon"></i>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($verificationStatus === 'Pending') : ?>
                                        <div class="alert alert-warning">Verification Pending - <?= $verificationLevel ?> Level</div>
                                        <input type="hidden" name="Squad_Level" class="form-control plchldr" value="<?= $verificationLevel ?>">
                                    <?php else : ?>
                                        <button type="button" class="btn verifyButton" data-bs-toggle="modal" data-bs-target="#squadVerificationModal">
                                            VERIFY
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else : ?>
                        <div class="row align-items-center">
                            <!-- Squad Level Field -->
                            <div class="form-group mt-3 col-4">
                                <label class="form-label title">SQUAD LEVEL</label>
                                <div class="verifyLevel d-flex align-items-center">
                                    <!-- Dropdown with Caret -->
                                    <?php if (!($verificationStatus === 'Pending')) : ?>
                                    <div class="dropdown-wrapper">
                                        <select name="Squad_Level" class="form-control plchldr squadLevelDropdown">
                                            <option value="Amateur">Amateur</option>
                                            <option value="Collegiate">Collegiate</option>
                                            <option value="Professional">Professional</option>
                                        </select>
                                        <i class="bi bi-caret-down-fill dropdown-icon"></i>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($verificationStatus === 'Pending') : ?>
                                        <div class="alert alert-warning">Verification Pending - <?= $verificationLevel ?> Level</div>
                                        <input type="hidden" name="Squad_Level" class="form-control plchldr" value="<?= $verificationLevel ?>">
                                    <?php else : ?>
                                        <button type="button" class="btn verifyButton" data-bs-toggle="modal" data-bs-target="#squadVerificationModal">
                                            VERIFY
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Empty Column for Spacing -->
                            <div class="col-4"></div>

                            <!-- Signup Button -->
                            <div class="col-4 text-end mt-3">
                            <?php if ($verificationStatus === 'Pending') : ?>
                                <form action="/includes/squadcreate.inc.php" method="post">
                                    <button type="submit" class="btn loginButton">CREATE SQUAD</button>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </form>

                    <!-- END HERE -->

                    <!-- TESTESTESETESETSETSETSETS -->
                    <!-- Hero Selection Modal -->
                    <div class="modal fade" id="heroModal" tabindex="-1" aria-labelledby="heroModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content customModal">
                                <!-- Tank -->
                                <!-- tbl_heroimages Hero_ID Hero_Name   Hero_Role Path -->
                                <div class="modal-header">
                                    <div class="heroModalLabel" id="heroModalLabel">Tank</div>
                                </div>
                                <div class="modal-body">
                                    <div class="hero-grid">
                                        <img src="IMG/hero/Tank/tnk-1.png" class="hero-icon" data-hero-name="Tigreal" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-2.png" class="hero-icon" data-hero-name="Akai" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-3.png" class="hero-icon" data-hero-name="Franco" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-4.png" class="hero-icon" data-hero-name="Hylos" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-5.png" class="hero-icon" data-hero-name="Uranus" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-6.png" class="hero-icon" data-hero-name="Belerick" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-7.png" class="hero-icon" data-hero-name="Khufra" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-8.png" class="hero-icon" data-hero-name="Baxia" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-9.png" class="hero-icon" data-hero-name="Atlas" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-10.png" class="hero-icon" data-hero-name="Gloo" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-11.png" class="hero-icon" data-hero-name="Ghatotkacha" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-12.png" class="hero-icon" data-hero-name="Grock" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-13.png" class="hero-icon" data-hero-name="Minotaur" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-14.png" class="hero-icon" data-hero-name="Johnson" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-15.png" class="hero-icon" data-hero-name="Esmeralda" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-16.png" class="hero-icon" data-hero-name="Barats" onclick="selectHero(this)">
                                        <img src="IMG/hero/Tank/tnk-17.png" class="hero-icon" data-hero-name="Edith" onclick="selectHero(this)">
                                    </div>
                                </div>

                                <!-- Fighter -->
                                <div class="modal-header">
                                    <div class="heroModalLabel" id="heroModalLabel">Fighter</div>
                                </div>
                                <div class="modal-body">
                                    <div class="hero-grid">
                                        <img src="IMG/hero/Fighter/ft-1.png" class="hero-icon" data-hero-name="Balmond" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-2.png" class="hero-icon" data-hero-name="Freya" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-3.png" class="hero-icon" data-hero-name="Chou" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-4.png" class="hero-icon" data-hero-name="Sun" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-5.png" class="hero-icon" data-hero-name="Alpha" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-6.png" class="hero-icon" data-hero-name="Ruby" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-7.png" class="hero-icon" data-hero-name="Lapu-Lapu" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-8.png" class="hero-icon" data-hero-name="Argus" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-9.png" class="hero-icon" data-hero-name="Jawhead" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-10.png" class="hero-icon" data-hero-name="Martis" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-11.png" class="hero-icon" data-hero-name="Aldous" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-12.png" class="hero-icon" data-hero-name="Leomord" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-13.png" class="hero-icon" data-hero-name="Thamuz" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-14.png" class="hero-icon" data-hero-name="Minsitthar" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-15.png" class="hero-icon" data-hero-name="Badang" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-16.png" class="hero-icon" data-hero-name="Guinevere" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-17.png" class="hero-icon" data-hero-name="X.Borg" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-18.png" class="hero-icon" data-hero-name="Dyrroth" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-19.png" class="hero-icon" data-hero-name="Masha" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-20.png" class="hero-icon" data-hero-name="Silvanna" onclick="selectHero(this)">
                                        <img src="IMG/hero/Fighter/ft-21.png" class="hero-icon" data-hero-name="Yu Zhong" onclick="selectHero(this)">
                                    </div>
                                </div>

                                <!-- Assassin -->
                                <div class="modal-header">
                                    <div class="heroModalLabel" id="heroModalLabel">Assassin</div>
                                </div>
                                <div class="modal-body">
                                    <div class="hero-grid">
                                        <img src="IMG/hero/Assassin/ass-1.png" class="hero-icon" data-hero-name="Saber" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-2.png" class="hero-icon" data-hero-name="Karina" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-3.png" class="hero-icon" data-hero-name="Fanny" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-4.png" class="hero-icon" data-hero-name="Hayabusa" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-5.png" class="hero-icon" data-hero-name="Natalia" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-6.png" class="hero-icon" data-hero-name="Lancelot" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-7.png" class="hero-icon" data-hero-name="Helcurt" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-8.png" class="hero-icon" data-hero-name="Gusion" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-9.png" class="hero-icon" data-hero-name="Hanzo" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-10.png" class="hero-icon" data-hero-name="Ling" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-11.png" class="hero-icon" data-hero-name="Aamon" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-12.png" class="hero-icon" data-hero-name="Joy" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-13.png" class="hero-icon" data-hero-name="Nolan" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-14.png" class="hero-icon" data-hero-name="Yi Sun-shin" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-15.png" class="hero-icon" data-hero-name="Harley" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-16.png" class="hero-icon" data-hero-name="Selena" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-17.png" class="hero-icon" data-hero-name="Benedetta" onclick="selectHero(this)">
                                        <img src="IMG/hero/Assassin/ass-18.png" class="hero-icon" data-hero-name="Suyou" onclick="selectHero(this)">
                                    </div>
                                </div>

                                <!-- Mage -->
                                <div class="modal-header">
                                    <div class="heroModalLabel" id="heroModalLabel">Mage</div>
                                </div>
                                <div class="modal-body">
                                    <div class="hero-grid">
                                        <img src="IMG/hero/Mage/mg-1.png" class="hero-icon" data-hero-name="Nana" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-2.png" class="hero-icon" data-hero-name="Eudora" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-3.png" class="hero-icon" data-hero-name="Gord" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-4.png" class="hero-icon" data-hero-name="Kagura" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-5.png" class="hero-icon" data-hero-name="Cyclops" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-6.png" class="hero-icon" data-hero-name="Aurora" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-7.png" class="hero-icon" data-hero-name="Vexana" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-8.png" class="hero-icon" data-hero-name="Odette" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-9.png" class="hero-icon" data-hero-name="Zhask" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-10.png" class="hero-icon" data-hero-name="Pharsa" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-11.png" class="hero-icon" data-hero-name="Valir" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-12.png" class="hero-icon" data-hero-name="Chang'e" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-13.png" class="hero-icon" data-hero-name="Vale" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-14.png" class="hero-icon" data-hero-name="Lunox" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-15.png" class="hero-icon" data-hero-name="Harith" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-16.png" class="hero-icon" data-hero-name="Lylia" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-17.png" class="hero-icon" data-hero-name="Cecilion" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-18.png" class="hero-icon" data-hero-name="Luo Yi" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-19.png" class="hero-icon" data-hero-name="Yve" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-20.png" class="hero-icon" data-hero-name="Valentina" onclick="selectHero(this)">
                                        <img src="IMG/hero/Mage/mg-21.png" class="hero-icon" data-hero-name="Xavier" onclick="selectHero(this)">
                                    </div>
                                </div>

                                <!-- Marksman -->
                                <div class="modal-header">
                                    <div class="heroModalLabel" id="heroModalLabel">Marksman</div>
                                </div>
                                <div class="modal-body">
                                    <div class="hero-grid">
                                        <img src="IMG/hero/Marksman/mm-1.png" class="hero-icon" data-hero-name="Miya" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-2.png" class="hero-icon" data-hero-name="Bruno" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-3.png" class="hero-icon" data-hero-name="Clint" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-4.png" class="hero-icon" data-hero-name="Layla" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-5.png" class="hero-icon" data-hero-name="Moskov" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-6.png" class="hero-icon" data-hero-name="Karrie" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-7.png" class="hero-icon" data-hero-name="Irithel" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-8.png" class="hero-icon" data-hero-name="Hanabi" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-9.png" class="hero-icon" data-hero-name="Claude" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-11.png" class="hero-icon" data-hero-name="Wanwan" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-10.png" class="hero-icon" data-hero-name="Granger" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-12.png" class="hero-icon" data-hero-name="Popol and Kupa" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-13.png" class="hero-icon" data-hero-name="Brody" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-14.png" class="hero-icon" data-hero-name="Beatrix" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-15.png" class="hero-icon" data-hero-name="Natan" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-16.png" class="hero-icon" data-hero-name="Melissa" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-17.png" class="hero-icon" data-hero-name="Ixia" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-18.png" class="hero-icon" data-hero-name="Lesley" onclick="selectHero(this)">
                                        <img src="IMG/hero/Marksman/mm-19.png" class="hero-icon" data-hero-name="Kimmy" onclick="selectHero(this)">
                                    </div>
                                </div>

                                <!-- Support -->
                                <div class="modal-header">
                                    <div class="heroModalLabel" id="heroModalLabel">Support</div>
                                </div>
                                <div class="modal-body">
                                    <div class="hero-grid">
                                        <img src="IMG/hero/Support/sp-1.png" class="hero-icon" data-hero-name="Rafaela" onclick="selectHero(this)">
                                        <img src="IMG/hero/Support/sp-2.png" class="hero-icon" data-hero-name="Estes" onclick="selectHero(this)">
                                        <img src="IMG/hero/Support/sp-3.png" class="hero-icon" data-hero-name="Diggie" onclick="selectHero(this)">
                                        <img src="IMG/hero/Support/sp-4.png" class="hero-icon" data-hero-name="Angela" onclick="selectHero(this)">
                                        <img src="IMG/hero/Support/sp-5.png" class="hero-icon" data-hero-name="Floryn" onclick="selectHero(this)">
                                        <img src="IMG/hero/Support/sp-6.png" class="hero-icon" data-hero-name="Lolita" onclick="selectHero(this)">
                                        <img src="IMG/hero/Support/sp-7.png" class="hero-icon" data-hero-name="Kaja" onclick="selectHero(this)">
                                        <img src="IMG/hero/Support/sp-8.png" class="hero-icon" data-hero-name="Faramis" onclick="selectHero(this)">
                                        <img src="IMG/hero/Support/sp-9.png" class="hero-icon" data-hero-name="Carmilla" onclick="selectHero(this)">
                                        <img src="IMG/hero/Support/sp-10.png" class="hero-icon" data-hero-name="Mathilda" onclick="selectHero(this)">
                                        <img src="IMG/hero/Support/sp-11.png" class="hero-icon" data-hero-name="Chip" onclick="selectHero(this)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Squad Verification Modal -->
                    <div class="modal fade" id="squadVerificationModal" tabindex="-1" aria-labelledby="squadVerificationModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content customModal">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="squadVerificationModalLabel">SQUAD LEVEL UPDATE</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="squadVerificationForm" action="/includes/verifySquad.inc.php" method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label class="form-label">SQUAD LEVEL</label>
                                            <div class="dropdown-wrapper">
                                                <select name="Squad_Level" class="squadLevelDropdown" required>
                                                    <option selected disabled>Select Level</option>
                                                    <option value="Amateur">Amateur</option>
                                                    <option value="Collegiate">Collegiate</option>
                                                    <option value="Professional">Professional</option>
                                                </select>
                                                <span class="dropdown-icon">▼</span>
                                            </div>
                                        </div>

                                        <!-- Conditional Fields -->
                                        <div id="verificationFields">
                                            <div class="mb-3">
                                                <label class="form-label">TYPE OF PROOF</label>
                                                <div class="dropdown-wrapper">
                                                    <select name="Proof_Type" class="squadLevelDropdown">
                                                        <option selected disabled>Select Proof</option>
                                                        <option value="Certificate of Enrollment">Certificate of Enrollment</option>
                                                        <option value="Official Team Registration">Official Team Registration</option>
                                                        <option value="Tournament Participation">Tournament Participation</option>
                                                    </select>
                                                    <span class="dropdown-icon">▼</span>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">ATTACH FILE</label>
                                                <div class="custom-file-upload">
                                                    <input type="file" name="Proof_File" id="fileInput" hidden>
                                                    <button type="button" class="modalButtons" id="chooseFileBtn">CHOOSE FILE</button>
                                                    <span id="fileName">No file chosen</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="modalButtons">SUBMIT</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

    <!-- Javascript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rankStars = {
                // Warrior
                'Warrior I': { min: 0, max: 3 },
                'Warrior II': { min: 0, max: 3 },
                'Warrior III': { min: 0, max: 3 },
                // Elite
                'Elite I': { min: 0, max: 3 },
                'Elite II': { min: 0, max: 3 },
                'Elite III': { min: 0, max: 3 },
                'Elite IV': { min: 0, max: 3 },
                // Master
                'Master I': { min: 0, max: 4 },
                'Master II': { min: 0, max: 4 },
                'Master III': { min: 0, max: 4 },
                'Master IV': { min: 0, max: 4 },
                // Grandmaster
                'Grandmaster I': { min: 0, max: 5 },
                'Grandmaster II': { min: 0, max: 5 },
                'Grandmaster III': { min: 0, max: 5 },
                'Grandmaster IV': { min: 0, max: 5 },
                'Grandmaster V': { min: 0, max: 5 },
                // Epic
                'Epic I': { min: 0, max: 5 },
                'Epic II': { min: 0, max: 5 },
                'Epic III': { min: 0, max: 5 },
                'Epic IV': { min: 0, max: 5 },
                'Epic V': { min: 0, max: 5 },
                // Legend
                'Legend I': { min: 0, max: 5 },
                'Legend II': { min: 0, max: 5 },
                'Legend III': { min: 0, max: 5 },
                'Legend IV': { min: 0, max: 5 },
                'Legend V': { min: 0, max: 5 },
                // Mythic
                'Mythic': { min: 0, max: 24 },
                'Mythical Honor': { min: 25, max: 49 },
                'Mythical Glory': { min: 50, max: 99 },
                'Mythical Immortal': { min: 100, max: Infinity }
            };

            function validateStars(input, rank) {
                const value = parseInt(input.value);
                const config = rankStars[rank];
                if (!config) {
                    input.setCustomValidity('Select a valid rank first.');
                    return;
                }
                if (isNaN(value) || value < config.min || value > config.max) {
                    input.setCustomValidity(`Stars must be between ${config.min} and ${config.max}.`);
                } else {
                    input.setCustomValidity('');
                }
                input.reportValidity();
            }

            // Current Rank Validation
            const currentRank = document.querySelector('select[name="Current_Rank"]');
            const currentStar = document.querySelector('input[name="Current_Star"]');
            currentRank.addEventListener('change', () => validateStars(currentStar, currentRank.value));
            currentStar.addEventListener('input', () => validateStars(currentStar, currentRank.value));

            // Highest Rank Validation
            const highestRank = document.querySelector('select[name="Highest_Rank"]');
            const highestStar = document.querySelector('input[name="Highest_Star"]');
            highestRank.addEventListener('change', () => validateStars(highestStar, highestRank.value));
            highestStar.addEventListener('input', () => validateStars(highestStar, highestRank.value));
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const currentRank = document.querySelector('[name="Current_Rank"]').value;
            const highestRank = document.querySelector('[name="Highest_Rank"]').value;
            
            if (currentRank === highestRank) {
                const currentStar = parseInt(document.querySelector('[name="Current_Star"]').value);
                const highestStar = parseInt(document.querySelector('[name="Highest_Star"]').value);
                if (highestStar < currentStar) {
                    alert("Highest stars cannot be less than current stars for the same rank!");
                    e.preventDefault();
                }
            }
        });

        // Squad Verification Modal Field Toggling
        document.addEventListener('DOMContentLoaded', function() {
        const squadLevelSelect = document.querySelector('#squadVerificationModal select[name="Squad_Level"]');
        const verificationFields = document.getElementById('verificationFields');
        const proofTypeSelect = verificationFields.querySelector('select[name="Proof_Type"]');
        const fileInput = verificationFields.querySelector('input[name="Proof_File"]');
        const chooseFileBtn = document.getElementById('chooseFileBtn');
        const fileNameSpan = document.getElementById('fileName');

        function toggleVerificationFields() {
            const isAmateur = squadLevelSelect.value === 'Amateur';
            
            verificationFields.style.display = isAmateur ? 'none' : 'block';
            proofTypeSelect.required = !isAmateur;
            fileInput.required = !isAmateur;
        }

        if (squadLevelSelect) {
            toggleVerificationFields();
            squadLevelSelect.addEventListener('change', toggleVerificationFields);
        }

        // File input handling
        chooseFileBtn.addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            fileNameSpan.textContent = this.files[0] ? this.files[0].name : 'No file chosen';
        });
    });

    // Use AJAX to refresh player list without reloading
    setInterval(function() {
        fetch('/includes/fetchPlayers.inc.php?squad_id=<?= urlencode($squadID) ?>')
            .then(response => response.text())
            .then(data => {
                document.querySelector('.profiles').innerHTML = data;
            });
    }, 5000); // Refresh every 5 seconds
    </script>
    <script src="JS/creatingSquadScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>