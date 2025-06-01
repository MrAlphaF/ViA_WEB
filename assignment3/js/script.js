// Paste current year in footer
document.getElementById("footerYear").textContent = new Date().getFullYear();

function footerMouseover(x) {
    x.style.backgroundColor = "beige";
}

function footerMouseleave(x) {
    x.style.backgroundColor = "white";
}

function changeNavbarClasslist(x) {
    x.classList.add("myClass");
}

// DARK MODE
let darkModeOn = localStorage.getItem("darkModeOn");

if (darkModeOn == "active") {
    document.body.classList.add("darkMode");
} else {
    document.body.classList.remove("darkMode");
}

function toggleDarkMode() {
    document.body.classList.toggle("darkMode");
    if (document.body.classList.contains("darkMode") == true) {
        localStorage.setItem("darkModeOn", "active");
    }
    else {
        localStorage.setItem("darkModeOn", "inactive");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    initHeroSection(); // Call the function for hero section effects
    setupContactFormValidation(); // Call the function for contact form validation
});

// Hero Section Enhancements
function initHeroSection() {
    const heroSection = document.querySelector(".hero-section");
    const heroTitle = document.querySelector(".hero-section h1");
    const heroButton = document.querySelector(".hero-section .btn");

    if (!heroSection || !heroTitle || !heroButton) return; // Ensure elements exist

    // Fade-in effect
    heroSection.style.opacity = "0";
    heroSection.style.transition = "opacity 1.5s ease-in-out";
    setTimeout(() => {
        heroSection.style.opacity = "1";
    }, 500);

    // Dynamic text change after 3 seconds
    setTimeout(() => {
        heroTitle.textContent = "Expert PC & Laptop Repair Services!";
    }, 3000);

    // Button animation on hover
    heroButton.addEventListener("mouseover", function () {
        heroButton.style.transform = "scale(1.1)";
        heroButton.style.transition = "transform 0.3s ease";
    });

    heroButton.addEventListener("mouseleave", function () {
        heroButton.style.transform = "scale(1)";
    });
}

// Contact Form Validation
function setupContactFormValidation() {
    const contactForm = document.getElementById("contactForm");
    if (!contactForm) return;

    contactForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const message = document.getElementById("message").value.trim();

        const errors = [];

        // Empty field validation
        if (!name) errors.push("Name is required.");
        if (!email) errors.push("Email is required.");
        if (!message) errors.push("Message is required.");

        // Email format validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email && !emailRegex.test(email)) errors.push("Invalid email format.");

        // Minimum message length validation
        if (message && message.length < 10) errors.push("Message must be at least 10 characters.");

        // Display errors or success
        if (errors.length > 0) {
            displayErrors(errors);
        } else {
            // Form is valid
            displaySuccess();
        }
    });
}

function displayErrors(errors) {
    const errorContainer = document.getElementById("errorContainer");
    errorContainer.innerHTML = ""; // Clear previous errors

    errors.forEach(error => {
        const alert = document.createElement("div");
        alert.className = "alert alert-danger";
        alert.textContent = error;
        errorContainer.appendChild(alert);
    });
}

function displaySuccess() {
    const errorContainer = document.getElementById("errorContainer");
    errorContainer.innerHTML = ""; // Clear existing errors

    const alert = document.createElement("div");
    alert.className = "alert alert-success";
    alert.textContent = "Form submitted successfully!";
    errorContainer.appendChild(alert);

    // Clear form fields
    document.getElementById("name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("message").value = "";
}