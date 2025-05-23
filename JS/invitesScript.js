document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelector(".introScreen").style.display = "none";
        document.querySelector(".pageContent").classList.add("showContent");
    }, 500); // Matches animation duration
});


document.addEventListener('DOMContentLoaded', function() {
    const subtitleRight = document.querySelector('.subtitleRight');
    if (subtitleRight) {
        const now = new Date();
        const dd = String(now.getDate()).padStart(2, '0');
        const mm = String(now.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
        const yyyy = now.getFullYear();
        subtitleRight.innerText = `AS OF ${dd}${mm}${yyyy}`;
    }
});

// Notification modal handling
document.addEventListener('DOMContentLoaded', function() {
    // Update notification badge count
    function updateNotificationBadge() {
        fetch('includes/getUnreadNotifications.php')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.notification-badge');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'block';
                } else {
                    badge.style.display = 'none';
                }
            });
    }

    // Mark all as read
    document.querySelector('.markAllRead')?.addEventListener('click', function() {
        fetch('includes/markNotificationsRead.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(() => {
            updateNotificationBadge();
        });
    });

    // Initial load
    updateNotificationBadge();
});

document.addEventListener('DOMContentLoaded', function() {
    const filterOptions = document.querySelectorAll('.filter-option');
    const currentFilterDisplay = document.getElementById('currentFilter');
    
    filterOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const status = this.dataset.status;
            const filterText = this.textContent;
            
            // Update the button text
            currentFilterDisplay.textContent = filterText;
            
            // Update active state
            filterOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            // Filter the cards
            filterInvites(status);
        });
    });
});

function filterInvites(status) {
    const allCards = document.querySelectorAll('.scrim-card');
    
    allCards.forEach(card => {
        if (status === 'all') {
            card.style.display = 'block';
        } else {
            card.style.display = card.dataset.status === status ? 'block' : 'none';
        }
    });
}

// Handle Accept/Decline
// function respondToInvite(scheduleId, action) {
//     // Disable buttons and show loading state
//     const buttons = document.querySelectorAll(`.notification[data-invite-id="${scheduleId}"] .scrimButtons button`);
//     buttons.forEach(btn => {
//         btn.disabled = true;
//         btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i>';
//     });

//     fetch('includes/handleInviteResponse.php', {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/json' },
//         body: JSON.stringify({ 
//             schedule_id: scheduleId, 
//             action: action 
//         })
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             // Update the UI dynamically
//             const notification = document.querySelector(`.notification[data-invite-id="${scheduleId}"]`);
            
//             // 1. Change buttons to show response status
//             const buttonsContainer = notification.querySelector('.scrimButtons');
//             buttonsContainer.innerHTML = `
//                 <button class="${action === 'Accepted' ? 'acceptedOnNotif' : 'declinedOnNotif'}" disabled>
//                     ${action.toUpperCase()}
//                 </button>
//             `;
            
//             // 2. Remove 'new' class if it exists
//             notification.classList.remove('new');
            
//             // 3. Update the notification counter
//             updateNotificationCount();
//         }
//     })
//     .catch(error => {
//         console.error('Error:', error);
//         // Reset buttons if failed
//         buttons.forEach(btn => {
//             btn.disabled = false;
//             btn.innerHTML = btn.classList.contains('acceptOnNotif') ? 'ACCEPT' : 'DECLINE';
//         });
//     });
// }

function respondToInvite(scheduleId, action) {
    const buttons = document.querySelectorAll(`.notification[data-invite-id="${scheduleId}"] .scrimButtons button`);
    
    // Show loading state
    buttons.forEach(btn => {
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i>';
    });

    fetch('includes/handleInviteResponse.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            schedule_id: scheduleId, 
            action: action 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notification = document.querySelector(`.notification[data-invite-id="${scheduleId}"]`);
            const buttonsContainer = notification.querySelector('.scrimButtons');

            // Update buttons to show final response
            buttonsContainer.innerHTML = `
                <button class="${action === 'Accepted' ? 'acceptedOnNotif' : 'declinedOnNotif'}" disabled>
                    ${action.toUpperCase()}
                </button>
            `;

            // Remove 'new' status
            notification.classList.remove('new');

            // Update notification count
            updateNotificationCount();
        } else {
            throw new Error(data.message || 'Action failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        buttons.forEach(btn => {
            btn.disabled = false;
            btn.innerHTML = btn.classList.contains('acceptOnNotif') ? 'ACCEPT' : 'DECLINE';
        });
        alert(error.message);
    });
}

function fetchNotificationModal() {
    fetch('includes/getNotifications.php')
        .then(response => response.text())
        .then(html => {
            document.querySelector('.modal-body').innerHTML = html;
        });
}

// Update the counter
function updateNotificationCount() {
    fetch('includes/getNotificationCount.php')
        .then(response => response.json())
        .then(data => {
            const counter = document.querySelector('.notifCount');
            if (data.count > 0) {
                if (!counter) {
                    const badge = document.createElement('span');
                    badge.className = 'notifCount';
                    document.querySelector('.nav-linkIcon').appendChild(badge);
                }
                document.querySelector('.notifCount').textContent = data.count;
            } else if (counter) {
                counter.remove();
            }
        });
}

// // Call this periodically (e.g., every 30 seconds)
// setInterval(updateNotificationCount, 30000);

// File name display script
document.getElementById('fileInput').addEventListener('change', function() {
    document.getElementById('fileName').textContent = this.files[0] ? this.files[0].name : 'No file chosen';
});

// SLEDGEHAMMER

// Function to check for new messages periodically
function checkNewMessages() {
    fetch('includes/getUnreadCount.inc.php')
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('.nav-linkIcon[href="inboxPage.php"] .notifCount');
            if (data.count > 0) {
                if (!badge) {
                    const newBadge = document.createElement('span');
                    newBadge.className = 'notifCount';
                    newBadge.textContent = data.count;
                    document.querySelector('.nav-linkIcon[href="inboxPage.php"]').appendChild(newBadge);
                } else {
                    badge.textContent = data.count;
                }
            } else if (badge) {
                badge.remove();
            }
        });
}

// Check every 30 seconds
setInterval(checkNewMessages, 30000);

// Initial check when page loads
document.addEventListener('DOMContentLoaded', checkNewMessages);

// SLEDGEHAMMER

// Function to check for new messages periodically
function checkNewMessages() {
    fetch('includes/getUnreadCount.inc.php')
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('.nav-linkIcon[href="inboxPage.php"] .notifCount');
            if (data.count > 0) {
                if (!badge) {
                    const newBadge = document.createElement('span');
                    newBadge.className = 'notifCount';
                    newBadge.textContent = data.count;
                    document.querySelector('.nav-linkIcon[href="inboxPage.php"]').appendChild(newBadge);
                } else {
                    badge.textContent = data.count;
                }
            } else if (badge) {
                badge.remove();
            }
        });
}

// Check every 30 seconds
setInterval(checkNewMessages, 30000);

// Initial check when page loads
document.addEventListener('DOMContentLoaded', checkNewMessages);