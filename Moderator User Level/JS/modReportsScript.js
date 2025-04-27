document.addEventListener("DOMContentLoaded", function () {
    // Page transition animation
    setTimeout(() => {
        document.querySelector(".introScreen").style.display = "none";
        document.querySelector(".pageContent").classList.add("showContent");
    }, 500);

    // Initialize DataTable
    $(document).ready(function () {
        $('#reportsTable').DataTable();
    });
});

// ================== PENALTY FUNCTIONS ================== //
function penalize(reportId) {
    document.getElementById('penaltyReportId').value = reportId;
    new bootstrap.Modal(document.getElementById('penaltyModal')).show();
}

function toggleDurationField() {
    const penaltyType = document.getElementById('penaltyType').value;
    document.getElementById('durationField').style.display = 
        penaltyType === 'timeout' ? 'block' : 'none';
}

// Handle penalty form submission
document.getElementById('penaltyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/includes/applyPenalty.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // First, get the raw response
    .then(data => {
        if (data.includes("success")) { // Check if PHP returned a success message
            location.reload();
        } else {
            alert("Error: " + data); // Show PHP error messages
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Network error');
    });
});

// ================== DELETE FUNCTION ================== //
function deleteReport(reportId) {
    if (confirm('Are you sure you want to permanently delete this report?')) {
        const data = new URLSearchParams();
        data.append('report_id', reportId);

        fetch('/includes/delete_report.inc.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: data
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting report');
        });
    }
}

// ================== VIEW REPORT ================== //
function viewReport(id) {
    alert("Viewing report ID: " + id);
}