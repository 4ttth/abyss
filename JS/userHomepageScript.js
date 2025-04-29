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

document.addEventListener("DOMContentLoaded", function () {
    let authModal = document.getElementById("authModal");

    authModal.addEventListener("shown.bs.modal", function () {
        document.body.style.overflow = "hidden"; // Prevent scrolling
    });

    authModal.addEventListener("hidden.bs.modal", function () {
        document.body.style.overflow = ""; // Restore scrolling
    });
});

function openLabelModal() {
    document.getElementById("labelModal").style.display = "block";
}

function closeLabelModal() {
    document.getElementById("labelModal").style.display = "none";
}

function saveCustomLabel() {
    let label = document.getElementById("customLabelInput").value;

    if (label.trim() !== "") {
        let labelElement = document.createElement("div");
        labelElement.classList.add("labelTag");
        labelElement.textContent = label;
        document.querySelector(".selectedLabels").appendChild(labelElement);
    }

    closeLabelModal();
}

function addLabel(labelText) {
    const labelContainer = document.getElementById("labelContainer"); // Ensure this div exists
    const label = document.createElement("div");
    label.classList.add("addedLabel");
    label.innerText = labelText;

    // Add event listener to remove label on click
    label.addEventListener("click", function () {
        label.remove();
    });

    labelContainer.appendChild(label);
}

document.addEventListener("click", function (event) {
    if (event.target.classList.contains("addedLabel")) {
        event.target.remove();
    }
});

// TESTESTESTEST
document.addEventListener("DOMContentLoaded", function() {
    const postButton = document.getElementById("postButton");

    if (!postButton) {
        console.error("Post button not found!");
    } else {
        postButton.addEventListener("click", function() {
            console.log("Post button clicked!"); // Should appear in Console
        });
    }
});

// POSTS
document.addEventListener("DOMContentLoaded", function () {
    loadPosts();
    
    document.getElementById("postButton").addEventListener("click", function () {
        postStatus();
    });
});

function postStatus() {
    let content = document.getElementById("contentInput").value;
    let postLabel = document.getElementById("postLabelInput").value;
    let postType = document.getElementById("postTypeSelect").value;
    let image = document.getElementById("imageUpload").files[0];

    let formData = new FormData();
    formData.append("content", content);
    formData.append("post_label", postLabel);
    formData.append("post_type", postType);
    formData.append("image", image);

    fetch("includes/post_status.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("Post Created!");
            document.getElementById("contentInput").value = "";
            document.getElementById("postLabelInput").value = "";
            document.getElementById("imageUpload").value = "";
            loadPosts();
        } else {

            alert("Failed to post!");
        }
    });
}

function loadPosts() {
    fetch("fetch_posts.php")
    .then(response => response.json())
    .then(posts => {
        let postFeed = document.getElementById("postFeed");
        postFeed.innerHTML = "";
        posts.forEach(post => {
            let postHTML = `
                <div class="post">
                    <div class="date">${new Date(post.Timestamp).toLocaleDateString()}</div>
                    ${post.Image_URL ? `<div class="attachedIMG"><img src="${post.Image_URL}" alt="Post Image"></div>` : ""}
                    <div class="caption">${post.Content}</div>
                    <div class="postedLabels">${post.Post_Label ? `<div class="labelTag">${post.Post_Label}</div>` : ''}</div>
                </div>
            `;
            postFeed.innerHTML += postHTML;
        });
    });
}

// NEW ADDITION

function showScrimError() {
    const reason = [];
    
    // Check verification status
    if (verificationStatus !== 'Approved') {
        reason.push(`Verification Status: ${verificationStatus}`);
    }
    
    // Check squad level (case-insensitive)
    if (squadLevel.toUpperCase() !== 'AMATEUR') {
        reason.push(`Squad Level: ${squadLevel}`);
    }
    
    alert(`Scrim acceass requires:
- Approved verification status
OR
- Amateur squad level

Current status:
${reason.join('\n')}`);
}

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