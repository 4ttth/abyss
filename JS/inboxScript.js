// Initial page load animation
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelector(".introScreen").style.display = "none"; 
        document.querySelector(".pageContent").classList.add("showContent");
    }, 0);

    // Initialize inbox functionality
    initializeInbox();
    
    // Initialize notification functionality
    initializeNotifications();
    
    // Initialize other functionality
    initializeOtherFeatures();
});

function initializeInbox() {
    // Scroll to bottom initially
    scrollToBottom();
    
    // Setup conversation card click handlers
    setupConversationHandlers();
    
    // Setup message form submission
    setupMessageForm();
    
    // Setup periodic checks for new messages
    setupMessagePolling();
    
    // Setup mutation observer for dynamic content
    setupMutationObserver();
}

function initializeNotifications() {
    // Update notification badge count
    updateNotificationBadge();
    
    // Mark all as read handler
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
    
    // File name display script
    document.getElementById('fileInput')?.addEventListener('change', function() {
        document.getElementById('fileName').textContent = this.files[0] ? this.files[0].name : 'No file chosen';
    });
}

function initializeOtherFeatures() {
    // Score validation
    document.querySelector('form')?.addEventListener('submit', function(e) {
        validateScores();
        if (document.querySelector('button[type="submit"]').disabled) {
            e.preventDefault();
        }
    });
    
    // Form submission handling
    const verifyButton = document.getElementById('verifyButton');
    const form = document.querySelector('form');
    
    form?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const yourScore = parseInt(document.getElementById('yourScore').value);
        const opponentScore = parseInt(document.getElementById('opponentScore').value);
        const maxScore = parseInt(document.getElementById('maxScore').value);
        const fileInput = document.getElementById('fileInput');
        
        if (isNaN(yourScore) || isNaN(opponentScore)) {
            alert('Please enter valid scores for both teams');
            return;
        }
        
        if (yourScore > maxScore || opponentScore > maxScore) {
            alert(`Scores cannot exceed ${maxScore} for this best-of-${maxScore*2-1} match`);
            return;
        }
        
        if (yourScore === opponentScore) {
            alert('Scores cannot be equal - there must be a winner');
            return;
        }
        
        if (fileInput && !fileInput.files.length) {
            alert('Please upload proof file');
            return;
        }
        
        form.submit();
    });
    
    // Disable button during submission to prevent double-clicking
    form?.addEventListener('submit', function() {
        if (verifyButton) {
            verifyButton.disabled = true;
            verifyButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
        }
    });
    
    // Date display
    const subtitleRight = document.querySelector('.subtitleRight');
    if (subtitleRight) {
        const now = new Date();
        const dd = String(now.getDate()).padStart(2, '0');
        const mm = String(now.getMonth() + 1).padStart(2, '0');
        const yyyy = now.getFullYear();
        subtitleRight.innerText = `AS OF ${dd}${mm}${yyyy}`;
    }
    
    // Modal scrolling behavior
    let authModal = document.getElementById("authModal");
    if (authModal) {
        authModal.addEventListener("shown.bs.modal", function () {
            document.body.style.overflow = "hidden";
        });

        authModal.addEventListener("hidden.bs.modal", function () {
            document.body.style.overflow = "";
        });
    }
    
    // Label modal functions
    window.openLabelModal = function() {
        document.getElementById("labelModal").style.display = "block";
    };
    
    window.closeLabelModal = function() {
        document.getElementById("labelModal").style.display = "none";
    };
    
    window.saveCustomLabel = function() {
        let label = document.getElementById("customLabelInput").value;

        if (label.trim() !== "") {
            let labelElement = document.createElement("div");
            labelElement.classList.add("labelTag");
            labelElement.textContent = label;
            document.querySelector(".selectedLabels").appendChild(labelElement);
        }

        closeLabelModal();
    };
    
    window.addLabel = function(labelText) {
        const labelContainer = document.getElementById("labelContainer");
        const label = document.createElement("div");
        label.classList.add("addedLabel");
        label.innerText = labelText;

        label.addEventListener("click", function () {
            label.remove();
        });

        labelContainer.appendChild(label);
    };
    
    // Post functionality
    const postButton = document.getElementById("postButton");
    if (postButton) {
        postButton.addEventListener("click", function() {
            postStatus();
        });
    }
    
    // Scrim error function
    window.showScrimError = function() {
        const reason = [];
        
        if (verificationStatus !== 'Approved') {
            reason.push(`Verification Status: ${verificationStatus}`);
        }
        
        if (squadLevel.toUpperCase() !== 'AMATEUR') {
            reason.push(`Squad Level: ${squadLevel}`);
        }
        
        alert(`Scrim access requires:
- Approved verification status
OR
- Amateur squad level

Current status:
${reason.join('\n')}`);
    };
}

// Scroll to bottom of messages
function scrollToBottom() {
    const messagesContainer = document.getElementById('messagesContainer');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
}

// Handle conversation card clicks
function setupConversationHandlers() {
    document.addEventListener('click', function(e) {
        if (e.target.closest('.conversationCard')) {
            const card = e.target.closest('.conversationCard');
            const conversationId = card.dataset.conversationId;
            
            document.querySelectorAll('.conversationCard').forEach(c => {
                c.classList.remove('active-conversation');
            });
            card.classList.add('active-conversation');
            
            const unreadCount = card.querySelector('.unreadCount');
            if (unreadCount) unreadCount.remove();
            card.classList.remove('newMessage');
            
            loadMessages(conversationId);
        }
    });
}

// AJAX function to load messages
function loadMessages(conversationId) {
    fetch(`inboxPage.php?ajax=get_messages&conversation_id=${conversationId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                updateMessagesArea(data, conversationId);
                updateURL(conversationId);
            }
        })
        .catch(error => console.error('Error loading messages:', error));
}

function updateMessagesArea(data, conversationId) {
    let messagesHtml = `
        <div class="conversation-header">
            <strong>${data.otherSquadName}</strong>
        </div>
        <div class="messagesPart" id="messagesContainer">`;
    
    if (data.messages.length > 0) {
        data.messages.forEach(message => {
            const messageClass = message.Sender_Squad_ID == currentSquadId ? 'outgoing' : 'incoming';
            const senderHtml = message.Sender_Squad_ID != currentSquadId ? 
                `<a href="squadDetailsPage.php?id=${message.Sender_Squad_ID}" class="squadNameSender">
                    ${message.Sender_Name}
                </a>` : '';
            
            messagesHtml += `
                <div class="message ${messageClass}" data-message-id="${message.Message_ID}">
                    ${senderHtml}
                    <div class="bubble">${message.Content.replace(/\n/g, '<br>')}</div>
                    <div class="message-time">${new Date(message.Created_At).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                </div>`;
        });
    } else {
        messagesHtml += `<div class="no-messages">Start the conversation!</div>`;
    }
    
    messagesHtml += `</div>
        <div class="textArea">
            <form id="messageForm" data-conversation-id="${conversationId}">
                <div class="input-group">
                    <textarea class="form-control" name="message" placeholder="Type your message here..." rows="1" required></textarea>
                    <button type="submit" class="btn send-btn"><i class="bi bi-send-fill"></i></button>
                </div>
            </form>
        </div>`;
    
    document.getElementById('messagesArea').innerHTML = messagesHtml;
    scrollToBottom();
    
    setupMessageForm();
}

// Update URL without reload
function updateURL(conversationId) {
    history.pushState(null, null, `inboxPage.php?conversation_id=${conversationId}`);
}

// Handle message form submission
function setupMessageForm() {
    const form = document.getElementById('messageForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const conversationId = this.dataset.conversationId;
            const messageInput = this.querySelector('textarea[name="message"]');
            const messageContent = messageInput.value.trim();
            
            if (messageContent) {
                sendMessage(conversationId, messageContent);
                messageInput.value = '';
                messageInput.style.height = 'auto';
            }
        });
        
        const textarea = form.querySelector('textarea');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
}

// AJAX function to send message
function sendMessage(conversationId, messageContent) {
    const formData = new FormData();
    formData.append('ajax', 'send_message');
    formData.append('conversation_id', conversationId);
    formData.append('message', messageContent);

    fetch('inboxPage.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            appendNewMessage(data.message);
            updateConversationList(conversationId, data.message.Content);
        }
    })
    .catch(error => console.error('Error sending message:', error));
}

// Append new message to container
function appendNewMessage(message) {
    const container = document.getElementById('messagesContainer');
    if (!container) return;

    const messageClass = message.Sender_Squad_ID == currentSquadId ? 'outgoing' : 'incoming';
    const senderHtml = message.Sender_Squad_ID != currentSquadId ? 
        `<a href="squadDetailsPage.php?id=${message.Sender_Squad_ID}" class="squadNameSender">
            ${message.Sender_Name}
        </a>` : '';
    
    const messageHtml = `
        <div class="message ${messageClass}" data-message-id="${message.Message_ID}">
            ${senderHtml}
            <div class="bubble">${message.Content.replace(/\n/g, '<br>')}</div>
            <div class="message-time">${new Date(message.Created_At).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
        </div>`;
    
    container.insertAdjacentHTML('beforeend', messageHtml);
    scrollToBottom();
}

// Update conversation list after sending message
function updateConversationList(conversationId, lastMessage) {
    const conversationCard = document.querySelector(`.conversationCard[data-conversation-id="${conversationId}"]`);
    if (!conversationCard) return;

    const lastMessageDiv = conversationCard.querySelector('.lastMessage');
    if (lastMessageDiv) {
        const truncated = lastMessage.length > 30 ? lastMessage.substring(0, 30) + '...' : lastMessage;
        lastMessageDiv.textContent = truncated;
    }

    const conversationsList = document.getElementById('conversationsList');
    if (conversationsList) {
        conversationsList.prepend(conversationCard);
    }

    document.querySelectorAll('.conversationCard').forEach(card => {
        card.classList.remove('active-conversation');
    });
    conversationCard.classList.add('active-conversation');
}

// Check for new messages periodically
function setupMessagePolling() {
    if (typeof selectedConversation !== 'undefined' && selectedConversation) {
        setInterval(checkNewMessages, 3000);
    }
    
    setInterval(checkUnreadCounts, 30000);
}

function checkNewMessages() {
    const conversationId = document.querySelector('.conversationCard.active-conversation')?.dataset.conversationId;
    if (!conversationId) return;

    const lastMessage = document.querySelector('#messagesContainer .message:last-child');
    const lastMessageId = lastMessage ? lastMessage.dataset.messageId : 0;

    fetch(`includes/checkMessages.php?conversation_id=${conversationId}&last_id=${lastMessageId}`)
        .then(response => response.json())
        .then(data => {
            if (data.newMessages && data.newMessages.length > 0) {
                data.newMessages.forEach(message => {
                    appendNewMessage(message);
                });
            }
        });
}

function checkUnreadCounts() {
    fetch('includes/getUnreadCount.inc.php')
        .then(response => response.json())
        .then(data => {
            updateUnreadBadge(data.count);
        });
}

function updateUnreadBadge(count) {
    const inboxLink = document.querySelector('.nav-linkIcon[href="inboxPage.php"]');
    if (!inboxLink) return;

    let badge = inboxLink.querySelector('.notifCount');
    
    if (count > 0) {
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'notifCount';
            inboxLink.appendChild(badge);
        }
        badge.textContent = count;
    } else if (badge) {
        badge.remove();
    }
}

// Mutation observer for dynamic content
function setupMutationObserver() {
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                scrollToBottom();
            }
        });
    });

    const messagesContainer = document.getElementById('messagesContainer');
    if (messagesContainer) {
        observer.observe(messagesContainer, {
            childList: true,
            subtree: true
        });
    }
}

// Notification handling functions
function respondToInvite(scheduleId, action) {
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
            const notification = document.querySelector(`.notification[data-invite-id="${scheduleId}"]`);
            const buttonsContainer = notification.querySelector('.scrimButtons');

            buttonsContainer.innerHTML = `
                <button class="${action === 'Accepted' ? 'acceptedOnNotif' : 'declinedOnNotif'}" disabled>
                    ${action.toUpperCase()}
                </button>
            `;

            notification.classList.remove('new');
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

function fetchNotificationModal() {
    fetch('includes/getNotifications.php')
        .then(response => response.text())
        .then(html => {
            document.querySelector('.modal-body').innerHTML = html;
        });
}

// Post status functionality
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

// Score validation
function validateScores() {
    const yourScore = parseInt(document.getElementById('yourScore').value) || 0;
    const opponentScore = parseInt(document.getElementById('opponentScore').value) || 0;
    const numberOfGames = parseInt(document.getElementById('numberOfGames').value);
    const maxScore = parseInt(document.getElementById('maxScore').value);
    const errorElement = document.getElementById('scoreError');
    const submitButton = document.querySelector('button[type="submit"]');
    
    errorElement.style.display = 'none';
    submitButton.disabled = false;
    
    if (yourScore > maxScore || opponentScore > maxScore) {
        errorElement.textContent = `In a best of ${numberOfGames} series, no team can win more than ${maxScore} games!`;
        errorElement.style.display = 'block';
        submitButton.disabled = true;
        return;
    }
    
    if ((yourScore + opponentScore) > numberOfGames) {
        errorElement.textContent = `The total games played (${yourScore + opponentScore}) cannot exceed the series length (best of ${numberOfGames})!`;
        errorElement.style.display = 'block';
        submitButton.disabled = true;
        return;
    }
    
    const hasWinner = (yourScore === maxScore) || (opponentScore === maxScore);
    
    if (!hasWinner) {
        errorElement.textContent = `One team must have ${maxScore} wins to complete the series!`;
        errorElement.style.display = 'block';
        submitButton.disabled = true;
        return;
    }
    
    if (yourScore === maxScore && opponentScore === maxScore) {
        errorElement.textContent = 'Both teams cannot have the winning score!';
        errorElement.style.display = 'block';
        submitButton.disabled = true;
        return;
    }
    
    if (yourScore < 0 || opponentScore < 0) {
        errorElement.textContent = 'Scores cannot be negative!';
        errorElement.style.display = 'block';
        submitButton.disabled = true;
        return;
    }
    
    if ((yourScore + opponentScore) < maxScore) {
        errorElement.textContent = `The series should have at least ${maxScore} games played to have a winner!`;
        errorElement.style.display = 'block';
        submitButton.disabled = true;
        return;
    }
}