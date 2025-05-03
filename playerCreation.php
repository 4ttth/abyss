<?php
session_start();
require_once 'includes/dbh.inc.php';

$encodedsquadID = $_GET['squad_id'] ?? null;
$squadID = base64_decode($encodedsquadID);
$encodedusername = $_GET['username'] ?? null;
$username = base64_decode($encodedusername);

// Validate Squad_ID
$stmt = $pdo->prepare("SELECT * FROM tbl_useraccount WHERE Squad_ID = ?");
$stmt->execute([$squadID]);
$squadExists = $stmt->fetch();

if (!$squadExists) {
    header("Location: index.php");
    exit();
}

// Set session variables if not already set
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [
        'username' => $username,
        'Squad_ID' => $squadID
    ];
}

// Game ID Validation
if (!preg_match('/^\d{9,11}$/', $_POST['Game_ID'])) {
    header("Location: playerCreation.php?error=invalid_game_id");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $IGN = $_POST['IGN'];
    $firstName = trim($_POST['First_Name']);
    $lastName = trim($_POST['Last_Name']);
    $Game_ID = $_POST['Game_ID'];
    $Current_Rank = $_POST['Current_Rank'];
    $Current_Star = $_POST['Current_Star'];
    $Highest_Rank = $_POST['Highest_Rank'];
    $Highest_Star = $_POST['Highest_Star'];
    $Role = $_POST['Role'];
    $Hero_1 = $_POST['Hero_1'];
    $Hero_2 = $_POST['Hero_2'];
    $Hero_3 = $_POST['Hero_3'];

    // Insert player data into tbl_playerprofile
    $stmt = $pdo->prepare("INSERT INTO tbl_playerprofile (Squad_ID, IGN, First_Name, Last_Name, Game_ID, Current_Rank, Current_Star, Highest_Rank, Highest_Star, Role, Hero_1, Hero_2, Hero_3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$squadID, $IGN, $firstName, $lastName, $Game_ID, $Current_Rank, $Current_Star, $Highest_Rank, $Highest_Star, $Role, $Hero_1, $Hero_2, $Hero_3]);

    header("Location: includes/logout2.inc.php");
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-5PJVHXE14X"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-5PJVHXE14X');
</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Solo Player</title>
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

    <div class="modal-content customModalSolo">
    <div class="modal-header">
        <h5 class="modal-title" id="addPlayerModalLabel">ADD PLAYER PROFILE</h5>
    </div>
    <div class="modal-body">
        <form action="includes/playercreate.inc.php" method="post">
            <div class="mb-3">
                <label class="form-label">IN-GAME NAME</label>
                <input type="text" name="IGN" class="form-control plchldr" placeholder="Enter IGN" required>
            </div>
            
            <!-- Split Full Name into First Name and Last Name -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">FIRST NAME</label>
                    <input type="text" name="First_Name" class="form-control plchldr" placeholder="Enter First Name" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">LAST NAME</label>
                    <input type="text" name="Last_Name" class="form-control plchldr" placeholder="Enter Last Name" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">GAME ID</label>
                <input type="text" name="Game_ID" class="form-control plchldr" placeholder="Enter Game ID" required
                    pattern="\d{9,11}" title="Game ID must be 9 digits">
            </div>

            <!-- Two-Column Layout for Rank -->
            <div class="row">
                <!-- Current Rank -->
                <div class="col-md-6">
                    <label class="form-label">CURRENT RANK</label>
                    <div class="dropdown-wrapper">
                        <select name="Current_Rank" class="squadLevelDropdown">
                            <option selected disabled>Select Rank</option>
                            <!-- Warrior -->
                            <option>Warrior I</option>
                            <option>Warrior II</option>
                            <option>Warrior III</option>
                            <!-- Elite -->
                            <option>Elite I</option>
                            <option>Elite II</option>
                            <option>Elite III</option>
                            <option>Elite IV</option>
                            <!-- Master -->
                            <option>Master I</option>
                            <option>Master II</option>
                            <option>Master III</option>
                            <option>Master IV</option>
                            <!-- Grandmaster -->
                            <option>Grandmaster I</option>
                            <option>Grandmaster II</option>
                            <option>Grandmaster III</option>
                            <option>Grandmaster IV</option>
                            <option>Grandmaster V</option>
                            <!-- Epic -->
                            <option>Epic I</option>
                            <option>Epic II</option>
                            <option>Epic III</option>
                            <option>Epic IV</option>
                            <option>Epic V</option>
                            <!-- Legend -->
                            <option>Legend I</option>
                            <option>Legend II</option>
                            <option>Legend III</option>
                            <option>Legend IV</option>
                            <option>Legend V</option>
                            <!-- Mythic -->
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
                        <!-- Warrior -->
                        <option>Warrior I</option>
                        <option>Warrior II</option>
                        <option>Warrior III</option>
                        <!-- Elite -->
                        <option>Elite I</option>
                        <option>Elite II</option>
                        <option>Elite III</option>
                        <option>Elite IV</option>
                        <!-- Master -->
                        <option>Master I</option>
                        <option>Master II</option>
                        <option>Master III</option>
                        <option>Master IV</option>
                        <!-- Grandmaster -->
                        <option>Grandmaster I</option>
                        <option>Grandmaster II</option>
                        <option>Grandmaster III</option>
                        <option>Grandmaster IV</option>
                        <option>Grandmaster V</option>
                        <!-- Epic -->
                        <option>Epic I</option>
                        <option>Epic II</option>
                        <option>Epic III</option>
                        <option>Epic IV</option>
                        <option>Epic V</option>
                        <!-- Legend -->
                        <option>Legend I</option>
                        <option>Legend II</option>
                        <option>Legend III</option>
                        <option>Legend IV</option>
                        <option>Legend V</option>
                        <!-- Mythic -->
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

            <div class="modal-footer">
                <button type="submit" name="submit" class="modalButtons">SAVE PLAYER</button>
            </div>
        </form>
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

    <!-- Javascript -->
    <script>
        // For Game ID Validation
        document.addEventListener('DOMContentLoaded', function () {
            const gameIdInput = document.querySelector('input[name="Game_ID"]');

            gameIdInput.addEventListener('input', function () {
                const value = gameIdInput.value;
                const isValid = /^\d{9,11}$/.test(value);

                if (!isValid) {
                    gameIdInput.setCustomValidity("Game ID must be between 9 to 11 digits.");
                } else {
                    gameIdInput.setCustomValidity("");
                }

                gameIdInput.reportValidity();
            });
        });

        // For Stars Validation
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
    </script>
    <script src="JS/creatingSquadScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>