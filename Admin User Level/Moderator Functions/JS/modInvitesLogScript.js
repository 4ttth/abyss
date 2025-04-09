document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelector(".introScreen").style.display = "none";
        document.querySelector(".pageContent").classList.add("showContent");
    }, 500); // Matches animation duration
});


$(document).ready(function () {
    $('#invitesTable').DataTable(); // Only changed this line from #reportsTable to #scrimsTable
});