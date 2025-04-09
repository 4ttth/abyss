document.addEventListener("DOMContentLoaded", function () {
    // Initially hide the content
    document.querySelector(".pageContent").classList.add("hiddenContent");
    
    // Initialize DataTable after 500ms delay (matches loading animation)
    setTimeout(() => {
        initializeDataTable().then(() => {
            // When DataTable is ready, show content
            document.querySelector(".introScreen").style.display = "none";
            document.querySelector(".pageContent").classList.remove("hiddenContent");
            document.querySelector(".pageContent").classList.add("showContent");
        });
    }, 500);
});

async function initializeDataTable() {
    $('#reportsTable').DataTable({
        "ajax": {
            "url": window.location.href,
            "dataSrc": "",
            "error": function(xhr) {
                console.error('DataTables error:', xhr);
                document.querySelector(".introScreen").style.display = "none";
                alert('Error loading data. Please refresh the page.');
            }
        },
        "columns": [
            { "data": "Squad_ID" },
            { "data": "Squad_Name" },
            { "data": "Squad_Level" },
            { "data": "Proof_Type" },
            { 
                "data": "Proof_File",
                "render": function(data) {
                    // Escape special characters in file path
                    const safeData = data ? data.replace(/'/g, "\\'") : '';
                    return data ? 
                        `<button class="buttons view" onclick="window.open('${safeData}', '_blank')">View File</button>` : 
                        'No File';
                }
            },
            { "data": "Date_Submitted" },
            { "data": "Status" },
            { 
                "data": "Date_Reviewed",
                "render": function(data) {
                    return data || 'Pending';
                }
            },
            { 
                "data": null,
                "render": function(data, type, row) {
                    return `
                        <button class="approve" onclick="handleRequest(${row.Request_ID}, 'approve')">Approve</button>
                        <button class="reject" onclick="handleRequest(${row.Request_ID}, 'reject')">Reject</button>
                    `;
                },
                "orderable": false
            }
        ],
        "initComplete": function() {
            // Add any post-initialization logic here
            console.log('DataTable initialized');
        }
    });
}

// Handle approval/rejection requests with fixed alert
function handleRequest(requestId, action) {
    if (confirm(`Are you sure you want to ${action} this request?`)) {
       

        $.ajax({
            url: 'updateRequest.php',
            method: 'POST',
            data: { 
                request_id: requestId, 
                action: action 
            },
            dataType: 'json',
            success: (response) => {
        
                if (response && response.success) {
                    alert(`Action Successful!`);
                    location.reload(); // Force fresh reload
                } else {
                    const errorMsg = response?.error || 'Action failed without explanation';
                    alert(`Error: ${errorMsg}`);
                }
            },
            error: (xhr) => {
                document.querySelector(".introScreen").style.display = "none";
                document.querySelector(".pageContent").classList.remove("hiddenContent");
                alert('Network error. Check console.');
                console.error('AJAX Error:', xhr.status, xhr.responseText);
            }
        });
    }
}