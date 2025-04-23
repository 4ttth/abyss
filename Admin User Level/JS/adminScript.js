document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelector(".introScreen").style.display = "none"; 
        document.querySelector(".pageContent").classList.add("showContent");
    }, 500); // Matches animation duration
});

// // Standardized loading screen removal
// function initializePage() {
//     try {
//         // Hide loading screen
//         document.querySelector(".introScreen").style.display = "none";
//         document.querySelector(".pageContent").classList.remove("hiddenContent");
        
//         // Initialize any global functionality here
//         console.log("Admin page initialized");
//     } catch (error) {
//         console.error("Initialization error:", error);
//         // Fallback: ensure content is visible even if scripts fail
//         document.querySelector(".introScreen").style.display = "none";
//         document.querySelector(".pageContent").classList.remove("hiddenContent");
//     }
// }

// // Wait for DOM and jQuery to be ready
// document.addEventListener("DOMContentLoaded", function() {
//     // Check if jQuery is loaded
//     if (window.jQuery) {
//         $(document).ready(initializePage);
//     } else {
//         // Fallback if jQuery fails to load
//         initializePage();
//     }
// });