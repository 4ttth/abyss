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
    const togglePassword = document.getElementById("togglePassword");
    const passwordField = document.getElementById("password");
    const icon = togglePassword.querySelector("i");

    togglePassword.addEventListener("click", function () {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.getElementById("toggleConfirmPassword");
    const passwordField = document.getElementById("confirmPassword");
    const icon = togglePassword.querySelector("i");

    togglePassword.addEventListener("click", function () {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const usernameInput = document.querySelector("#username");
    const passwordInput = document.querySelector("#password");
    const loginButton = document.querySelector("#loginButton");

    function toggleButton() {
        if (usernameInput.value.trim() !== "" && passwordInput.value.trim() !== "") {
            loginButton.classList.add("enabled");
            loginButton.removeAttribute("disabled");
        } else {
            loginButton.classList.remove("enabled");
            loginButton.setAttribute("disabled", "true");
        }
    }

    usernameInput.addEventListener("input", toggleButton);
    passwordInput.addEventListener("input", toggleButton);
});




