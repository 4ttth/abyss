document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelector(".introScreen").style.display = "none";
        document.querySelector(".pageContent").classList.add("showContent");
    }, 500);
});


// AJAX
$(document).ready(function() {
    // Initialize Squad Table
    const squadTable = $('#squadTable').DataTable();
   
    // Initialize Members Table (hidden)
    const membersTable = $('#membersTable').DataTable({
        searching: false,
        paging: false,
        info: false,
        destroy: true
    });
   
    // Click handler for Show Members button
    $('#squadTable').on('click', '.show-members', function() {
        const squadRow = $(this).closest('tr'); // Store reference to the row
        const squadId = squadRow.data('squad-id');
        const squadName = squadRow.find('td:eq(1)').text(); // Get squad name from 2nd column
        const $membersBody = $('#membersTable tbody');
       
        // Show loading state and set squad name immediately
        $membersBody.html('<tr><td colspan="7">Loading members...</td></tr>');
        $('#membersSection .titleLeft').text(`PLAYERS: ${squadName}`);
        $('#membersSection').show();
       
        // Fetch members via AJAX
        $.ajax({
            url: '/includes/get_members.php',
            method: 'POST',
            data: { squad_id: squadId },
            dataType: 'json',
            success: function(response) {
                // Check if response is valid
                if (!response || typeof response !== 'object') {
                    throw new Error('Invalid server response');
                }
               
                if (!response.success) {
                    throw new Error(response.error || 'Request failed');
                }


                membersTable.clear().draw();
               
                if (!response.data || response.data.length === 0) {
                    membersTable.row.add(['No members found', '', '', '', '', '', '']).draw();
                    return;
                }
               
                response.data.forEach(player => {
                    membersTable.row.add([
                        player.IGN || '-',
                        player.Current_Rank || '-',
                        player.Current_Star || '-',
                        player.Highest_Rank || '-',
                        player.Highest_Star || '-',
                        player.Role || '-',
                        [player.Hero_1, player.Hero_2, player.Hero_3].filter(Boolean).join(', ') || '-'
                    ]).draw();
                });
            },
            error: function(xhr, status, error) {
                let errorMsg = 'Error loading members';
                let responseText = xhr.responseText;
               
                // Try to extract error message from HTML response
                if (responseText.startsWith('<')) {
                    const tempDiv = $('<div>').html(responseText);
                    const preContent = tempDiv.find('pre').text();
                    if (preContent) {
                        responseText = preContent;
                    }
                }
               
                // Try to parse as JSON
                try {
                    const jsonResponse = JSON.parse(responseText);
                    errorMsg = jsonResponse.error || errorMsg;
                } catch (e) {
                    errorMsg += `: ${responseText || error}`;
                }
               
                $membersBody.html(`<tr><td colspan="7">${errorMsg}</td></tr>`);
               
                console.error('AJAX Error Details:', {
                    Status: xhr.status,
                    Error: error,
                    Response: responseText,
                    Request: { squad_id: squadId }
                });
            }
        });
    });
});

// TRY TRY TRY
$(document).ready(function () {
    $('#submitPenalty').on('click', function (e) {
        e.preventDefault();

        const formData = $('#penaltyForm').serialize();

        $.ajax({
            url: '/includes/applyPenalty.php',
            type: 'POST',
            dataType: 'json', // Expect JSON response
            data: formData,
            success: function (response) {
                if (response.status === 'success') {
                    alert(response.message);
                    $('#penaltyModal').modal('hide');
                    location.reload();
                } else {
                    alert('Error: ' + (response.message || 'Unknown error'));
                }
            },
            error: function (xhr) {
                try {
                    const errorResponse = JSON.parse(xhr.responseText);
                    alert('Error: ' + (errorResponse.message || 'Unknown error'));
                } catch {
                    alert('Server returned invalid response');
                }
            }
        });
    });
});


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

function setPenaltyId(squadId) {
    document.getElementById('penaltyReportId').value = squadId;
}