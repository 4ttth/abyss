document.addEventListener("DOMContentLoaded", function () {
  setTimeout(() => {
      document.querySelector(".introScreen").style.display = "none";
      document.querySelector(".pageContent").classList.add("showContent");
  }, 500); // Matches animation duration
});

const showLoading = () => {
    resultsGrid.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
};

document.addEventListener("DOMContentLoaded", function () {
  const resultsGrid = document.querySelector(".searchResultsGrid");
  const prevPageButton = document.getElementById("prevPage");
  const nextPageButton = document.getElementById("nextPage");
  const pageInfo = document.getElementById("pageInfo");
  const pagination = document.querySelector(".pagination");

  let currentPage = 1;
  const resultsPerPage = 15; // 3x5 grid
  let squadData = []; // Store fetched squads here
  const showLoading = () => {
    resultsGrid.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
};

  // Function to fetch squads from the server
  async function fetchSquads() {
    showLoading();

    try {
      const customRange = document.getElementById("customRange").value;
      const response = await fetch(
        `/includes/matchmaking.php?range=${customRange}`
      );

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();

      if (!data.success) {
        throw new Error(data.error || "Unknown error occurred");
      }

      if (data.squads.length === 0) {
        resultsGrid.innerHTML = `
                <div class="alert alert-info">
                    No squads found within ±${customRange} stars of your average (${data.current_star.toFixed(
          1
        )})
                </div>
            `;
        pagination.style.display = "none";
        return;
      }

      squadData = data.squads;
      currentPage = 1;
      displayResults(currentPage);
    } catch (error) {
      resultsGrid.innerHTML = `
            <div class="alert alert-danger">
                Error: ${error.message}
            </div>
        `;
      pagination.style.display = "none";
    }
  }

  // Function to display results for the current page
  function displayResults(page) {
    resultsGrid.innerHTML = ""; // Clear previous results
    const startIndex = (page - 1) * resultsPerPage;
    const endIndex = startIndex + resultsPerPage;
    const pageResults = squadData.slice(startIndex, endIndex);

    // Create rows and columns for the grid
    for (let i = 0; i < pageResults.length; i += 3) {
      const row = document.createElement("div");
      row.className = "row g-3";

      // Add up to 3 items per row
      for (let j = i; j < i + 3 && j < pageResults.length; j++) {
        const squad = pageResults[j];
        const col = document.createElement("div");
        col.className = "col-4"; // 3 columns per row (12/4 = 3)
        col.innerHTML = `
                    <div class="row squadAccount">
                        <div class="squadAcronym">${squad.Squad_Acronym}</div>
                        <div class="squadName">${squad.Squad_Name}</div>
                        <div class="squadAccountID">ID: ${squad.Squad_ID}</div>
                        <div class="tabsRow">
                            <div class="tabs">${squad.Squad_Level}</div>
                        </div>
                        <div class="squadDescription">${squad.Squad_Description}</div>
                        <a href="squadDetailsPage.php?id=${squad.Squad_ID}" class="viewDetailsButton">VIEW DETAILS</a>
                        <button onclick="openChallengeModal(${squad.Squad_ID})" class="viewDetailsButton">CHALLENGE</button>
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
      pagination.style.display = "flex"; // Show pagination
    } else {
      pagination.style.display = "none"; // Hide pagination
    }
  }

  // Initial fetch (optional, if you want to load squads on page load)
  fetchSquads();

  // Pagination event listeners
  prevPageButton.addEventListener("click", () => {
    if (currentPage > 1) {
      currentPage--;
      displayResults(currentPage);
    }
  });

  nextPageButton.addEventListener("click", () => {
    if (currentPage < Math.ceil(squadData.length / resultsPerPage)) {
      currentPage++;
      displayResults(currentPage);
    }
  });

  // Challenge squad function
  function challengeSquad(squadId) {
    alert(`Challenge sent to squad ID: ${squadId}`);
  }

  // Attach fetchSquads to the search button
  document
    .getElementById("searchButton")
    .addEventListener("click", fetchSquads);
});

// Function to open the challenge modal
function openChallengeModal(squadId) {
  // Store the squad ID in a global variable or data attribute
  document.getElementById("challengeModal").dataset.squadId = squadId;

  // Show the modal
  const modal = new bootstrap.Modal(document.getElementById("challengeModal"));
  modal.show();
}

// Function to handle form submission
function submitScrimSchedule() {
  const squadId = document.getElementById("challengeModal").dataset.squadId;
  const scrimDate = document.getElementById("scrimDate").value;
  const scrimTime = document.getElementById("scrimTime").value;
  const scrimNotes = document.getElementById("scrimNotes").value;

  if (!scrimDate || !scrimTime) {
    alert("Date and time are required!");
    return;
  }

  fetch("/includes/scheduleScrim.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      squadId: squadId,      // Opponent's Squad_ID
      date: scrimDate,        // Scrim_Date
      time: scrimTime,        // Scrim_Time
      notes: scrimNotes       // Scrim_Notes
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert("Scrim scheduled!");
      bootstrap.Modal.getInstance(document.getElementById("challengeModal")).hide();
    } else {
      throw new Error(data.error || "Failed to schedule scrim.");
    }
  })
  .catch(error => {
    console.error("Error:", error);
    alert(error.message);
  });
}

// Notification modal handling
document.addEventListener('DOMContentLoaded', function() {
  // Update notification badge count
  function updateNotificationBadge() {
      fetch('/includes/getUnreadNotifications.php')
          .then(response => response.json())
          .then(data => {
              const badge = document.querySelector('.notification-badge');
              if (data.count > 0) {
                  badge.textContent = data.count;
                  badge.style.display = 'block';
              } else {
                  badge.style.display = 'none';
              }
          });
  }

  // Mark all as read
  document.querySelector('.markAllRead')?.addEventListener('click', function() {
      fetch('/includes/markNotificationsRead.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
          }
      })
      .then(() => {
          updateNotificationBadge();
      });
  });

  // Initial load
  updateNotificationBadge();
});s

// Handle Accept/Decline
function respondToInvite(scheduleId, action) {
  // Disable buttons and show loading state
  const buttons = document.querySelectorAll(`.notification[data-invite-id="${scheduleId}"] .scrimButtons button`);
  buttons.forEach(btn => {
      btn.disabled = true;
      btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i>';
  });

  fetch('/includes/handleInviteResponse.php', {
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
          // Update the UI dynamically
          const notification = document.querySelector(`.notification[data-invite-id="${scheduleId}"]`);
          
          // 1. Change buttons to show response status
          const buttonsContainer = notification.querySelector('.scrimButtons');
          buttonsContainer.innerHTML = `
              <button class="${action === 'Accepted' ? 'acceptedOnNotif' : 'declinedOnNotif'}" disabled>
                  ${action.toUpperCase()}
              </button>
          `;
          
          // 2. Remove 'new' class if it exists
          notification.classList.remove('new');
          
          // 3. Update the notification counter
          updateNotificationCount();
      }
  })
  .catch(error => {
      console.error('Error:', error);
      // Reset buttons if failed
      buttons.forEach(btn => {
          btn.disabled = false;
          btn.innerHTML = btn.classList.contains('acceptOnNotif') ? 'ACCEPT' : 'DECLINE';
      });
  });
}

function fetchNotificationModal() {
  fetch('/includes/getNotifications.php')
      .then(response => response.text())
      .then(html => {
          document.querySelector('.modal-body').innerHTML = html;
      });
}

// Update the counter
function updateNotificationCount() {
  fetch('/includes/getNotificationCount.php')
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

// SLEDGEHAMMER

// Function to check for new messages periodically
function checkNewMessages() {
  fetch('/includes/getUnreadCount.inc.php')
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