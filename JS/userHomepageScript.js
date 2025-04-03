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
    
    alert(`Scrim access requires:
- Approved verification status
OR
- Amateur squad level

Current status:
${reason.join('\n')}`);
}
