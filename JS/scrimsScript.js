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

// Handle Accept/Decline
function respondToInvite(scheduleId, action) {
    // Disable buttons and show loading state
    const buttons = document.querySelectorAll(`.notification[data-invite-id="${scheduleId}"] .scrimButtons button`);
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
            // Update the UI dynamically
            const notification = document.querySelector(`.notification[data-invite-id="${scheduleId}"]`);
            
            // 1. Change buttons to show response status
            const buttonsContainer = notification.querySelector('.scrimButtons');
            buttonsContainer.innerHTML = `
                <button class="${action === 'Accepted' ? 'acceptedOnNotif' : 'declinedOnNotif'}" disabled>
                    ${action.toUpperCase()}
                </button>
            `;
            
            // 2. Remove 'new' class if it exists
            notification.classList.remove('new');
            
            // 3. Update the notification counter
            updateNotificationCount();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Reset buttons if failed
        buttons.forEach(btn => {
            btn.disabled = false;
            btn.innerHTML = btn.classList.contains('acceptOnNotif') ? 'ACCEPT' : 'DECLINE';
        });
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

// Call this periodically (e.g., every 30 seconds)
setInterval(updateNotificationCount, 30000);

document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterOptions = document.querySelectorAll('.filter-option');
    
    filterOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const status = this.dataset.status;
            filterScrims(status);
            
            // Update active filter style
            filterOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            // Update button text
            document.querySelector('#scrimFilterDropdown span').textContent = this.textContent;
        });
    });
});

function filterScrims(status) {
    const allCards = document.querySelectorAll('.scrim-card');
    
    allCards.forEach(card => {
        if (status === 'all') {
            card.style.display = 'block';
        } else {
            const matchesFilter = card.dataset.status === status.toLowerCase();
            card.style.display = matchesFilter ? 'block' : 'none';
        }
    });
}