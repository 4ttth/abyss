<?php
session_start(); // Start the session
require_once 'includes/dbh.inc.php'; // Database connection

// Initialize user data from session with proper fallback values
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [
    'User_ID' => 'N/A',
    'Username' => 'Guest',
    'Squad_ID' => 'N/A',
    'Role' => 'Guest'
];

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

// Fetch squad leaderboard by abyss_score
try {
    $stmtLeaderboard = $pdo->prepare("SELECT Squad_Acronym, Squad_Name, abyss_score 
                                      FROM tbl_squadprofile 
                                      ORDER BY abyss_score DESC 
                                      LIMIT 10");
    $stmtLeaderboard->execute();
    $leaderboard = $stmtLeaderboard->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $leaderboard = [];
}

// Notification count logic (similar to user homepage)
$totalNotifications = 0;
$unreadMessageCount = 0;

if (isset($_SESSION['user']['Squad_ID'])) {
    // Fetch pending invites
    try {
        $stmt = $pdo->prepare("SELECT i.*, s.Squad_Name 
                             FROM tbl_inviteslog i
                             JOIN tbl_squadprofile s ON i.Challenger_Squad_ID = s.Squad_ID
                             WHERE i.Squad_ID = ?
                             ORDER BY i.Created_At DESC");
        $stmt->execute([$_SESSION['user']['Squad_ID']]);
        $invites = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $newInvitesCount = count(array_filter($invites, fn($invite) => $invite['Response'] === 'Pending'));
    } catch (PDOException $e) {
        $newInvitesCount = 0;
    }

    // Fetch verification notifications
    function getVerificationNotifications($pdo, $squadID) {
        $currentTime = date('Y-m-d H:i:s');
        $stmt = $pdo->prepare("SELECT s.*, 
                              sp1.Squad_Name as Squad1_Name,
                              sp2.Squad_Name as Squad2_Name
                              FROM tbl_scrimslog s
                              JOIN tbl_squadprofile sp1 ON s.Squad1_ID = sp1.Squad_ID
                              JOIN tbl_squadprofile sp2 ON s.Squad2_ID = sp2.Squad_ID
                              WHERE (s.Squad1_ID = ? OR s.Squad2_ID = ?)
                              AND s.Scheduled_Time < ?
                              AND s.OCR_Validated = 0
                              AND s.Winner_Squad_ID IS NULL
                              ORDER BY s.Scheduled_Time DESC");
        $stmt->execute([$squadID, $squadID, $currentTime]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $verificationNotifs = getVerificationNotifications($pdo, $_SESSION['user']['Squad_ID']);
    $verificationCount = count($verificationNotifs);
    $totalNotifications = $newInvitesCount + $verificationCount;

    // Count unread messages
    function countUnreadMessages($pdo, $squadId) {
        $stmt = $pdo->prepare("SELECT SUM(
                                CASE 
                                    WHEN Squad1_ID = ? THEN Squad1_Unread 
                                    WHEN Squad2_ID = ? THEN Squad2_Unread 
                                    ELSE 0 
                                END) as total_unread
                              FROM tbl_conversations
                              WHERE Squad1_ID = ? OR Squad2_ID = ?");
        $stmt->execute([$squadId, $squadId, $squadId, $squadId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_unread'] ?? 0;
    }

    $unreadMessageCount = countUnreadMessages($pdo, $_SESSION['user']['Squad_ID']);
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
                        <a class="navbar-brand" href="userHomepage.php">
                            <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                            <div class="logoText">abyss</div>
                        </a>
                       
                        <!-- Search Bar -->
                        <form class="searchBar" action="searchResultsPage.php" method="GET">
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
                            <a class="nav-link" href="userHomepage.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="discoverPage.php">DISCOVER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="scrimsPage.php">SCRIMS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="invitesPage.php">MY INVITES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="invitesSentPage.php">SENT INVITES</a>
                        </li>
                        <!-- Icon Bars -->
                        <div class="iconsBar">
                            <!-- Notifications -->
                            <li class="nav-item">
                                <a class="nav-linkIcon" href="#" data-bs-toggle="modal" data-bs-target="#notificationModal">
                                    <i class="bi bi-app-indicator"></i>
                                    <?php if ($totalNotifications > 0): ?>
                                        <span class="notifCount"><?= $totalNotifications ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <!-- Inbox -->
                            <li class="nav-item">
                                <a class="nav-linkIcon ju" href="inboxPage.php">
                                    <i class="bi bi-chat-left-fill"></i>
                                    <?php if ($unreadMessageCount > 0): ?>
                                        <span class="notifCount"><?= $unreadMessageCount ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        </div>
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
                        <?php
                        $carousel = $pdo->query("SELECT * FROM tbl_carousels WHERE Show_Status = 'Shown' LIMIT 1")->fetch();
                        ?>
                        <?php if ($carousel): ?>
                            <div class="carousel-item active">
                                <img src="<?= htmlspecialchars($carousel['Image1']) ?>" class="d-block w-100" alt="Carousel Image 1">
                            </div>
                            <div class="carousel-item">
                                <img src="<?= htmlspecialchars($carousel['Image2']) ?>" class="d-block w-100" alt="Carousel Image 2">
                            </div>
                            <div class="carousel-item">
                                <img src="<?= htmlspecialchars($carousel['Image3']) ?>" class="d-block w-100" alt="Carousel Image 3">
                            </div>
                        <?php else: ?>
                            <p>No active carousel yet.</p>
                        <?php endif; ?>
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
                                <div class="post post-item"> <!-- Added post-item for pagination validation -->
                                    <!-- Squad Info -->
                                    <div class="postSquadInfo">
                                        <a href="squadDetailsPage.php?id=<?= $post['Squad_ID'] ?>" class="squadName">
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

                    <!-- Pagination Controls Button -->
                    <div class="scrim-pagination pagination-controls">
                        <button id="prevPage" class="page-btn prev-btn pagination-button" disabled>Previous</button>
                        <span id="pageInfo" class="page-indicator">Page 1</span>
                        <button id="nextPage" class="page-btn next-btn pagination-button">Next</button>
                    </div>

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
     <script>
        // Pagination
        document.addEventListener('DOMContentLoaded', function () {
            const postsPerPage = 10;
            let currentPage = 1;
            const posts = document.querySelectorAll('.post-item');
            const totalPages = Math.ceil(posts.length / postsPerPage);
            const prevButton = document.getElementById('prevPage');
            const nextButton = document.getElementById('nextPage');
            const pageInfo = document.getElementById('pageInfo');

            function showPage(page) {
                posts.forEach((post, index) => {
                    post.style.display = (index >= (page - 1) * postsPerPage && index < page * postsPerPage) ? 'block' : 'none';
                });
                pageInfo.textContent = `Page ${page}`;
                prevButton.disabled = page === 1;
                nextButton.disabled = page === totalPages;
            }

            prevButton.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                }
            });

            nextButton.addEventListener('click', () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    showPage(currentPage);
                }
            });

            // Initialize the first page
            showPage(currentPage);
        });
    </script>
    <script src="JS/discoverScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>