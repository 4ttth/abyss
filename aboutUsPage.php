<?php
    session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Mobile Legends: Bang Bang Scrimmage Platform</title>
    <link rel="stylesheet" type="text/css" href="CSS/aboutUsStyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="IMG/essentials/whiteVer.PNG">
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1PTW197N36"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-1PTW197N36');
    </script>

</head>

<body class="customPageBackground">
    <!-- Loading Screen -->
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
                        <a class="navbar-brand" href="index.php">
                            <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                            <div class="logoText">abyss</div>
                        </a>
                        
                        <!-- <form class="searchBar" action="guestSearchResultsPage.php" method="GET">
                            <input class="searchInput" type="search" name="query" placeholder="Search Squads" aria-label="Search">
                            <button class="searchButton" type="submit">
                                <img src="IMG/essentials/whiteVer.PNG" alt="Search">
                            </button>
                        </form> -->
                        
                        <form class="searchBar" action="guestSearchResultsPage.php" method="GET" onsubmit="return false;">
                            <input class="searchInput" type="search" name="query" placeholder="Search Squads" aria-label="Search" disabled>
                            <button class="searchButton" type="submit" disabled>
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
                            <a class="nav-link" aria-current="page" href="index.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="guestDiscoverPage.php">DISCOVER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="aboutUsPage.php">ABOUT US</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="mainContent">
            <!-- Meet the ZeroNine Team -->
            <div class="meetTeamContainer">
                <img src="IMG/backgrounds/3.png" class="aboutUsPic1" alt="Team ZeroNine"> 
            </div>

            <!-- Mission -->
            <div class="meetTeamContainer">
                <img src="IMG/backgrounds/2.png" class="aboutUsPic1" alt="Team ZeroNine"> 
            </div>
        </div>

        <!-- Decorative Divider
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
        </div> -->



        <!-- Instructions
        <div class="container-fluid instructionsContainer">
            <div class="row d-flex instructions">
                <div class="col-3 steps">
                    <div class="row instructionsOne">
                        <strong>Sign Up & Create a Squad</strong> 
                        <br>Register an account on the platform and set up your squad by adding team details, including in-game names (IGNs), ranks, and roles. Ensure your squad has 6-7 members, including a coach, to be officially recognized.
                    </div>
                    <div class="row demoOne">

                    </div>
                </div>

                <div class="col-3 steps">
                    <div class="row demoTwo">

                    </div>
                    <div class="row instructionsTwo">
                        <strong>Find & Challenge Opponents</strong> 
                        <br>Use the matchmaking system to search for squads that match your rank and skill level. Send scrim requests, negotiate match details, and finalize an agreement with the opposing team.
                    </div>
                </div>

                <div class="col-3 steps">
                    <div class="row instructionsThree">
                        <strong>Schedule & Play the Scrim</strong> 
                        <br>Once both squads confirm the challenge, schedule the match by selecting the date and time. Receive notifications and reminders before the game, then compete in your scheduled scrim.
                    </div>
                    <div class="row demoThree">

                    </div>
                </div>

                <div class="col-3 steps">
                    <div class="row demoFour">

                    </div>
                    <div class="row instructionsFour">
                        <strong>Submit Results & Feedback</strong> 
                        <br>After the match, upload a screenshot of the final score, review the match experience, and report any issues if necessary. Your squad’s performance will be updated in the system, helping you track progress and improve your gameplay.
                    </div>
                </div>
            </div>
        </div> -->

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
    <script src="JS/aboutUsScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>