<?php
session_start(); // Start the session
require_once 'includes/dbh.inc.php'; // Database connection
require_once 'includes/userHomepage.inc.php'; // Squad details logic


// Initialize user data from session
$user = $_SESSION['user'] ?? ['username' => 'Guest', 'Squad_ID' => 'N/A'];


// Initialize squad details from session or default values
$squadDetails = $_SESSION['squad_details'] ?? [
    'Squad_Acronym' => 'N/A',
    'Squad_Name' => 'N/A',
    'Squad_ID' => 'N/A',
    'Squad_Level' => 'N/A',
    'Squad_Description' => 'N/A'
];

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

// Initialize players array
$players = [];


try {
    // Fetch ALL user data from the database using session username TESTING TESTING
    if (isset($_SESSION['user']['username'])) {
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


    // Fetch squad details if Squad_ID is set
    if (isset($_SESSION['user']['Squad_ID'])) {
        $squadID = $_SESSION['user']['Squad_ID'];

        // Fetch squad details
        $stmtSquad = $pdo->prepare("SELECT Squad_Acronym, Squad_Name, Squad_ID, Squad_Level, Squad_Description FROM tbl_squadprofile WHERE Squad_ID = ?");
        $stmtSquad->execute([$squadID]);
        $squadDetails = $stmtSquad->fetch(PDO::FETCH_ASSOC);


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


        // Update session with the latest squad details
        $_SESSION['squad_details'] = $squadDetails;


        // Fetch players for the squad
        $stmtPlayers = $pdo->prepare("SELECT * FROM tbl_playerprofile WHERE Squad_ID = ?");
        $stmtPlayers->execute([$squadID]);
        $players = $stmtPlayers->fetchAll(PDO::FETCH_ASSOC);

        // Fetch posts for the squad
        if (isset($_SESSION['user']['Squad_ID'])) {
            $squadID = $_SESSION['user']['Squad_ID'];
            $stmtPosts = $pdo->prepare("SELECT * FROM tbl_squadposts WHERE Squad_ID = ? ORDER BY Timestamp DESC");
            $stmtPosts->execute([$squadID]);
            $posts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    $squadID = 1; // HARDCODED FOR TESTING
        
    // For testing ang i2 teh tatanggalin din
    $stmtPosts = $pdo->prepare("SELECT * FROM tbl_squadposts WHERE Squad_ID = ? ORDER BY Timestamp DESC");
    $stmtPosts->execute([$squadID]);
    $posts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);    
    
} catch (PDOException $e) {
    // Handle database errors
    die("Database error: " . htmlspecialchars($e->getMessage()));
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Mobile Legends: Bang Bang Scrimmage Platform</title>
    <link rel="stylesheet" type="text/css" href="CSS/userHomepageStyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="IMG/essentials/whiteVer.PNG">
</head>


<body class="customPageBackground">
    <div class="introScreen">
        <div class="loadingAnimation"></div>
    </div>


    <div class="pageContent hiddenContent">
        <!-- Navigation Bar -->
        <div class="container-fluid">        
            <div class="row">
                <div class="container-fluid navigationBar">
                    <!-- Logo Layer -->
                    <div class="logoLayer">
                        <!-- Logo and Name -->
                        <a class="navbar-brand" href="userHomepage.php">
                            <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                            <div class="logoText">abyss</div>
                        </a>
                       
                        <!-- Search Bar -->
                        <form class="searchBar">
                            <input class="searchInput" type="search" placeholder=" " aria-label="Search">
                            <button class="searchButton" type="submit">
                                <img src="IMG/essentials/whiteVer.PNG" alt="Search">
                            </button>
                        </form>
                   
                        <!-- Account Logo Button -->
                        <button class="accountLogo" data-bs-toggle="modal" data-bs-target="#loginSignupModal">
                            <i class="bi bi-person-circle"></i>
                        </button>                        
                   
                        <!-- Navbar Toggle Button -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                   
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="userHomepage.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="          ">LEADERBOARDS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="          ">ABOUT US</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="          ">SCRIMS</a>
                        </li>
                        <!-- Icon Bars -->
                        <div class="iconsBar">
                            <li class="nav-item">
                                <a class="nav-linkIcon" href="          "><i class="bi bi-app-indicator"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-linkIcon" href="          "><i class="bi bi-chat-left-fill"></i></a>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>


        <!-- Squad Details -->
        <div class="squadDetails">
            <div class="squadDetailsContent">
                <div class="buttons">
                    <a href="#" class="editAccount">EDIT ACCOUNT</a>
                    <form action="includes/logout.inc.php" method="post">
                        <button class="editAccount"> LOGOUT </button>
                    </form>  
                </div>
                <div class="row squadAccount">
                    <div class="squadAcronym">
                        <?php echo htmlspecialchars($squadDetails['Squad_Acronym']) ?>
                    </div>
                    <div class="squadName">
                        <?php echo htmlspecialchars($squadDetails['Squad_Name']) ?>
                    </div>
                    <div class="squadAccountID">
                        ID: <?php echo htmlspecialchars($squadDetails['Squad_ID']) ?>
                    </div>
                    <div class="tabsRow">
                        <div class="tabs">TOP 3 GLOBAL SQUAD</div>
                        <div class="tabs"><?php echo htmlspecialchars($squadDetails['Squad_Level']) ?></div>
                    </div>
                    <div class="squadDescription">
                        <?php echo htmlspecialchars($squadDetails['Squad_Description']) ?> <!-- You can make this dynamic if you have a Squad_Description field -->
                    </div>
                </div>
            </div>
        </div>


        <!-- Scrim Button -->
        <!--button id="findScrimButton">Find <br> Scrim</button>


        Main Body -->
        <div class="row mainBody">
            <!-- Fixed "Find Scrim" Button -->
            <a href="scrimMatchmakingPage.php" class="findScrimButton">
                Find Scrim
            </a>


            <!-- Stats Column -->
            <div class="col-3" >
                <div class="squadStatistics">SQUAD STATISTICS</div>
                <div class="squadStats">
                    <div class="winRate">
                        <div class="statsContent">
                            <div class="number">88%</div>
                        <div class="statsLabel">WIN RATE</div>
                        </div>
                    </div>


                    <div class="winRate">
                        <div class="statsContent">
                            <div class="number">245</div>
                        <div class="statsLabel">MATCHES</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Feed -->
            <div class="col-6">
                <div class="feed">
                    <form id="postForm" action="includes/post.inc.php" method="post" enctype="multipart/form-data">
                        <div class="statusBox">
                            <!-- Textarea for post content -->
                            <textarea name="content" id="contentInput" class="statusInput" placeholder="Share your thoughts, Coach!" required></textarea>

                            <!-- Attach Image Label and File Input -->
                            <label for="imageUpload" class="imageUploadLabel">Attach Image</label>
                            <input type="file" name="imageUpload" id="imageUpload" class="imageUpload" accept="image/*">

                            <!-- Status Options -->
                            <div class="statusOptions">
                                <!-- Post Label Input -->
                                <input type="text" name="postLabel" id="postLabelInput" placeholder="Add a label (optional)">

                                <!-- Post Type Select -->
                                <div class="selectContainer">
                                    <select name="postType" id="postTypeSelect" class="postTypeSelect">
                                        <option value="public">Public</option>
                                        <option value="private">Private</option>
                                    </select>
                                </div>

                                <!-- Post Button -->
                                <button type="submit" name="postButton" id="postButton" class="postButton">POST</button>
                            </div>
                        </div>
                    </form>

                    <!-- Dynamic Posts -->
                    <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <div class="post">
                                <div class="date">
                                    <?= htmlspecialchars(date('F j, Y', strtotime($post['Timestamp']))); ?>
                                </div>
                                <?php if (!empty($post['Image_URL'])): ?>
                                    <div class="attachedIMG">
                                        <img src="<?= htmlspecialchars($post['Image_URL']); ?>" alt="Post Image" class="attachedIMG">
                                    </div>
                                <?php endif; ?>
                                <div class="caption">
                                    <?= htmlspecialchars($post['Content']); ?>
                                </div>
                                <?php if (!empty($post['Post_Label'])): ?>
                                    <div class="postedLabels">
                                        <div class="labelTag"><?= htmlspecialchars($post['Post_Label']); ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="post">No posts found.</div>
                    <?php endif; ?>

                    <!-- End Message -->
                    <div class="end">End of Feed</div>
                </div>
            </div>
           
            <!-- Label Pop-up -->
            <div id="labelModal" class="labelModal">
                <div class="modalContent">
                    <div class="modalHeader">Add Label</div>
                    <input type="text" id="customLabelInput" placeholder="Enter label here...">
                    <div class="modalButtons">
                        <button class="modalButton" onclick="saveCustomLabel()">Add</button>
                        <button class="modalButton" onclick="closeLabelModal()">Cancel</button>
                    </div>
                </div>
            </div>


            <!-- Players Column -->
            <div class="col-3" >
                <div class="squadPlayers">
                    <?php foreach ($players as $player): ?>
                        <div class="playerProfile">
                            <div class="IGN"><?= htmlspecialchars($player['IGN']) ?></div>
                            <div class="role"><?= htmlspecialchars($player['Role']) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>


        <!-- Advertisment -->
        <div class="container">
            <div class="row d-flex advertisement">
                <a href="https://play.google.com/store/apps/details?id=com.hhgame.mlbbvn&hl=en-US&pli=1">
                    <img src="IMG/essentials/advertisement.png" class="adIMG" alt="advertissement">
                </a>
            </div>
        </div>


        <!-- Decorative Divider-->
        <div class="container-fluid">
            <div class="row divider">
                <div class="decoDivide">
                    <div class="decoBox"></div>
                    <div class="codeDeco">0905270     //</div>
                    <div class="decoLine"></div>  
                    <div class="decoFoxDivide">
                        <div class="glowingFox"></div>
                    </div>
                </div>
            </div>
        </div>
       
        <footer>
            <div class="row">
                <div class="col-12">
                    <div class="about-us">
                        <div class="aboutUsTop">
                            Welcome to abyss, a student-developed initiative from Lyceum of Subic Bay, created to revolutionize Mobile Legends scrimmage matchmaking. As passionate IT students and gamers, we recognized the challenges squads face in finding, organizing, and managing scrims efficiently. Our goal is to provide a faster, more centralized platform where teams can seamlessly connect, compete, and improve their gameplay.
                        </div>


                        <div class="aboutUsBot">
                            With a user-friendly system, we aim to eliminate the hassle of manual scheduling and random opponent searches. Whether you're a casual team looking for practice or a competitive squad aiming for the top, abyss makes scrimmage organized, fair, and accessible. Join us in reshaping the competitive scene — where squads battle, strategies evolve, and legends are made!
                            <br><br>
                            © FEBRUARY 2025
                        </div>
                    </div>  


                    <div class="socialMediaIcons">
                        <i class="bi bi-facebook"></i>
                        <i class="bi bi-twitter-x"></i>
                        <i class="bi bi-instagram"></i>
                    </div>


                    <div class="footIcon">
                        <a class="navbar-brand" href="index.php">
                            <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                            <div class="logoText">abyss</div>
                        </a>
                    </div>
                </div>                  
            </div>
        </footer>
    </div>


    <!-- Javascript -->
    <script src="JS/userHomepageScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
