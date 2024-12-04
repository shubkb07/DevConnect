// Cookie Management Functions
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
      cookieString += '; path=/'; // Default to root path
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
  return value === getCookie(name);
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
      throw new Error('Cookie name is required.');
  }

  // To delete a cookie, set its expiration date to a past date
  setCookie(name, '', {
      ...options,
      expires: new Date(0),
  });

  return !getCookie(name) ? true : false;
}

// Enhanced Storage Functions
function setData(name, value, options = {}) {
  if (!name) {
      throw new Error('Key name is required.');
  }

  // Set Cookie
  setCookie(name, value, options);

  // Set LocalStorage
  localStorage.setItem(name, value);

  // Track the key in LocalStorage
  let trackedKeys = JSON.parse(localStorage.getItem('trackedKeys')) || [];
  if (!trackedKeys.includes(name)) {
      trackedKeys.push(name);
      localStorage.setItem('trackedKeys', JSON.stringify(trackedKeys));
  }
  return (getCookie(name) === value) && (localStorage.getItem(name) === value) && localStorage.getItem('trackedKeys').includes(name);
}

function getData(name) {
  if (!name) {
      throw new Error('Key name is required.');
  }

  const cookieValue = getCookie(name);
  const localStorageValue = localStorage.getItem(name);

  return (cookieValue === localStorageValue) && localStorage.getItem('trackedKeys').includes(name) ? cookieValue : null;
}

function deleteData(name, options = {}) {
  if (!name) {
      throw new Error('Key name is required.');
  }

  // Delete Cookie
  deleteCookie(name, options);

  // Delete LocalStorage
  localStorage.removeItem(name);

  // Remove the key from trackedKeys
  let trackedKeys = JSON.parse(localStorage.getItem('trackedKeys')) || [];
  const index = trackedKeys.indexOf(name);
  if (index !== -1) {
      trackedKeys.splice(index, 1);
      localStorage.setItem('trackedKeys', JSON.stringify(trackedKeys));
  }

  return !localStorage.getItem('trackedKeys').includes(name) && !getCookie(name) && !localStorage.getItem(name);
}

function verifyData() {
  const trackedKeys = JSON.parse(localStorage.getItem('trackedKeys')) || [];
  let discrepancies = [];

  for (let key of trackedKeys) {
      const cookieValue = getCookie(key);
      const localStorageValue = localStorage.getItem(key);

      if (cookieValue !== localStorageValue) {
          discrepancies.push({
              key: key,
              cookieValue: cookieValue,
              localStorageValue: localStorageValue
          });
      }
  }

  if (discrepancies.length === 0) {
      return {
          status: 'Success',
          message: 'All Cookies and LocalStorage values are consistent.'
      };
  } else {
      return {
          status: 'Discrepancies Found',
          discrepancies: discrepancies
      };
  }
}

// Utility Functions
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

function getAllLocalStorageItems() {
  const result = {};
  for (let i = 0; i < localStorage.length; i++) {
      const key = localStorage.key(i);
      const value = localStorage.getItem(key);
      result[key] = value;
  }
  return result;
}

// DOM Manipulation and Event Handling
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('storageForm');
  const keyInput = document.getElementById('key');
  const valueInput = document.getElementById('value');
  const expiresInput = document.getElementById('expires');
  const sameSiteSelect = document.getElementById('sameSite');
  const setBtn = document.getElementById('setBtn');
  const getBtn = document.getElementById('getBtn');
  const deleteBtn = document.getElementById('deleteBtn');
  const verifyBtn = document.getElementById('verifyBtn');
  const output = document.getElementById('output');

  setBtn.addEventListener('click', () => {
      const key = keyInput.value.trim();
      const value = valueInput.value.trim();
      const expires = expiresInput.value ? parseInt(expiresInput.value) : undefined;
      const sameSite = sameSiteSelect.value;

      if (!key || !value) {
          output.textContent = 'Key and Value are required.';
          return;
      }

      const options = {};
      if (expires) options.expires = expires;
      if (sameSite) options.sameSite = sameSite;

      try {
          setDualStorage(key, value, options);
          output.textContent = `Set "${key}" in both Cookies and LocalStorage.`;
      } catch (error) {
          output.textContent = `Error: ${error.message}`;
      }
  });

  getBtn.addEventListener('click', () => {
      const key = keyInput.value.trim();

      if (!key) {
          output.textContent = 'Key is required to retrieve data.';
          return;
      }

      try {
          const data = getDualStorage(key);
          output.innerHTML = `
              <strong>Cookie Value:</strong> ${data.cookieValue !== null ? data.cookieValue : 'Not Found'}<br>
              <strong>LocalStorage Value:</strong> ${data.localStorageValue !== null ? data.localStorageValue : 'Not Found'}
          `;
      } catch (error) {
          output.textContent = `Error: ${error.message}`;
      }
  });

  deleteBtn.addEventListener('click', () => {
      const key = keyInput.value.trim();

      if (!key) {
          output.textContent = 'Key is required to delete data.';
          return;
      }

      try {
          deleteDualStorage(key, { path: '/' });
          output.textContent = `Deleted "${key}" from both Cookies and LocalStorage.`;
      } catch (error) {
          output.textContent = `Error: ${error.message}`;
      }
  });

  verifyBtn.addEventListener('click', () => {
      try {
          const result = verifyDualStorage();
          if (result.status === 'Success') {
              output.textContent = result.message;
          } else {
              let discrepancyText = 'Discrepancies Found:\n';
              result.discrepancies.forEach(item => {
                  discrepancyText += `Key: ${item.key}\nCookie Value: ${item.cookieValue}\nLocalStorage Value: ${item.localStorageValue}\n\n`;
              });
              output.textContent = discrepancyText;
          }
      } catch (error) {
          output.textContent = `Error: ${error.message}`;
      }
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
