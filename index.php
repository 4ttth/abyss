<?php
    session_start();
?>
<!-- TESTIIINGGGG -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Mobile Legends: Bang Bang Scrimmage Platform</title>
    <link rel="stylesheet" type="text/css" href="CSS/myStyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="IMG/essentials/whiteVer.PNG">
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1PTW197N36"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-X9S6R362WJ');
    </script>

</head>

<body class="customPageBackground">
    <!-- Loading Screen for Landing Page -->
    <div class="introScreen">
        <div class="glowingFoxIntro"></div>
    </div>

    <div class="pageContent hiddenContent">
        <!-- Navigation Bar -->
        <div class="container-fluid">        
            <div class="row">
                <div class="container-fluid navigationBar">
                    <!-- Logo Layer -->
                    <div class="logoLayer">
                        <!-- Logo and Name -->
                        <a class="navbar-brand" href="index.php">
                            <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                            <div class="logoText">abyss</div>
                        </a>
                        
                        <!-- Search Bar -->
                        <form class="searchBar" action="guestSearchResultsPage.php" method="GET">
                            <input class="searchInput" type="search" name="query" placeholder="Search Squads" aria-label="Search">
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
                            <a class="nav-link active" aria-current="page" href="index.php">HOME</a>
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
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']); ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <!-- Title + Guin Background -->
        <div class="topBackground">
            <div class="entryButtons">
                <a href="signupPage.php" class="signUpButton">SIGN UP</a>
                <div class="loginText">Already have an account? <a href="loginPage.php" class="loginButtonEntry">Login</a></div>
            </div>
    
            <!-- Content Message -->
            <div class="abyssContent">
                Step into the battlefield and connect with squads ready to clash in high-stakes scrimmages. Abyss is a competitive matchmaking platform designed to help Mobile Legends teams find scrims, schedule matches, and track performance with ease. Whether you're a rising squad looking to sharpen your skills or a veteran team seeking worthy opponents, our platform ensures fair and dynamic matchups.
            </div>

            <div class="abyssContainer">
                <div class="abyssText">A<span class="customSpace">b</span>yss</div>
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

        <!-- Events & Leaderboard Layer-->
        <div class="container-fluid">
            <div class="row d-flex eventsLeaderboard">
                 <!-- Admin Content Start -->
                 <?php
                    require_once 'includes/dbh.inc.php';

                    // Fetch active content
                    $activeContent = $pdo->query("
                        SELECT Event_Name, Event_Duration, Event_Details, 
                            Promotional_Content, Youtube_Link, Youtube_Banner 
                        FROM tbl_contentmanagement 
                        WHERE Is_Displayed = 1 
                        LIMIT 1
                    ")->fetch(PDO::FETCH_ASSOC);

                    $imagePath = "uploads/content/" . basename($activeContent['Promotional_Content']);
                    $imagePathYT = "uploads/content/" . basename($activeContent['Youtube_Banner']);
                    ?>

                    <div class="col-xl-6 eventsColumn">
                        <?php if ($activeContent): ?>
                            <!-- Text Block -->
                            <div class="row textBlockCenter">
                                <div class="titleCenter">
                                    <?= htmlspecialchars($activeContent['Event_Name']) ?>
                                </div>
                                <div class="subtitleCenter">
                                    <?= htmlspecialchars($activeContent['Event_Duration']) ?>
                                </div>
                                <div class="descriptionCenter">
                                    <?= htmlspecialchars($activeContent['Event_Details']) ?>
                                </div>
                                <a href="#" class="viewMoreButton">VIEW MORE</a>
                            </div>

                            <!-- Promotional Content -->
                            <div class="row d-flex skinBlocks gx-3">
                                <?php if (!empty($activeContent['Promotional_Content'])): ?>
                                    <div class="col-4 skinBlock">
                                        <img src="<?= htmlspecialchars($imagePath)?>" 
                                            class="promotionalContent" alt="Promotional Banner">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- YouTube Video -->
                            <div class="videoCard">
                                <?php if (!empty($activeContent['Youtube_Link'])): ?>
                                    <a href="<?= htmlspecialchars($activeContent['Youtube_Link']) ?>" target="_blank">
                                        <div class="thumbnail">
                                            <img src="<?= htmlspecialchars($imagePathYT)?>" alt="Youtube Banner"> 
                                        </div>
                                    </a>
                                <?php endif; ?>
                            </div>

                        <?php else: ?>
                            <div class="row textBlockCenter">
                                <div class="titleCenter">NO ACTIVE EVENT</div>
                                <div class="subtitleCenter">Check back later!</div>
                            </div>
                        <?php endif; ?>
                    </div>
                <!-- Admin Content End -->
                
                
                <!-- Leaderboard Column -->
                <div class="col-xl-6 leaderboardColumn">
                    <!-- Text Block -->
                    <div class="row textBlockRight">
                        <div class="titleRight">
                            LEADERBOARDS
                        </div>
                        <div class="subtitleRight">
                            AS OF 09022025
                        </div>
                        <div class="descriptionRight">
                            RESETS EVERY SUNDAY AT 00:00 (gmt +8) 
                        </div>
                    </div>

                    <!-- TRIAL LEADERBOARD -->
                    <div class="leaderboardBox">
                        <!-- Table Header -->
                        <div class="leaderboardRow leaderboardHeader">
                            <div class="leaderboardRank"></div>
                            <div class="leaderboardSquad">SQUAD</div>
                            <div class="leaderboardPoints">ABYSS POINTS</div>
                        </div>

                        <?php
                        try {
                            $stmt = $pdo->prepare("SELECT Squad_Acronym, Squad_Name, abyss_score 
                                                FROM tbl_squadprofile 
                                                ORDER BY abyss_score DESC 
                                                LIMIT 10");
                            $stmt->execute();
                            $leaderboard = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($leaderboard as $index => $squad) {
                                echo '<div class="leaderboardRow">';
                                echo '  <div class="leaderboardRank">' . ($index + 1) . '</div>';
                                echo '  <div class="leaderboardSquad">';
                                echo '      <div class="squadNameContainer">';
                                echo '          <div class="shortName">' . htmlspecialchars($squad['Squad_Acronym']) . '</div>';
                                echo '          <div class="fullName">' . htmlspecialchars($squad['Squad_Name']) . '</div>';
                                echo '      </div>';
                                echo '  </div>';
                                echo '  <div class="leaderboardPoints">';
                                echo '      <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">';
                                echo        number_format($squad['abyss_score']);
                                echo '  </div>';
                                echo '</div>';
                            }
                        } catch (PDOException $e) {
                            echo '<div class="leaderboardRow">';
                            echo '  <div class="leaderboardRank">-</div>';
                            echo '  <div class="leaderboardSquad">';
                            echo '      <div class="squadNameContainer">';
                            echo '          <div class="shortName">ERR</div>';
                            echo '          <div class="fullName">Unable to load</div>';
                            echo '      </div>';
                            echo '  </div>';
                            echo '  <div class="leaderboardPoints">---</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative Divider -->
        <div class="container-fluid">
            <div class="row d-flex simpleDivider">
                <div class="col-4 text">
                    <div class="row textBlockLeft">
                        <div class="descriptionLeft">
                            SCHEDULE YOUR NEXT
                        </div>
                        <div class="titleLeft">
                            SCRIMMAGE
                        </div>
                        <div class="subtitleLeft">
                            WITH <strong>ABYSS</strong>! HERE’S HOW IT WORKS
                        </div>
                        
                        <div class="decoDivideRight">
                            <div class="decoBoxRight"></div>
                            <div class="codeDecoRight">0905270     //</div>
                            <div class="decoLineRight"></div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="container-fluid instructionsContainer">
            <div class="row d-flex instructions">
                <!-- ECHO ECHO -->
                    <?php
                    $instruction = $pdo->query("SELECT * FROM tbl_instructions WHERE Show_Status = 'Shown' LIMIT 1")->fetch();
                    ?>
                    <?php if ($instruction): ?>
                        <div class="col-3 steps">
                            <div class="row instructionsOne">
                                <strong><?php echo htmlspecialchars($instruction['Step1_Title']); ?></strong>
                                <br><?php echo htmlspecialchars($instruction['Step1_Content']); ?></div>
                            <div class="row demoOne">
                                
                            </div>
                        </div>
                        <div class="col-3 steps">
                        <div class="row demoTwo">

                        </div>
                            <div class="row instructionsTwo">
                                <strong><?php echo htmlspecialchars($instruction['Step2_Title']); ?></strong>
                                <br><?php echo htmlspecialchars($instruction['Step2_Content']); ?></div>
                        </div>
                        <div class="col-3 steps">
                            <div class="row instructionsThree">
                                <strong><?php echo htmlspecialchars($instruction['Step3_Title']); ?></strong>
                                <br><?php echo htmlspecialchars($instruction['Step3_Content']); ?></div>
                            <div class="row demoThree">

                            </div>
                        </div>
                        <div class="col-3 steps">
                        <div class="row demoFour">

                        </div>
                            <div class="row instructionsFour">
                                <strong><?php echo htmlspecialchars($instruction['Step4_Title']); ?></strong>
                                <br><?php echo htmlspecialchars($instruction['Step4_Content']); ?></div>
                        </div>
                    <?php else: ?>
                        <p>No active instruction yet.</p>
                    <?php endif; ?>
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

        <!-- Login/Signup Modal -->
        <div class="modal fade" id="loginSignupModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header with Logo -->
                    <div class="modal-header modalIcon">
                        <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                        <div class="logoText">abyss</div>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <a href="loginPage.php"><button class="btn w-100 mb-3 loginBtn">
                            LOG IN
                        </button></a>
                        
                        <a href="signupPage.php"><button class="btn w-100 signupBtn">
                            SIGN UP
                        </button></a>
                        <p class="click-outside-text">Click anywhere outside to close</p>
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
       <!-- Google tag -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1PTW197N36"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-X9S6R362WJ');
    </script>
    <script src="JS/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>