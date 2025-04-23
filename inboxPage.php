<?php
session_start();
require_once 'includes/dbh.inc.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$currentSquadId = $_SESSION['user']['Squad_ID'];

// Function to get all conversations for the current squad
function getConversations($pdo, $squadId) {
    $stmt = $pdo->prepare("SELECT c.*, 
                          s1.Squad_Name as Squad1_Name, s1.Squad_ID as Squad1_ID,
                          s2.Squad_Name as Squad2_Name, s2.Squad_ID as Squad2_ID,
                          m.Content as Last_Message,
                          m.Created_At as Last_Message_Time
                          FROM tbl_conversations c
                          JOIN tbl_squadprofile s1 ON c.Squad1_ID = s1.Squad_ID
                          JOIN tbl_squadprofile s2 ON c.Squad2_ID = s2.Squad_ID
                          LEFT JOIN tbl_messages m ON c.Last_Message_ID = m.Message_ID
                          WHERE c.Squad1_ID = ? OR c.Squad2_ID = ?
                          ORDER BY c.Updated_At DESC");
    $stmt->execute([$squadId, $squadId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get messages for a specific conversation
function getMessages($pdo, $conversationId, $squadId) {
    $stmt = $pdo->prepare("SELECT m.*, s.Squad_Name as Sender_Name
                          FROM tbl_messages m
                          JOIN tbl_squadprofile s ON m.Sender_Squad_ID = s.Squad_ID
                          WHERE m.Conversation_ID = ?
                          ORDER BY m.Created_At ASC");
    $stmt->execute([$conversationId]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Mark messages as read if they're for the current squad
    $stmt = $pdo->prepare("UPDATE tbl_messages 
                          SET Is_Read = TRUE 
                          WHERE Conversation_ID = ? 
                          AND Recipient_Squad_ID = ?");
    $stmt->execute([$conversationId, $squadId]);
    
    // Update unread count in conversation
    $stmt = $pdo->prepare("UPDATE tbl_conversations 
                          SET Squad1_Unread = IF(Squad1_ID = ?, 0, Squad1_Unread),
                              Squad2_Unread = IF(Squad2_ID = ?, 0, Squad2_Unread)
                          WHERE Conversation_ID = ?");
    $stmt->execute([$squadId, $squadId, $conversationId]);
    
    return $messages;
}

// Function to get the other squad in a conversation
function getOtherSquad($conversation, $currentSquadId) {
    // Debug: Check what's actually in the conversation array
    error_log("Conversation data: " . print_r($conversation, true));
    error_log("Current Squad ID: " . $currentSquadId);

    // Check if we have valid conversation data with required fields
    if (!isset($conversation['Squad1_ID']) || !isset($conversation['Squad2_ID'])) {
        error_log("Missing required squad IDs in conversation data");
        return ['Squad_ID' => 0, 'Squad_Name' => 'Unknown Squad'];
    }

    // Determine which squad is the other one
    if ($conversation['Squad1_ID'] == $currentSquadId) {
        $otherSquad = [
            'Squad_ID' => $conversation['Squad2_ID'] ?? 0,
            'Squad_Name' => $conversation['Squad2_Name'] ?? 'Unknown Squad'
        ];
    } else {
        $otherSquad = [
            'Squad_ID' => $conversation['Squad1_ID'] ?? 0,
            'Squad_Name' => $conversation['Squad1_Name'] ?? 'Unknown Squad'
        ];
    }

    error_log("Other squad determined: " . print_r($otherSquad, true));
    return $otherSquad;
}

// Get all conversations for the current squad
$conversations = getConversations($pdo, $currentSquadId);

// Check if a specific conversation is selected
$selectedConversation = null;
$messages = [];
if (isset($_GET['conversation_id']) && is_numeric($_GET['conversation_id'])) {
    $conversationId = $_GET['conversation_id'];
    
    // Verify the current squad is part of this conversation
    $stmt = $pdo->prepare("SELECT * FROM tbl_conversations 
                          WHERE Conversation_ID = ? 
                          AND (Squad1_ID = ? OR Squad2_ID = ?)");
    $stmt->execute([$conversationId, $currentSquadId, $currentSquadId]);
    $selectedConversation = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($selectedConversation) {
        $messages = getMessages($pdo, $conversationId, $currentSquadId);
    }
}

// Handle sending a new message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && $selectedConversation) {
    $messageContent = trim($_POST['message']);
    
    if (!empty($messageContent)) {
        // Determine recipient
        $recipientId = $selectedConversation['Squad1_ID'] == $currentSquadId ? 
            $selectedConversation['Squad2_ID'] : $selectedConversation['Squad1_ID'];
        
        // Insert the new message
        $stmt = $pdo->prepare("INSERT INTO tbl_messages 
                              (Conversation_ID, Sender_Squad_ID, Recipient_Squad_ID, Content)
                              VALUES (?, ?, ?, ?)");
        $stmt->execute([$selectedConversation['Conversation_ID'], $currentSquadId, $recipientId, $messageContent]);
        $messageId = $pdo->lastInsertId();
        
        // Update the conversation's last message info
        $stmt = $pdo->prepare("UPDATE tbl_conversations 
                              SET Last_Message_ID = ?, 
                                  Last_Message_Time = NOW(),
                                  Updated_At = NOW(),
                                  Squad1_Unread = IF(Squad1_ID = ?, Squad1_Unread, Squad1_Unread + 1),
                                  Squad2_Unread = IF(Squad2_ID = ?, Squad2_Unread, Squad2_Unread + 1)
                              WHERE Conversation_ID = ?");
        $stmt->execute([$messageId, $currentSquadId, $currentSquadId, $selectedConversation['Conversation_ID']]);
        
        // Refresh the page to show the new message
        header("Location: inboxPage.php?conversation_id=" . $selectedConversation['Conversation_ID']);
        exit();
    }
}

// Replace the existing invite query with:
$stmt = $pdo->prepare("SELECT i.*, s.Squad_Name 
                      FROM tbl_inviteslog i
                      JOIN tbl_squadprofile s ON i.Challenger_Squad_ID = s.Squad_ID
                      WHERE i.Squad_ID = ?
                      ORDER BY i.Created_At DESC");
$stmt->execute([$_SESSION['user']['Squad_ID']]);
$invites = $stmt->fetchAll(PDO::FETCH_ASSOC);
// $newInvitesCount = count(array_filter($invites, fn($invite) => $invite['Response'] === 'Pending'));

// // ADD THE NEW CODE RIGHT HERE:
$verificationNotifs = getVerificationNotifications($pdo, $_SESSION['user']['Squad_ID']);
$newInvitesCount = count(array_filter($invites, fn($invite) => $invite['Response'] === 'Pending'));
$verificationCount = count($verificationNotifs);
$totalNotifications = $newInvitesCount + $verificationCount;

// Replace your existing notification count code with:
    $verificationCount = count(array_filter($verificationNotifs, function($scrim) use ($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM tbl_matchverifications 
                              WHERE Match_ID = ? AND Squad_ID = ?");
        $stmt->execute([$scrim['Match_ID'], $_SESSION['user']['Squad_ID']]);
        return !$stmt->fetch();
    }));
    
    $totalNotifications = $newInvitesCount + $verificationCount;

// Add this near where you fetch the invites
$pendingInvitesCount = 0;
if (!empty($invites)) {
    $pendingInvitesCount = count(array_filter($invites, function($invite) {
        return $invite['Status'] === 'Pending';
    }));
}

// Add this near your other notification queries
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

// Get notification counts (from your existing code)
$verificationNotifs = getVerificationNotifications($pdo, $currentSquadId);
$newInvitesCount = count(array_filter($invites, fn($invite) => $invite['Response'] === 'Pending'));
$verificationCount = count($verificationNotifs);
$totalNotifications = $newInvitesCount + $verificationCount;

// sledgehammer
// Function to count unread messages
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

// Get unread message count
$unreadMessageCount = countUnreadMessages($pdo, $_SESSION['user']['Squad_ID']);

// FIFTHHARMONY
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Inbox</title>
    <link rel="stylesheet" type="text/css" href="CSS/inboxStyle.css">
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
                            <input class="searchInput" type="search" name="query" placeholder="Search Squads" aria-label="Search" disabled>
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
                            <a class="nav-link" aria-current="page" href="userHomepage.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="discoverPage.php">DISCOVER</a>
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
                            <!-- sledgehammer -->
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

        <!-- Main Body with success content -->
        <div class="container-fluid mainBody">
            <div class="box">
                <!-- Replace the Inbox Box section with this: -->
                <div class="row inbox">
                    <!-- Conversations -->
                    <div class="col-3 conversations">
                        <?php foreach ($conversations as $conversation): 
                            $otherSquad = getOtherSquad($conversation, $currentSquadId);
                            $unreadCount = $conversation['Squad1_ID'] == $currentSquadId ? 
                                $conversation['Squad1_Unread'] : $conversation['Squad2_Unread'];
                            ?>

                            <!-- Conversation Card (yung nasa left) -->
                            <a href="inboxPage.php?conversation_id=<?= $conversation['Conversation_ID'] ?>" 
                            class="conversationCard <?= ($selectedConversation && $selectedConversation['Conversation_ID'] == $conversation['Conversation_ID']) ? 'active' : '' ?> 
                            <?= $unreadCount > 0 ? 'newMessage' : '' ?>">
                                <div class="notifName">
                                    <?= htmlspecialchars($otherSquad['Squad_Name']) ?>
                                </div>
                                <div class="lastMessage">    
                                    <?= !empty($conversation['Last_Message']) ? 
                                        htmlspecialchars(substr($conversation['Last_Message'], 0, 30) . (strlen($conversation['Last_Message']) > 30 ? '...' : '')) : 
                                        'No messages yet' ?>
                                </div>
                                <?php if ($unreadCount > 0): ?>
                                    <span class="unreadCount"><?= $unreadCount ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                        
                        <?php if (empty($conversations)): ?>
                            <div class="no-conversations">
                                You don't have any conversations yet.
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Messages -->
                    <div class="col-9 messages">
                        <?php if ($selectedConversation): 
                            $otherSquad = getOtherSquad($selectedConversation, $currentSquadId);
                        ?>
                            <!-- Squad Name Header -->
                            <!-- <div class="squad-header messageHeader">
                                <div class="notifName"><?= htmlspecialchars($otherSquad['Squad_Name']) ?></h3>
                            </div> -->
                            
                            <!-- Messages Container -->
                            <div class="messagesPart" id="messagesContainer">
                                <!-- In your messages loop -->
                                <?php foreach ($messages as $message): ?>
                                    <div class="message <?= $message['Sender_Squad_ID'] == $currentSquadId ? 'outgoing' : 'incoming' ?>" 
                                        data-message-id="<?= $message['Message_ID'] ?>">
                                        <?php if ($message['Sender_Squad_ID'] != $currentSquadId): ?>
                                            <a href="squadDetailsPage.php?id=<?= $message['Sender_Squad_ID'] ?>" class="squadNameSender">
                                                <?= htmlspecialchars($message['Sender_Name']) ?>
                                            </a>
                                        <?php endif; ?>
                                        <div class="bubble"><?= nl2br(htmlspecialchars($message['Content'])) ?></div>
                                        <div class="message-time"><?= date('h:i A', strtotime($message['Created_At'])) ?></div>
                                    </div>
                                <?php endforeach; ?>
                                
                                <?php if (empty($messages)): ?>
                                    <div class="no-messages">
                                        Start the conversation!
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Text Input Area -->
                            <div class="textArea">
                                <form method="POST" id="messageForm">
                                    <div class="input-group">
                                        <textarea class="form-control" name="message" placeholder="Type your message here..." rows="1" required></textarea>
                                        <button type="submit" class="btn send-btn"><i class="bi bi-send-fill"></i></button>
                                    </div>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="no-conversation-selected">
                                <p>Select a conversation to start messaging</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advertisment -->
        <div class="container">
            <div class="row d-flex advertisement">
                <a href="https://play.google.com/store/apps/details?id=com.hhgame.mlbbvn&hl=en-US&pli=1">
                    <img src="IMG/essentials/advertisement.png" class="adIMG" alt="advertisement">
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
    
    <!-- Notification Modal -->
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
                                            <span class="vs">VS</span> <strong>
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
    <script src="JS/inboxScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>