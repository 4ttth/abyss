document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelector(".introScreen").style.display = "none"; 
        document.querySelector(".pageContent").classList.add("showContent");
    }, 500); // Matches animation duration
});

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

// // Modal - Show Add Content Modal
// function showAddContentModal() {
//     var modal = new bootstrap.Modal(document.getElementById('addContentModal'));
//     modal.show();
// }

// Initialize DataTable and modals
function initializeContentManagement() {
    try {
        $('#reportsTable').DataTable({
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: 0 }, // Content ID
                { responsivePriority: 2, targets: -1 } // Actions column
            ]
        });

        // Initialize Bootstrap modals
        window.contentModal = new bootstrap.Modal(document.getElementById('addContentModal'));
        
        console.log("Content management initialized");
    } catch (error) {
        console.error("Content management error:", error);
    }
}

// Modal functions
function showAddContentModal() {
    try {
        window.contentModal.show();
    } catch (error) {
        console.error("Failed to show modal:", error);
    }
}

// Display toggle
function toggleDisplay(contentId, currentDisplay) {
    const newDisplay = currentDisplay === 1 ? 0 : 1;

    $.ajax({
        url: 'includes/updateDisplay.inc.php',
        method: 'POST',
        data: {
            content_id: contentId,
            is_displayed: newDisplay
        },
        dataType: 'json', // Ensure proper JSON parsing
        success: function(response) {
            if (response.success) {
                location.reload(); // Refresh to update UI
            } else {
                alert('Error: ' + (response.error || 'Unknown error'));
            }
        },
        error: function(xhr) {
            alert('Server Error: ' + xhr.status + ' ' + xhr.statusText);
        }
    });
}

// Add to existing event listener
document.addEventListener("DOMContentLoaded", function() {
    if (window.jQuery) {
        $(document).ready(function() {
            initializeContentManagement();
        });
    }
});