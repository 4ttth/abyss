document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelector(".introScreen").style.display = "none"; 
        document.querySelector(".pageContent").classList.add("showContent");
    }, 500); // Matches animation duration
});

document.addEventListener('DOMContentLoaded', function() {
    const subtitleRight = document.querySelector('.subtitleRight');
    if (subtitleRight) {
        const now = new Date();
        const dd = String(now.getDate()).padStart(2, '0');
        const mm = String(now.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
        const yyyy = now.getFullYear();
        subtitleRight.innerText = `AS OF ${dd}${mm}${yyyy}`;
    }
});

document.addEventListener("DOMContentLoaded", function () {
    let authModal = document.getElementById("authModal");

    authModal.addEventListener("shown.bs.modal", function () {
        document.body.style.overflow = "hidden"; // Prevent scrolling
    });

    authModal.addEventListener("hidden.bs.modal", function () {
        document.body.style.overflow = ""; // Restore scrolling
    });
});

// Grid Responsiveness
document.addEventListener('DOMContentLoaded', function () {
    const resultsGrid = document.querySelector('.searchResultsGrid');
    const prevPageButton = document.getElementById('prevPage');
    const nextPageButton = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');
    const pagination = document.querySelector('.pagination');

    let currentPage = 1;
    const resultsPerPage = 15; // 3x5 grid

    // Function to display results for the current page
    function displayResults(page) {
        resultsGrid.innerHTML = ''; // Clear previous results
        const startIndex = (page - 1) * resultsPerPage;
        const endIndex = startIndex + resultsPerPage;
        const pageResults = squadData.slice(startIndex, endIndex);

        // Create rows and columns for the grid
        for (let i = 0; i < pageResults.length; i += 3) {
            const row = document.createElement('div');
            row.className = 'row g-3';

            // Add up to 3 items per row
            for (let j = i; j < i + 3 && j < pageResults.length; j++) {
                const squad = pageResults[j];
                const col = document.createElement('div');
                col.className = 'col-4'; // 3 columns per row (12/4 = 3)
                col.innerHTML = `
                    <div class="row squadAccount">
                        <div class="squadAcronym">${squad.Squad_Acronym}</div>
                        <div class="squadName">${squad.Squad_Name}</div>
                        <div class="squadAccountID">ID: ${squad.Squad_ID}</div>
                        <div class="tabsRow">
                            <div class="tabs">${squad.Squad_Level}</div>
                        </div>
                        <div class="squadDescription">${squad.Squad_Description}</div>
                        <a href="squadDetailsPage.php?id=${squad.Squad_ID}" class="viewDetailsButton">VIEW SQUAD</a>
                    </div>
                `;
                row.appendChild(col);
            }

            resultsGrid.appendChild(row);
        }

        // Update pagination controls
        const totalPages = Math.ceil(squadData.length / resultsPerPage);
        pageInfo.textContent = `Page ${page} of ${totalPages}`;
        prevPageButton.disabled = page === 1;
        nextPageButton.disabled = page === totalPages;

        // Show or hide pagination based on the number of results
        if (squadData.length > resultsPerPage) {
            pagination.style.display = 'flex'; // Show pagination
        } else {
            pagination.style.display = 'none'; // Hide pagination
        }
    }

    // Initial display
    displayResults(currentPage);

    // Pagination event listeners
    prevPageButton.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            displayResults(currentPage);
        }
    });

    nextPageButton.addEventListener('click', () => {
        if (currentPage < Math.ceil(squadData.length / resultsPerPage)) {
            currentPage++;
            displayResults(currentPage);
        }
    });
});

// No Result
document.addEventListener('DOMContentLoaded', function () {
    const resultsGrid = document.querySelector('.searchResultsGrid');

    if (squadData.length === 0) {
        resultsGrid.innerHTML = `<div class="col-12 text-center">No squads found.</div>`;
    } else {
        // Display the results as before
    }
});






















function respondToInvite(scheduleId, action) {
    const buttons = document.querySelectorAll(`.notification[data-invite-id="${scheduleId}"] .scrimButtons button`);
    
    // Show loading state
    buttons.forEach(btn => {
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i>';
    });

    fetch('includes/handleInviteResponse.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            schedule_id: scheduleId, 
            action: action 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notification = document.querySelector(`.notification[data-invite-id="${scheduleId}"]`);
            const buttonsContainer = notification.querySelector('.scrimButtons');

            // Update buttons to show final response
            buttonsContainer.innerHTML = `
                <button class="${action === 'Accepted' ? 'acceptedOnNotif' : 'declinedOnNotif'}" disabled>
                    ${action.toUpperCase()}
                </button>
            `;

            // Remove 'new' status
            notification.classList.remove('new');

            // Update notification count
            updateNotificationCount();
        } else {
            throw new Error(data.message || 'Action failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        buttons.forEach(btn => {
            btn.disabled = false;
            btn.innerHTML = btn.classList.contains('acceptOnNotif') ? 'ACCEPT' : 'DECLINE';
        });
        alert(error.message);
    });
}

function fetchNotificationModal() {
    fetch('includes/getNotifications.php')
        .then(response => response.text())
        .then(html => {
            document.querySelector('.modal-body').innerHTML = html;
        });
}

// Update the counter
function updateNotificationCount() {
    fetch('includes/getNotificationCount.php')
        .then(response => response.json())
        .then(data => {
            const counter = document.querySelector('.notifCount');
            if (data.count > 0) {
                if (!counter) {
                    const badge = document.createElement('span');
                    badge.className = 'notifCount';
                    document.querySelector('.nav-linkIcon').appendChild(badge);
                }
                document.querySelector('.notifCount').textContent = data.count;
            } else if (counter) {
                counter.remove();
            }
        });
}

// // Call this periodically (e.g., every 30 seconds)
// setInterval(updateNotificationCount, 30000);

// File name display script
document.getElementById('fileInput').addEventListener('change', function() {
    document.getElementById('fileName').textContent = this.files[0] ? this.files[0].name : 'No file chosen';
});

// SLEDGEHAMMER

// Function to check for new messages periodically
function checkNewMessages() {
    fetch('includes/getUnreadCount.inc.php')
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('.nav-linkIcon[href="inboxPage.php"] .notifCount');
            if (data.count > 0) {
                if (!badge) {
                    const newBadge = document.createElement('span');
                    newBadge.className = 'notifCount';
                    newBadge.textContent = data.count;
                    document.querySelector('.nav-linkIcon[href="inboxPage.php"]').appendChild(newBadge);
                } else {
                    badge.textContent = data.count;
                }
            } else if (badge) {
                badge.remove();
            }
        });
}

// Check every 30 seconds
setInterval(checkNewMessages, 30000);

// Initial check when page loads
document.addEventListener('DOMContentLoaded', checkNewMessages);