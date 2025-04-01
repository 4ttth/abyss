<?php
// Retrieve and sanitize the search query
$searchQuery = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '';

// Database connection
$host = 'localhost';
$dbname = 'mlofficial_database';
$dbusername = 'root';
$dbpassword = '';

// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from tbl_squadprofile based on the search query
$sql = "SELECT Squad_Acronym, Squad_Name, Squad_ID, Squad_Level, Squad_Description 
        FROM tbl_squadprofile 
        WHERE Squad_Name LIKE ? OR Squad_Acronym LIKE ?";
$stmt = $conn->prepare($sql);

// Bind the search query to the SQL statement
$searchTerm = "%$searchQuery%"; // Add wildcards for partial matching
$stmt->bind_param("ss", $searchTerm, $searchTerm);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

$squads = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $squads[] = $row;
    }
}

// Close connection
$stmt->close();
$conn->close();

// Pass data to JavaScript as JSON
echo "<script>const squadData = " . json_encode($squads) . ";</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Search Results</title>
    <link rel="stylesheet" type="text/css" href="CSS/searchResultsStyle.css">
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
                            <a class="nav-link" href="          ">LEADERBOARDS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="          ">ABOUT US</a>
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

            <!-- Pagination -->
            <div class="pagination mt-4">
                <button id="prevPage" class="btn btn-outline-light" disabled>Previous</button>
                <span id="pageInfo" class="mx-3">Page 1 of 1</span>
                <button id="nextPage" class="btn btn-outline-light" disabled>Next</button>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script src="JS/searchResultsScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>