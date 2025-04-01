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
        `includes/matchmaking.php?range=${customRange}`
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

  // Validate the form
  if (!scrimDate || !scrimTime) {
    alert("Please fill out the date and time.");
    return;
  }

  // Send the data to the server (you can use fetch() or another method)
  const scrimData = {
    squadId: squadId,
    date: scrimDate,
    time: scrimTime,
    notes: scrimNotes,
  };

  console.log("Scrim Data:", scrimData); // For testing

  // Example: Send data to the server
  fetch("includes/scheduleScrim.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(scrimData),
  })
    .then((response) => response.json())
    .then((data) => {
      alert("Scrim scheduled successfully!");
      // Close the modal
      const modal = bootstrap.Modal.getInstance(
        document.getElementById("challengeModal")
      );
      modal.hide();
    })
    .catch((error) => {
      console.error("Error scheduling scrim:", error);
      alert("Failed to schedule scrim. Please try again.");
    });
}
