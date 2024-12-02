// Theme Toggle Script
const themeToggleBtn = document.getElementById("theme-toggle");
const themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");
const themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
const htmlElement = document.documentElement;

// On page load or when changing themes, best to add inline in `head` to avoid FOUC
if (
  localStorage.getItem("color-theme") === "dark" ||
  (!("color-theme" in localStorage) &&
    window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
  document.documentElement.classList.add("dark");
  themeToggleDarkIcon.classList.remove("hidden");
} else {
  document.documentElement.classList.remove("dark");
  themeToggleLightIcon.classList.remove("hidden");
}

// Toggle theme on button click
themeToggleBtn.addEventListener("click", () => {
  htmlElement.classList.toggle("dark");
  themeToggleLightIcon.classList.toggle("hidden");
  themeToggleDarkIcon.classList.toggle("hidden");
  localStorage.setItem(
    "color-theme",
    htmlElement.classList.contains("dark") ? "dark" : "light"
  );
});

const searchButton = document.getElementById("search-button");
const searchBarContainer = document.getElementById("search-bar-container");

// Open the search bar when the search button is clicked
searchButton.addEventListener("click", () => {
  searchBarContainer.classList.remove("hidden");
});

// Close the search bar when clicking outside of it
searchBarContainer.addEventListener("click", (event) => {
  if (event.target === searchBarContainer) {
    searchBarContainer.classList.add("hidden");
  }
});
