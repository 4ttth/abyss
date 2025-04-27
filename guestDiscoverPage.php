<?php
session_start(); // Start the session
require_once 'includes/dbh.inc.php'; // Database connection

// Fetch public posts from all squads
try {
$stmtPosts = $pdo->prepare("SELECT p.*, s.Squad_ID, s.Squad_Name, s.Squad_Acronym 
                           FROM tbl_squadposts p
                           JOIN tbl_squadprofile s ON p.Squad_ID = s.Squad_ID
                           WHERE p.Post_Type = 'public'
                           ORDER BY p.Timestamp DESC");
    $stmtPosts->execute();
    $publicPosts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $publicPosts = []; // Handle error by setting empty array
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Discover Public Posts</title>
    <link rel="stylesheet" type="text/css" href="CSS/discoverStyle.css">
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
                        <a class="navbar-brand" href="index.php">
                            <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                            <div class="logoText">abyss</div>
                        </a>
                        
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
                            <a class="nav-link" aria-current="page" href="index.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="guestDiscoverPage.php">DISCOVER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="aboutUsPage.php">ABOUT US</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Feed -->
        <div class="row mainBody">
            <!-- Page Header -->
            <div class="discoverHeader">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="IMG/backgrounds/DiscoverContent/1.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="IMG/backgrounds/DiscoverContent/2.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="IMG/backgrounds/DiscoverContent/3.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="row thisMain">
                <div class="col-2 left">
                    <div class="videoAD">
                        <video autoplay muted loop playsinline>
                            <source src="IMG/backgrounds/DiscoverAd/discoverPromitionalVideo.mp4" type="video/mp4">
                            Your browser does not support HTML5 video.
                        </video>
                    </div>
                </div> <!-- Empty left column for balance -->

                <div class="col-6">
                    <div class="feed">
                        <?php if (!empty($publicPosts)): ?>
                            <?php foreach ($publicPosts as $post): ?>
                                <div class="post">
                                    <!-- Squad Info -->
                                    <div class="postSquadInfo">
                                        <a href="guestSquadDetailsPage.php?id=<?= $post['Squad_ID'] ?>" class="squadName">
                                            <?= htmlspecialchars($post['Squad_Name']) ?>
                                        </a>
                                        <span class="postTime"><?= htmlspecialchars(date('F j, Y g:i A', strtotime($post['Timestamp']))) ?></span>
                                    </div>
                                    
                                    <?php if (!empty($post['Image_URL'])): ?>
                                        <div class="attachedIMG">
                                            <img src="<?= htmlspecialchars($post['Image_URL']) ?>" alt="Post Image" class="attachedIMG">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="caption">
                                        <?= htmlspecialchars($post['Content']) ?>
                                    </div>
                                    
                                    <?php if (!empty($post['Post_Label'])): ?>
                                        <div class="postedLabels">
                                            <div class="labelTag"><?= htmlspecialchars($post['Post_Label']) ?></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="post">No public posts found.</div>
                        <?php endif; ?>

                        <!-- End Message -->
                        <div class="end">End of Feed</div>
                    </div>
                </div>
                
                <div class="col-1"></div>

                <div class="col-3 right">
                <div class="adver">
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

                    <!-- Leaderboard Box -->
                    <div class="leaderboardBox">
                            <!-- Table Header -->
                            <div class="leaderboardRow leaderboardHeader">
                                <div class="leaderboardRank"></div>
                                <div class="leaderboardSquad">SQUAD</div>
                                <div class="leaderboardPoints">ABYSS POINTS</div>
                            </div>
                            
                            <!-- Top 1 -->
                            <div class="leaderboardRow">
                                <div class="leaderboardRank">1</div>
                                <div class="leaderboardSquad">
                                    <div class="squadNameContainer">
                                        <div class="shortName">VST</div>
                                        <div class="fullName">VESTA HEAVEN</div>
                                    </div>
                                </div>
                                
                                <div class="leaderboardPoints">
                                    <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">
                                    34,712
                                </div>
                            </div>

                            <!-- Top 2 -->
                            <div class="leaderboardRow">
                                <div class="leaderboardRank">2</div>
                                <div class="leaderboardSquad">
                                    <div class="squadNameContainer">
                                        <div class="shortName">LSB</div>
                                        <div class="fullName">LYCEUM SHARKS</div>
                                    </div>
                                </div>
                                
                                <div class="leaderboardPoints">
                                    <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">
                                    31,223
                                </div>
                            </div>

                            <!-- Top 3 -->
                            <div class="leaderboardRow">
                                <div class="leaderboardRank">3</div>
                                <div class="leaderboardSquad">
                                    <div class="squadNameContainer">
                                        <div class="shortName">C++</div>
                                        <div class="fullName">C++ ESPORTS</div>
                                    </div>
                                </div>
                                
                                <div class="leaderboardPoints">
                                    <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">
                                    29,175
                                </div>
                            </div>

                            <!-- Top 4 -->
                            <div class="leaderboardRow">
                                <div class="leaderboardRank">4</div>
                                <div class="leaderboardSquad">
                                    <div class="squadNameContainer">
                                        <div class="shortName">Hero</div>
                                        <div class="fullName">HERO GAMERPACT</div>
                                    </div>
                                </div>
                                
                                <div class="leaderboardPoints">
                                    <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">
                                    29,173
                                </div>
                            </div> 
                            
                            <!-- Top 5 -->
                            <div class="leaderboardRow">
                                <div class="leaderboardRank">5</div>
                                <div class="leaderboardSquad">
                                    <div class="squadNameContainer">
                                        <div class="shortName">BABY</div>
                                        <div class="fullName">BABY GIRLS</div>
                                    </div>
                                </div>
                                
                                <div class="leaderboardPoints">
                                    <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">
                                    24,764
                                </div>
                            </div> 

                            <!-- Top 6 -->
                            <div class="leaderboardRow">
                                <div class="leaderboardRank">6</div>
                                <div class="leaderboardSquad">
                                    <div class="squadNameContainer">
                                        <div class="shortName">BLCK</div>
                                        <div class="fullName">BLACKLIST INTERNATIONAL</div>
                                    </div>
                                </div>
                                
                                <div class="leaderboardPoints">
                                    <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">
                                    23,783
                                </div>
                            </div> 

                            <!-- Top 7 -->
                            <div class="leaderboardRow">
                                <div class="leaderboardRank">7</div>
                                <div class="leaderboardSquad">
                                    <div class="squadNameContainer">
                                        <div class="shortName">BLTW</div>
                                        <div class="fullName">BOLTWO ESPORTS</div>
                                    </div>
                                </div>
                                
                                <div class="leaderboardPoints">
                                    <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">
                                    21,846
                                </div>
                            </div> 

                            <!-- Top 8 -->
                            <div class="leaderboardRow">
                                <div class="leaderboardRank">8</div>
                                <div class="leaderboardSquad">
                                    <div class="squadNameContainer">
                                        <div class="shortName">OZ</div>
                                        <div class="fullName">WIZARDS OF OZ</div>
                                    </div>
                                </div>
                                
                                <div class="leaderboardPoints">
                                    <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">
                                    18,863
                                </div>
                            </div> 

                            <!-- Top 9 -->
                            <div class="leaderboardRow">
                                <div class="leaderboardRank">9</div>
                                <div class="leaderboardSquad">
                                    <div class="squadNameContainer">
                                        <div class="shortName">BABY</div>
                                        <div class="fullName">MIYEON ESPORTS</div>
                                    </div>
                                </div>
                                
                                <div class="leaderboardPoints">
                                    <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">
                                    18,022
                                </div>
                            </div> 

                            <!-- Top 10 -->
                            <div class="leaderboardRow">
                                <div class="leaderboardRank">10</div>
                                <div class="leaderboardSquad">
                                    <div class="squadNameContainer">
                                        <div class="shortName">X</div>
                                        <div class="fullName">THALASSOPHOBIA</div>
                                    </div>
                                </div>
                                
                                <div class="leaderboardPoints">
                                    <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">
                                    13,981
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Notification Modal (same as user homepage) -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="squadVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-end">
            <div class="modal-content customModal" style="height: 100vh;">
                <div class="modal-header">
                    <h5 class="modal-title" id="squadVerificationModalLabel">NOTIFICATIONS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($invites)): ?>
                        <?php foreach ($invites as $invite): ?>
                            <div class="notification <?= $invite['Response'] === 'Pending' ? 'new' : '' ?>" data-invite-id="<?= $invite['Schedule_ID'] ?>">
                                <div class="time">
                                    <?= date('n/j/Y g:i', strtotime($invite['Created_At'])) ?>
                                </div>
                                <strong><?= htmlspecialchars($invite['Squad_Name']) ?></strong> invites you to a scrim match!
                                <div class="scrim-cardOnNotif">
                                    <div class="scrim-card-contentOnNotif">
                                        <div class="scrimButtons">
                                            <?php if ($invite['Response'] === 'Pending'): ?>
                                                <!-- Interactive buttons for pending invites -->
                                                <button class="acceptOnNotif" onclick="respondToInvite(<?= $invite['Schedule_ID'] ?>, 'Accepted')">
                                                    ACCEPT
                                                </button>
                                                <button class="declineOnNotif" onclick="respondToInvite(<?= $invite['Schedule_ID'] ?>, 'Declined')">
                                                    DECLINE
                                                </button>
                                            <?php else: ?>
                                                <!-- Non-clickable status for responded invites -->
                                                <button class="<?= $invite['Response'] === 'Accepted' ? 'acceptedOnNotif' : 'declinedOnNotif' ?>" disabled>
                                                    <?= strtoupper($invite['Response']) ?>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                        <!-- Opponent Squad Name -->
                                        <div class="opponentOnNotif">
                                            <div class="squadNameOnNotif">
                                                <span class="vs">VS</span> <strong><?= htmlspecialchars($invite['Squad_Name']) ?></strong>
                                            </div>
                                        </div>

                                        <!-- Scrim Notes (if available) -->
                                        <?php if (!empty($invite['No_Of_Games'])): ?>
                                            <div class="noGamesOnNotif">
                                                BEST OF <?= htmlspecialchars($invite['No_Of_Games']) ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Date and Time -->
                                        <div class="timeAndDateOnNotif">
                                            <!-- Time -->
                                            <div class="TimeOnNotif">
                                                <?= date('g:i A', strtotime($invite['Scrim_Time'])) ?>
                                            </div>
                                            <!-- Date -->
                                            <div class="DateOnNotif">
                                                <?= date('Y-m-d', strtotime($invite['Scrim_Date'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>   

                    <!-- Verification Automated Message -->
                    <?php foreach ($verificationNotifs as $scrim): 
                        // Check if verification was already submitted
                        $stmt = $pdo->prepare("SELECT * FROM tbl_matchverifications 
                                            WHERE Match_ID = ? AND Squad_ID = ?");
                        $stmt->execute([$scrim['Match_ID'], $_SESSION['user']['Squad_ID']]);
                        $verificationSubmitted = $stmt->fetch();
                    ?>

                        <div class="notification <?= $verificationSubmitted ? '' : 'new' ?>" data-scrim-id="<?= $scrim['Match_ID'] ?>">
                            <div class="time">
                                <?= date('n/j/Y g:i', strtotime($scrim['Scheduled_Time'])) ?>
                            </div>
                            <strong>Scrim match finished!</strong> Time to verify and earn Abyss Points!
                            <div class="scrim-cardOnNotif">
                                <div class="scrim-card-contentOnNotif">
                                    <!-- Single Verify Button -->
                                    <div class="scrimButtons">
                                        <?php if ($verificationSubmitted): ?>
                                            <button class="pendingOnNotif" disabled>
                                                PENDING
                                            </button>
                                        <?php else: ?>
                                            <a href="matchVerificationPage.php?scrim_id=<?= $scrim['Match_ID'] ?>">
                                                <button class="verifyOnNotif">
                                                    VERIFY
                                                </button>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Opponent Info -->
                                    <div class="opponentOnNotif">
                                        <div class="squadNameOnNotif">
                                            <span>VS</span> <strong>
                                                <?= htmlspecialchars($scrim['Squad1_ID'] == $_SESSION['user']['Squad_ID'] 
                                                    ? $scrim['Squad2_Name'] 
                                                    : $scrim['Squad1_Name']) ?>
                                            </strong>
                                        </div>
                                    </div>
                                    
                                    <!-- Scheduled Time -->
                                    <div class="timeAndDateOnNotif">
                                        <div class="TimeOnNotif">
                                            <?= date('g:i A', strtotime($scrim['Scheduled_Time'])) ?>
                                        </div>
                                        <div class="DateOnNotif">
                                            <?= date('Y-m-d', strtotime($scrim['Scheduled_Time'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <?php if (empty($invites) && empty($verificationNotifs)): ?>
                        <div class="notification">
                            <div class="noNotifications">No new notifications</div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="notifEnd">End of Feed</div>
                </div>                        
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script src="JS/discoverScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>