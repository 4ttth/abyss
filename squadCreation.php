<?php
session_start();
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);
require_once 'includes/dbh.inc.php';

// Initialize user data from session
$user = $_SESSION['user'] ?? ['username' => 'Guest', 'Squad_ID' => 'N/A'];

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
        $stmt = $pdo->prepare("SELECT Status FROM tbl_verificationrequests WHERE Squad_ID = ? ORDER BY Date_Submitted DESC LIMIT 1");
        $stmt->execute([$_SESSION['user']['Squad_ID']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $verificationStatus = $result['Status'] ?? 'Not Submitted';
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
        <div class="container-fluid">
            <div class="row w-100">
                <div class="col content">
                    <div class="logo">
                        <a class="navbar-brand" href="index.php">
                            <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                            <div class="logoText">abyss</div>
                        </a>

                        <div class="backButton">
                            <a href="index.php">
                                <i class="bi bi-box-arrow-left backButton"></i>
                            </a>
                        </div>
                    </div>
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
                            <form action="includes/logout.inc.php" method="post">
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

                    <!-- TESTESTSETSETSETSETSET -->
                    <!-- Squad Members Profile -->
                    <div class="profiles-wrapper">
                        <div class="profiles">

                            <!-- TODO: COACH SLOT REMOVED, INCLUDE A NEW COLUMN IN PLAYER TABLE FOR A ROLE WHETHER IT IS A COACH OR NOT, AS WELL AS IN THE FORM -->
                            <!-- Player Details -->
                            <?php $playerIndex = 1; ?>
                            <?php foreach ($players as $player): ?>
                                <div class="memberProfile">
                                    <div class="role"><?= htmlspecialchars($player['Role']) ?> &nbsp; // &nbsp; player 00<?= $playerIndex ?></div>
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


                            <!-- Add Player Modal -->
                            <div class="addButton" data-bs-toggle="modal" data-bs-target="#addPlayerModal">
                                <i class="bi bi-plus-circle-fill add"></i>
                                <div class="buttonTitle">ADD PLAYER PROFILE</div>
                            </div>

                        </div>
                    </div>

                    <!-- Title -->
                    <div class="titleLeft">
                        CREATE YOUR SQUAD PROFILE
                    </div>

                    <form action="includes/squadcreate.inc.php" method="post">
                        <div class="row">
                            <!-- Squad Name Field -->
                            <div class="form-group mt-3 col-8">
                                <label class="form-label title">SQUAD NAME</label>
                                <input type="text" name="Squad_Name" class="form-control plchldr"
                                    value="<?= htmlspecialchars($formData['Squad_Name'] ?? '') ?>"
                                    placeholder="Enter Squad Name">
                            </div>

                            <!-- Squad Aronym Field -->
                            <div class="form-group mt-3 col-4">
                                <label class="form-label title">SQUAD ACRONYM</label>
                                <input type="text" name="Squad_Acronym" class="form-control plchldr"
                                    value="<?= htmlspecialchars($formData['Squad_Acronym'] ?? '') ?>"
                                    placeholder="Enter Squad Acronym">
                            </div>
                        </div>

                        <!-- Squad Description Field -->
                        <div class="form-group mt-3">
                            <label class="form-label title">SQUAD DESCRIPTION</label>
                            <input type="text" name="Squad_Description" class="form-control plchldr"
                                value="<?= htmlspecialchars($formData['Squad_Description'] ?? '') ?>"
                                placeholder="Enter Squad Description">
                        </div>

                        <div class="row align-items-center">
                            <!-- Squad Level Field -->
                            <div class="form-group mt-3 col-4">
                                <label class="form-label title">SQUAD LEVEL</label>
                                <div class="verifyLevel d-flex align-items-center">
                                    <!-- Dropdown with Caret -->
                                    <div class="dropdown-wrapper">
                                        <select name="Squad_Level" class="form-control plchldr squadLevelDropdown" <?= ($verificationStatus === 'Pending') ? 'disabled' : '' ?>>
                                            <option value="Amateur">Amateur</option>
                                            <option value="Collegiate">Collegiate</option>
                                            <option value="Professional">Professional</option>
                                        </select>
                                        <i class="bi bi-caret-down-fill dropdown-icon"></i>
                                    </div>

                                    <?php if ($verificationStatus === 'Pending') : ?>
                                        <div class="text-muted ms-2">Verification Pending</div>
                                    <?php else : ?>
                                        <button type="button" class="btn verifyButton" data-bs-toggle="modal" data-bs-target="#squadVerificationModal">
                                            VERIFY
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Empty Column for Spacing -->
                            <div class="col-4"></div>

                            <!-- Signup Button -->
                            <div class="col-4 text-end mt-3">
                                <form action="includes/squadcreate.inc.php" method="post">
                                    <button type="submit" class="btn loginButton">CREATE SQUAD</button>
                                </form>
                            </div>
                        </div>
                    </form>

                    <!-- END HERE -->

                    <!-- TESTESTESETESETSETSETSETS -->
                    <!-- Add Player Modal -->
                    <div class="modal fade" id="addPlayerModal" tabindex="-1" aria-labelledby="addPlayerModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content customModal">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPlayerModalLabel">ADD PLAYER PROFILE</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="includes/playercreate.inc.php" method="post">
                                        <div class="mb-3">
                                            <label class="form-label">IN-GAME NAME</label>
                                            <input type="text" name="IGN" class="form-control plchldr" placeholder="Enter IGN" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">FULL NAME</label>
                                            <input type="text" name="Full_Name" class="form-control plchldr" placeholder="Enter Full Name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">GAME ID</label>
                                            <input type="text" name="Game_ID" class="form-control plchldr" placeholder="Enter Game ID" required>
                                        </div>

                                        <!-- Two-Column Layout for Rank -->
                                        <div class="row">
                                            <!-- Current Rank -->
                                            <div class="col-md-6">
                                                <label class="form-label">CURRENT RANK</label>
                                                <div class="dropdown-wrapper">
                                                    <select name="Current_Rank" class="squadLevelDropdown">
                                                        <option selected disabled>Select Rank</option>
                                                        <option>Warrior</option>
                                                        <option>Elite</option>
                                                        <option>Master</option>
                                                        <option>Grandmaster</option>
                                                        <option>Epic</option>
                                                        <option>Legend</option>
                                                        <option>Mythic</option>
                                                        <option>Mythical Honor</option>
                                                        <option>Mythical Glory</option>
                                                        <option>Mythical Immortal</option>
                                                    </select>
                                                    <span class="dropdown-icon">▼</span>
                                                </div>
                                                <input name="Current_Star" type="text" class="form-control plchldr mt-2" placeholder="Enter Stars">
                                            </div>

                                            <!-- Highest Rank -->
                                            <div class="col-md-6">
                                                <label class="form-label">HIGHEST RANK</label>
                                                <div class="dropdown-wrapper">
                                                    <select name="Highest_Rank" class="squadLevelDropdown">
                                                        <option selected disabled>Select Rank</option>
                                                        <option>Warrior</option>
                                                        <option>Elite</option>
                                                        <option>Master</option>
                                                        <option>Grandmaster</option>
                                                        <option>Epic</option>
                                                        <option>Legend</option>
                                                        <option>Mythic</option>
                                                        <option>Mythical Honor</option>
                                                        <option>Mythical Glory</option>
                                                        <option>Mythical Immortal</option>
                                                    </select>
                                                    <span class="dropdown-icon">▼</span>
                                                </div>
                                                <input name="Highest_Star" type="text" class="form-control plchldr mt-2" placeholder="Enter Stars">
                                            </div>
                                        </div>

                                        <!-- Role Dropdown -->
                                        <div class="mb-3 mt-3">
                                            <label class="form-label">ROLE</label>
                                            <div class="dropdown-wrapper">
                                                <select name="Role" class="squadLevelDropdown">
                                                    <option selected disabled>Select Role</option>
                                                    <option>Tank</option>
                                                    <option>Fighter</option>
                                                    <option>Assassin</option>
                                                    <option>Mage</option>
                                                    <option>Marksman</option>
                                                    <option>Support</option>
                                                    <option>Coach</option>
                                                </select>
                                                <span class="dropdown-icon">▼</span>
                                            </div>
                                        </div>

                                        <div class="hero-pool-container">
                                            <label class="form-label">HERO POOL</label>
                                            <div class="hero-selection">
                                                <div class="hero-circle" data-hero-index="1" data-bs-toggle="modal" data-bs-target="#heroModal"></div>
                                                <div class="hero-circle" data-hero-index="2" data-hero-index="2" data-bs-toggle="modal" data-bs-target="#heroModal"></div>
                                                <div class="hero-circle" data-hero-index="3" data-hero-index="3" data-bs-toggle="modal" data-bs-target="#heroModal"></div>
                                            </div>
                                            <input type="hidden" name="Hero_1" id="hero1Input">
                                            <input type="hidden" name="Hero_2" id="hero2Input">
                                            <input type="hidden" name="Hero_3" id="hero3Input">
                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="submit" class="modalButtons">SAVE PLAYER</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

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
                                    <h5 class="modal-title" id="squadVerificationModalLabel">SQUAD VERIFICATION</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="squadVerificationForm" action="includes/verifySquad.inc.php" method="post" enctype="multipart/form-data">
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

                                        <div class="mb-3">
                                            <label class="form-label">TYPE OF PROOF</label>
                                            <div class="dropdown-wrapper">
                                                <select name="Proof_Type" class="squadLevelDropdown" required>
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
                                                <input type="file" name="Proof_File" id="fileInput" hidden required>
                                                <button type="button" class="modalButtons" id="chooseFileBtn">CHOOSE FILE</button>
                                                <span id="fileName">No file chosen</span>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="modalButtons">VERIFY</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script src="JS/creatingSquadScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>