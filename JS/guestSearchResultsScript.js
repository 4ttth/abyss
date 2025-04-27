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
                        <a href="guestSquadDetailsPage.php?id=${squad.Squad_ID}" class="viewDetailsButton">VIEW SQUAD</a>
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