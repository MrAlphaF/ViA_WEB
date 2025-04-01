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
const darkModeOn = localStorage.getItem("darkModeOn");
console.log("darkmodeOn on init: " + darkModeOn);

if (darkModeOn) {
    document.body.classList.add("darkMode");
}
else {
    document.body.classList.remove("darkMode");
}

function toggleDarkMode() {
    // console.log("localStorage before toggling script: " + localStorage.getItem("darkModeOn"));
    document.body.classList.toggle("darkMode");
    // console.log("localStorage after toggling: " + localStorage.getItem("darkModeOn"));
    localStorage.setItem("darkModeOn", document.body.classList.contains("darkMode"));
    console.log("localStorage after setting: " + darkModeOn);
};

document.addEventListener("DOMContentLoaded", function () {
    initHeroSection(); // Call the function for hero section effects
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