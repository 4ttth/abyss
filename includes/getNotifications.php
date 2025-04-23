<?php
session_start();
require_once 'dbh.inc.php';

// Same invite query as in your main file
$stmt = $pdo->prepare("SELECT i.*, s.Squad_Name 
                      FROM tbl_inviteslog i
                      JOIN tbl_squadprofile s ON i.Challenger_Squad_ID = s.Squad_ID
                      WHERE i.Squad_ID = ?
                      ORDER BY i.Created_At DESC");
$stmt->execute([$_SESSION['user']['Squad_ID']]);
$invites = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($invites)): 
    foreach ($invites as $invite): ?>
        <div class="notification <?= $invite['Response'] === 'Pending' ? 'new' : '' ?>" data-invite-id="<?= $invite['Schedule_ID'] ?>">
            <!-- Your existing notification HTML structure -->
        </div>
    <?php endforeach; 
else: ?>
    <div class="notification">
        <div class="noNotifications">No invites yet</div>
    </div>
<?php endif; ?>
<div class="notifEnd">End of Feed</div>