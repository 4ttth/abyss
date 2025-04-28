<?php
// Start session and include DB connection
session_start();
require_once 'includes/dbh.inc.php'; // Make sure this sets up the $pdo object

// Retrieve and sanitize the search query (using 'query' from the form input)
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

// Initialize empty results array
$squads = [];

// Only search if a query was provided
if (!empty($searchQuery)) {
    $searchTerm = "%$searchQuery%"; // Add wildcards for partial matching

    // Prepare SQL using PDO (safe from SQL injection)
    $sql = "SELECT Squad_Acronym, Squad_Name, Squad_ID, Squad_Level, Squad_Description 
            FROM tbl_squadprofile 
            WHERE Squad_Name LIKE ? OR Squad_Acronym LIKE ?"; // Using ? placeholders instead of :search
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$searchTerm, $searchTerm]); // Pass parameters in order
    $squads = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Close connection
$pdo = null;

// Pass data to JavaScript as JSON
echo "<script>";
echo "const squadData = " . json_encode($squads) . ";";
echo "const searchQuery = " . json_encode($searchQuery) . ";";
echo "</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Search Results</title>
    <link rel="stylesheet" type="text/css" href="CSS/guestSearchResultsStyle.css">
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
                            <a class="nav-link" aria-current="page" href="index.php">HOME</a>
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

        <!-- Content -->
        <div class="content">
            <div class="resultHeader">
                <div class="resultTitle">
                    Search Results
                </div>
                <div class="resultDescription">
                    You searched for: <strong><?php echo $searchQuery; ?></strong>
                </div>
            </div>
            
            <!-- Search Results Grid -->
            <div class="container-fluid results">
                <div class="row g-3 searchResultsGrid">
                    <!-- Results will be dynamically inserted here -->
                </div>
            </div>

            <!-- Pagination Controls Button -->
            <div class="scrim-pagination pagination-controls">
                <button id="prevPage" class="page-btn prev-btn pagination-button" disabled>Previous</button>
                <span id="pageInfo" class="page-indicator">Page 1</span>
                <button id="nextPage" class="page-btn next-btn pagination-button">Next</button>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script>
        // Pagination
        document.addEventListener('DOMContentLoaded', function () {
            const postsPerPage = 12; // 12 results per page so that it looks visually pleasing
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
    <script src="JS/guestSearchResultsScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>