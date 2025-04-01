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

// Modal
function penalize(reportId) {
    // Set the report ID in the hidden field
    document.getElementById('penaltyReportId').value = reportId;
    
    // Show the modal
    var modal = new bootstrap.Modal(document.getElementById('penaltyModal'));
    modal.show();
}

function toggleDurationField() {
    const penaltyType = document.getElementById('penaltyType').value;
    const durationField = document.getElementById('durationField');
    
    if (penaltyType === 'timeout') {
        durationField.style.display = 'block';
    } else {
        durationField.style.display = 'none';
    }
}