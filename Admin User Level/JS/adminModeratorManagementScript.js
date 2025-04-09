document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelector(".introScreen").style.display = "none"; 
        document.querySelector(".pageContent").classList.add("showContent");
    }, 500); // Matches animation duration
});

// // $(document).ready(function () {
// //     $('#myTable').DataTable();
// // });

// // // Fetching
// // $(document).ready(function () {
// //     $('#reportsTable').DataTable();
// // });

// // function viewReport(id) {
// //     alert("Viewing report ID: " + id);
// // }

// // // Modal
// // function penalize(reportId) {
// //     // Set the report ID in the hidden field
// //     document.getElementById('penaltyReportId').value = reportId;
    
// //     // Show the modal
// //     var modal = new bootstrap.Modal(document.getElementById('penaltyModal'));
// //     modal.show();
// // }

// // function toggleDurationField() {
// //     const penaltyType = document.getElementById('penaltyType').value;
// //     const durationField = document.getElementById('durationField');
    
// //     if (penaltyType === 'timeout') {
// //         durationField.style.display = 'block';
// //     } else {
// //         durationField.style.display = 'none';
// //     }
// // }

// // Initialize DataTable and modals
// function initializeModeratorManagement() {
//     try {
//         $('#reportsTable').DataTable({
//             responsive: true,
//             columnDefs: [
//                 { responsivePriority: 1, targets: 0 }, // Report ID
//                 { responsivePriority: 2, targets: -1 } // Actions column
//             ]
//         });

//         // Initialize Bootstrap modal
//         window.penaltyModal = new bootstrap.Modal(document.getElementById('penaltyModal'));
        
//         console.log("Moderator management initialized");
//     } catch (error) {
//         console.error("Moderator management error:", error);
//     }
// }

// // Penalty functions
// function penalize(reportId) {
//     try {
//         document.getElementById('penaltyReportId').value = reportId;
//         window.penaltyModal.show();
//     } catch (error) {
//         console.error("Penalize error:", error);
//     }
// }

// function toggleDurationField() {
//     try {
//         const penaltyType = document.getElementById('penaltyType').value;
//         const durationField = document.getElementById('durationField');
//         durationField.style.display = penaltyType === 'timeout' ? 'block' : 'none';
//     } catch (error) {
//         console.error("Toggle duration error:", error);
//     }
// }

// // Add to existing event listener
// document.addEventListener("DOMContentLoaded", function() {
//     if (window.jQuery) {
//         $(document).ready(function() {
//             initializeModeratorManagement();
//         });
//     }
// });

// Initialize DataTable
$(document).ready(function() {
    $('#moderatorTable').DataTable();
});

function resetPassword(modId) {
    if (confirm('Are you sure you want to reset this moderator\'s password?')) {
        // AJAX call to reset password
        $.ajax({
            url: '../includes/reset_moderator_password.inc.php',
            method: 'POST',
            data: { mod_id: modId },
            success: function(response) {
                alert('Password reset successfully');
            },
            error: function() {
                alert('Error resetting password');
            }
        });
    }
}

function deleteAccount(modId) {
    if (confirm('Are you sure you want to delete this moderator account?')) {
        // AJAX call to delete account
        $.ajax({
            url: '../includes/delete_moderator.inc.php',
            method: 'POST',
            data: { mod_id: modId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload(); // Refresh page after deletion
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Error deleting account. Please try again.');
                console.error('Error:', xhr.responseText);
            }
        });
    }
}

// Initialize Logs Table
const logsTable = $('#logsTable').DataTable({
    searching: false,
    paging: false,
    info: false,
    destroy: true
});

// Click handler for Show Logs button
$(document).on('click', '.show-logs', function() {
    const modId = $(this).data('mod-id');
    const modEmail = $(this).data('mod-email');
    
    // Show loading state
    $('#logsTable tbody').html('<tr><td colspan="3">Loading logs...</td></tr>');
    $('#moderatorName').text(modEmail);
    $('#logsSection').show();
    
    // Fetch logs via AJAX
    $.ajax({
        url: '../includes/get_moderator_logs.php',
        method: 'POST',
        data: { moderator_id: modId },
        dataType: 'json',
        success: function(response) {
            logsTable.clear().draw();
            
            if (response.length === 0) {
                logsTable.row.add(['No logs found', '', '']).draw();
                return;
            }
            
            response.forEach(log => {
                logsTable.row.add([
                    log.Date,
                    log.Time,
                    log.Action
                ]).draw();
            });
        },
        error: function(xhr) {
            $('#logsTable tbody').html('<tr><td colspan="3">Error loading logs</td></tr>');
            console.error('Error loading logs:', xhr.responseText);
        }
    });
});

// For ANM alert
document.addEventListener("DOMContentLoaded", function () {
    const alertBox = document.getElementById("success-alert");
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.transition = "opacity 0.5s ease";
            alertBox.style.opacity = 0;
            setTimeout(() => alertBox.remove(), 500); // remove from DOM after fade out
        }, 3000); // Show for 3 seconds
    }
});