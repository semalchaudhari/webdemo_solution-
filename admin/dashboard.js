const menuBtn = document.getElementById("menuBtn");
const sidebar = document.getElementById("sidebar");


// =========================
// MOBILE SIDEBAR
// =========================

menuBtn.addEventListener("click", () => {
    sidebar.classList.toggle("open");
});


// =========================
// DEMO DASHBOARD DATA
// =========================

// const dashboardData = {
//     services: 12,
//     brands: 8,
//     reviews: 25,
//     subscribers: 150
// };


// =========================
// DISPLAY DATA
// =========================

// document.getElementById("serviceCount").textContent =
//     dashboardData.services;

// document.getElementById("brandCount").textContent =
//     dashboardData.brands;

// document.getElementById("reviewCount").textContent =
//     dashboardData.reviews;

// document.getElementById("subscriberCount").textContent =
//     dashboardData.subscribers;


// // Overview

// document.getElementById("overviewServices").textContent =
//     dashboardData.services;

// document.getElementById("overviewBrands").textContent =
//     dashboardData.brands;

// document.getElementById("overviewReviews").textContent =
//     dashboardData.reviews;

// document.getElementById("overviewSubscribers").textContent =
//     dashboardData.subscribers;