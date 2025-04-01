// Loading Screen
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelector(".introScreen").style.display = "none"; 
        document.querySelector(".pageContent").classList.add("showContent");
    }, 3000); // Matches animation duration
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

// Search Empty Validation
document.querySelector('.searchBar').addEventListener('submit', function(event) {
    const searchInput = document.querySelector('.searchInput');
    if (searchInput.value.trim() === '') {
        event.preventDefault(); // Prevent form submission if the search term is empty
        alert('Please enter a search term.');
    }
});


