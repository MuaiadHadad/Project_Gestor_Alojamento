
function validateForm(event) {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('Re-password').value;
    var email = document.getElementById('Email').value;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var Repassword = document.getElementById('Re-password');
    var Email = document.getElementById('Email');
    Repassword.innerHTML = '';
    Email.innerHTML = '';
    var hasError = false;
    if (password !== confirmPassword) {
        appendErrorMessage('Passwords do not match', 'Re-password');
        event.preventDefault();
        hasError = true;
    }else {
        Repassword.innerHTML = '';
    }
    if (password.length < 8 || !/[A-Z]/.test(password)) {
        appendErrorMessage('Password must be at least 8 characters long and contain at least one uppercase letter', 'password');
        hasError = true;
    }
    if (!emailRegex.test(email)) {
        appendErrorMessage('Invalid email format', 'Email');
        event.preventDefault();
        hasError = true;
    }else {
        Email.innerHTML = '';
    }
    if (hasError) {
        event.preventDefault();
    }
}
function appendErrorMessage(message, fieldId) {
    var field = document.getElementById(fieldId);
    var errorMessage = document.createElement('span');
    errorMessage.textContent = message;
    errorMessage.classList.add('error-message');
    field.parentNode.appendChild(errorMessage);

    field.addEventListener('input', function() {
        errorMessage.remove();
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('registrationForm').addEventListener('submit', validateForm);
});
const toast = document.querySelector(".toast");
const closeIcon = document.querySelector(".close");

closeIcon.addEventListener("click", () => {
    toast.style.display = "none";
});

