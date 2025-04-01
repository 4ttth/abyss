<?php
    session_start(); // Start the session
    require_once 'includes/dbh.inc.php'; // Database connection
    $squadID = $_SESSION['user']['Squad_ID'];
    $stmt = $pdo->prepare("SELECT Squad_Acronym, Squad_Name, Squad_ID, Squad_Level FROM tbl_squadprofile WHERE Squad_ID = ?"); // Ensure the table name is correct
    $stmt->execute([$squadID]);
    $squadDetails = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Scrim Matchmaking</title>
    <link rel="stylesheet" type="text/css" href="CSS/matchmakingStyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="IMG/essentials/whiteVer.PNG">
</head>

<body class="customPageBackground">
    <div class="content">
        <div class="resultTitle">
            FIND A SCRIM MATCH
        </div>

        <label for="range" class="resultDescription">Set Custom Range (+/-):</label>
        <input type="number" id="customRange" value="5">
        <button class="viewDetailsButton" id="searchButton">SEARCH</button>

        <!-- Search Results Grid -->
        <div class="container-fluid results">
            <div class="row g-3 searchResultsGrid">
                <div id="squadList">
                <!-- Available squads will be displayed here again change for testing -->
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination mt-4">
            <button id="prevPage" class="btn btn-outline-light" disabled>Previous</button>
            <span id="pageInfo" class="mx-3">Page 1 of 1</span>
            <button id="nextPage" class="btn btn-outline-light" disabled>Next</button>
        </div>        
    </div>
   
    <!-- Challenge Modal -->
    <div class="modal fade" id="challengeModal" tabindex="-1" aria-labelledby="challengeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content customModal">
                <div class="modal-header">
                    <h5 class="modal-title" id="challengeModalLabel">SCHEDULE SCRIM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for scrim schedule details -->
                    <form id="scrimScheduleForm">
                        <div class="mb-3">
                            <label for="scrimDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="scrimDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="scrimTime" class="form-label">Time</label>
                            <input type="time" class="form-control" id="scrimTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="scrimNotes" class="form-label">Notes</label>
                            <textarea class="form-control" id="scrimNotes" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modalButtons" data-bs-dismiss="modal">CLOSE</button>
                    <button type="button" class="modalButtons" onclick="submitScrimSchedule()">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>

    <script src="JS/matchmakingScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
