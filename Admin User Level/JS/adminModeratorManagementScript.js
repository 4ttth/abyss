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

// // Modal
// function penalize(reportId) {
//     // Set the report ID in the hidden field
//     document.getElementById('penaltyReportId').value = reportId;
    
//     // Show the modal
//     var modal = new bootstrap.Modal(document.getElementById('penaltyModal'));
//     modal.show();
// }

// function toggleDurationField() {
//     const penaltyType = document.getElementById('penaltyType').value;
//     const durationField = document.getElementById('durationField');
    
//     if (penaltyType === 'timeout') {
//         durationField.style.display = 'block';
//     } else {
//         durationField.style.display = 'none';
//     }
// }

// Initialize DataTable and modals
function initializeModeratorManagement() {
    try {
        $('#reportsTable').DataTable({
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: 0 }, // Report ID
                { responsivePriority: 2, targets: -1 } // Actions column
            ]
        });

        // Initialize Bootstrap modal
        window.penaltyModal = new bootstrap.Modal(document.getElementById('penaltyModal'));
        
        console.log("Moderator management initialized");
    } catch (error) {
        console.error("Moderator management error:", error);
    }
}

// Penalty functions
function penalize(reportId) {
    try {
        document.getElementById('penaltyReportId').value = reportId;
        window.penaltyModal.show();
    } catch (error) {
        console.error("Penalize error:", error);
    }
}

function toggleDurationField() {
    try {
        const penaltyType = document.getElementById('penaltyType').value;
        const durationField = document.getElementById('durationField');
        durationField.style.display = penaltyType === 'timeout' ? 'block' : 'none';
    } catch (error) {
        console.error("Toggle duration error:", error);
    }
}

// Add to existing event listener
document.addEventListener("DOMContentLoaded", function() {
    if (window.jQuery) {
        $(document).ready(function() {
            initializeModeratorManagement();
        });
    }
});