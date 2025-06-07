// script.js

// Swiper slider initialization
document.addEventListener('DOMContentLoaded', () => {
  new Swiper('.deals-swiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      640: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
    }
  });
});

// Show all gallery destinations
function showAllDestinations() {
  const grid = document.querySelector('.gallery-grid');
  grid.classList.add('show-all');
  document.querySelector('.view-all-button').style.display = 'none';
}

// Toggle Policy Sections
function toggleSection(event, sectionId) {
  event.preventDefault();

  const container = document.getElementById("policy-container");
  const privacy = document.getElementById("privacy-policy");
  const terms = document.getElementById("terms-of-service");

  // Hide both sections first
  privacy.style.display = "none";
  terms.style.display = "none";

  // Show the container and the selected section
  container.classList.add("show");

  if (sectionId === "privacy-policy") {
    privacy.style.display = "block";
  } else if (sectionId === "terms-of-service") {
    terms.style.display = "block";
  }
}

// Close Policy Container
function closePolicy() {
  const container = document.getElementById("policy-container");
  const privacy = document.getElementById("privacy-policy");
  const terms = document.getElementById("terms-of-service");

  container.classList.remove("show");
  privacy.style.display = "none";
  terms.style.display = "none";
}
