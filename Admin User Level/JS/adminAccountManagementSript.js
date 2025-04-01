// document.addEventListener("DOMContentLoaded", function () {
//     setTimeout(() => {
//         document.querySelector(".introScreen").style.display = "none"; 
//         document.querySelector(".pageContent").classList.add("showContent");
//     }, 500); // Matches animation duration
// });

// $(document).ready(function () {
//     $('#myTable').DataTable();
// });

// // Fetching
// $(document).ready(function () {
//     $('#reportsTable').DataTable();
// });

// function viewReport(id) {
//     alert("Viewing report ID: " + id);
// }

// Initialize DataTable after page is ready
function initializeAccountManagement() {
    try {
        $('#reportsTable').DataTable({
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: 0 }, // Report ID
                { responsivePriority: 2, targets: -1 } // Actions column
            ]
        });
        
        console.log("Account management initialized");
    } catch (error) {
        console.error("Account management error:", error);
    }
}

// Add to existing event listener in adminScript.js
document.addEventListener("DOMContentLoaded", function() {
    if (window.jQuery) {
        $(document).ready(function() {
            initializeAccountManagement();
        });
    }
});