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