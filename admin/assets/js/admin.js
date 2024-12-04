// Cookies Functions.
function setCookie(name, value, options = {}) {
  if (!name || /^(?:expires|max-age|path|domain|secure|samesite)$/i.test(name)) {
      throw new Error('Invalid cookie name');
  }

  let cookieString = encodeURIComponent(name) + '=' + encodeURIComponent(value);

  if (options.expires) {
      let expires = options.expires;
      if (typeof expires === 'number') {
          const date = new Date();
          date.setTime(date.getTime() + expires * 24 * 60 * 60 * 1000);
          expires = date;
      }
      if (expires instanceof Date) {
          cookieString += '; expires=' + expires.toUTCString();
      }
  }

  if (options.path) {
      cookieString += '; path=' + options.path;
  } else {
      cookieString += '; path=/';
  }

  if (options.domain) {
      cookieString += '; domain=' + options.domain;
  }

  if (options.secure) {
      cookieString += '; secure';
  }

  if (options.sameSite) {
      const allowedValues = ['Strict', 'Lax', 'None'];
      if (allowedValues.includes(options.sameSite)) {
          cookieString += '; samesite=' + options.sameSite;
      } else {
          throw new Error('Invalid SameSite value');
      }
  }

  document.cookie = cookieString;
}

function getCookie(name) {
  if (!name) {
      throw new Error('Cookie name is required');
  }

  const nameEQ = encodeURIComponent(name) + '=';
  const cookies = document.cookie.split(';');

  for (let cookie of cookies) {
      cookie = cookie.trim();
      if (cookie.startsWith(nameEQ)) {
          return decodeURIComponent(cookie.substring(nameEQ.length));
      }
  }

  return null;
}

function deleteCookie(name, options = {}) {
  if (!name) {
      throw new Error('Cookie name is required');
  }

  setCookie(name, '', {
      ...options,
      expires: new Date(0),
  });
}

function getAllCookies() {
  const cookies = document.cookie ? document.cookie.split('; ') : [];
  const result = {};

  for (let cookie of cookies) {
      const [name, ...rest] = cookie.split('=');
      const value = rest.join('=');
      result[decodeURIComponent(name)] = decodeURIComponent(value);
  }

  return result;
}

function checkCookieExists(name) {
  return getCookie(name) !== null;
}

function updateCookie(name, newValue, options = {}) {
  if (!checkCookieExists(name)) {
      throw new Error(`Cookie with name "${name}" does not exist.`);
  }

  setCookie(name, newValue, options);
}

// Example usage
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('cookieForm');
  const cookieNameInput = document.getElementById('cookieName');
  const cookieValueInput = document.getElementById('cookieValue');
  const setCookieBtn = document.getElementById('setCookie');
  const getCookieBtn = document.getElementById('getCookie');
  const deleteCookieBtn = document.getElementById('deleteCookie');
  const displayArea = document.getElementById('display');

  setCookieBtn.addEventListener('click', () => {
      const name = cookieNameInput.value;
      const value = cookieValueInput.value;
      setCookie(name, value, { expires: 7, path: '/', sameSite: 'Lax' });
      displayArea.textContent = `Cookie "${name}" has been set.`;
  });

  getCookieBtn.addEventListener('click', () => {
      const name = cookieNameInput.value;
      const value = getCookie(name);
      if (value) {
          displayArea.textContent = `Value of "${name}": ${value}`;
      } else {
          displayArea.textContent = `Cookie "${name}" not found.`;
      }
  });

  deleteCookieBtn.addEventListener('click', () => {
      const name = cookieNameInput.value;
      deleteCookie(name, { path: '/' });
      displayArea.textContent = `Cookie "${name}" has been deleted.`;
  });
});

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

// Toggle theme on button click.
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
