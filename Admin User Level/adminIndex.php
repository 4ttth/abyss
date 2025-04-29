<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

session_start();
require_once '../includes/dbh.inc.php';

if (!in_array($_SESSION['user']['Role'], ['Admin'])) {
    header("Location: ../loginPage.php");
    exit("Access Denied!");
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Admin</title>
    <link rel="stylesheet" type="text/css" href="CSS/adminMyStyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="IMG/essentials/whiteVer.PNG">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>
    <!-- Loading Screen for Landing Page -->
    <div class="introScreen">
        <div class="loadingAnimation"></div>
    </div>

    <div class="pageContent hiddenContent">
        <!-- Vertical Navigation Bar (modified from original) -->
        <div class="container-fluid navigationBar vertical-nav">
            <!-- Logo Layer -->
            <div class="logoLayer">
                <a class="navbar-brand" href="index.php">
                    <div class="logo-stack">
                        <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                        <div class="logoText">abyss</div>
                    </div>
                </a>
            </div>
            
            <!-- Vertical Nav Links -->
            <div class="navBarOverflow">
                <ul class="nav flex-column">
                    <li class="nav-item firstItem">
                        <a class="nav-link active" href="adminIndex.php">
                            HOME
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminContentManagement.php">
                            <span class="nav-text">EVENT MANAGEMENT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminInstructionsManagement.php">
                            <span class="nav-text">INSTRUCTION MANAGEMENT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminCarouselManagement.php">
                            <span class="nav-text">CAROUSEL MANAGEMENT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminModeratorAccounts.php">
                            <span class="nav-text">MODERATOR ACCOUNTS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin User Level/Moderator Functions/modSquadAccounts.php">
                            <span class="nav-text">SQUAD ACCOUNTS</span>
                        </a>
                    </li>
                    <!-- Moderator Priivleges -->
                    <li class="nav-item">
                    <a class="nav-link" href="../Admin User Level/Moderator Functions/modIndex.php">
                            <span class="nav-text">MODERATOR INDEX</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin User Level/Moderator Functions/modReports.php">
                            REPORTS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin User Level/Moderator Functions/modFeedbacks.php">
                            FEEDBACKS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin User Level/Moderator Functions/modRequests.php">
                            <span class="nav-text">VERIFICATION REQUESTS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin User Level/Moderator Functions/modScrimsLog.php">
                            <span class="nav-text">SCRIMS LOG</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin User Level/Moderator Functions/modInvitesLog.php">
                            <span class="nav-text">INVITES LOG</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Account Logo (at bottom) -->
            <div class="nav-footer">
                <form action="../includes/logout.inc.php" method="post">
                    <button class="accountLogo" data-bs-toggle="modal" data-bs-target="#loginSignupModal">
                            <i class="bi bi-box-arrow-left"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid header">
            <!-- Header -->
            <div class="row textBlockLeft">
                <div class="titleLeft">
                    ADMIN DASHBOARD
                </div>
                <div class="descriptionLeft">
                    LOG AS OF <strong>MARCH 24, 2025</strong>
                </div>
            </div>

            <!-- Header Divider -->
            <div class=" decoDivideRight">
                <div class="decoBoxRight"></div>
                <div class="codeDecoRight">0905270     //</div>
                <div class="decoLineRight"></div>  
            </div>
        </div>

        <div class="container-fluid mainBody">
    <!-- Cloudflare Metrics Cards -->
    <div class="row mb-4 g-4">
        <div class="col-md-3">
            <div class="metric-card">
                <h5>Unique Visitors</h5>
                <div id="uniqueVisitors" class="metric-value">...</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card">
                <h5>Total Requests</h5>
                <div id="totalRequests" class="metric-value">...</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card">
                <h5>Percent Cached</h5>
                <div id="percentCached" class="metric-value">...</div>
            </div>
        </div>
    </div>

    <!-- Cloudflare Charts -->
    <div class="row mb-4 g-4">
        <div class="col-md-8">
        <div class="chart-container" style="position: relative; height:60vh; width:100%">
    <canvas id="countryTrafficChart"></canvas>
</div>
        </div>
    </div>

    <!-- System Statistics -->
    <div class="row">
        <div class="col-12">
        <div class="chart-container" style="position: relative; height:80vh; width:100%">
    <canvas id="statisticsChart"></canvas>
</div>
        </div>
    </div>
</div>
    </div>

    <!-- Javascript -->
    <script src="JS/adminScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    // Cloudflare Analytics
    let cloudflareChart = null;

async function loadCloudflareAnalytics() {
    try {
        const response = await axios.get('cloudflareAnalytics.php');
        const data = response.data;

        // Add null checks
        if(!data || data.error) {
            throw new Error(data?.error || 'No data received');
        }

        // Update metric cards with fallbacks
        document.getElementById('uniqueVisitors').textContent = 
            (data.uniqueVisitors?.toLocaleString()) || 'N/A';
            
        document.getElementById('totalRequests').textContent = 
            (data.totalRequests?.toLocaleString()) || 'N/A';
            
        document.getElementById('percentCached').textContent = 
            data.percentCached ? `${data.percentCached}%` : 'N/A';

        // Handle country chart
        const countryCtx = document.getElementById('countryTrafficChart').getContext('2d');
        if(cloudflareChart) {
            cloudflareChart.destroy();
        }
        
        cloudflareChart = new Chart(countryCtx, {
                type: 'bar',
                data: {
                    labels: data.countries,
                    datasets: [{
                        label: 'Requests',
                        data: data.countryRequests,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Requests' }
                        }
                    }
                }
            });
        } catch (error) {
        console.error('Error loading Cloudflare Analytics:', error);
        // Display error to user
        document.querySelectorAll('.metric-value').forEach(el => {
            el.textContent = 'Error loading data';
        });
    }
    }

    // System Statistics Chart (existing)
    let statisticsChart = null;

async function loadStatistics() {
    try {
        const response = await axios.get('statistics.php');
        const data = response.data;

        const ctx = document.getElementById('statisticsChart').getContext('2d');
        
        // Destroy existing chart
        if(statisticsChart) {
            statisticsChart.destroy();
        }

        statisticsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Count',
                    data: data.values,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { beginAtZero: true }
                }
            }
        });
    } catch (error) {
        console.error('Error loading statistics:', error);
    }
}


    // Load all data
    loadCloudflareAnalytics();
    loadStatistics();
</script>
</body>
</html>