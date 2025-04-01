document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelector(".introScreen").style.display = "none"; 
        document.querySelector(".pageContent").classList.add("showContent");
    }, 500); // Matches animation duration
});

$(document).ready(function () {
    $('#myTable').DataTable();
});

// Fetching
$(document).ready(function () {
    $('#reportsTable').DataTable();
});

function viewReport(id) {
    alert("Viewing report ID: " + id);
}