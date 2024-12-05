// Cookie Management Functions

/**
 * Sets a cookie with the given name, value, and options.
 *
 * @param {string} name - The name of the cookie.
 * @param {string} value - The value of the cookie.
 * @param {Object} [options] - Optional settings for the cookie.
 * @param {number|Date} [options.expires] - Expiration time in days or a specific Date object.
 * @param {string} [options.path] - The URL path the cookie is valid for.
 * @param {string} [options.domain] - The domain the cookie is valid for.
 * @param {boolean} [options.secure] - Whether the cookie should only be transmitted over secure protocols.
 * @param {string} [options.sameSite] - The SameSite attribute ('Strict', 'Lax', 'None').
 * @returns {boolean} - Returns true if the cookie was successfully set.
 */
function setCookie(name, value, options = {}) {
  if (
    !name ||
    /^(?:expires|max-age|path|domain|secure|samesite)$/i.test(name)
  ) {
    throw new Error("Invalid cookie name");
  }

  let cookieString = encodeURIComponent(name) + "=" + encodeURIComponent(value);

  if (options.expires) {
    let expires = options.expires;
    if (typeof expires === "number") {
      const date = new Date();
      date.setTime(date.getTime() + expires * 24 * 60 * 60 * 1000);
      expires = date;
    }
    if (expires instanceof Date) {
      cookieString += "; expires=" + expires.toUTCString();
    }
  }

  cookieString += "; path=" + (options.path ? options.path : "/"); // Ternary Operator

  options.domain && (cookieString += "; domain=" + options.domain); // Logical AND
  options.secure && (cookieString += "; secure"); // Logical AND

  if (options.sameSite) {
    const allowedValues = ["Strict", "Lax", "None"];
    allowedValues.includes(options.sameSite)
      ? (cookieString += "; samesite=" + options.sameSite) // Ternary Operator
      : (() => {
          throw new Error("Invalid SameSite value");
        })(); // IIFE for throwing error
  }

  document.cookie = cookieString;
  return value === getCookie(name);
}

/**
 * Retrieves the value of a cookie by name.
 *
 * @param {string} name - The name of the cookie to retrieve.
 * @returns {string|null} - The cookie value or null if not found.
 */
function getCookie(name) {
  if (!name) {
    throw new Error("Cookie name is required");
  }

  const nameEQ = encodeURIComponent(name) + "=";
  const cookies = document.cookie.split(";");

  for (let cookie of cookies) {
    cookie = cookie.trim();
    if (cookie.startsWith(nameEQ)) {
      return decodeURIComponent(cookie.substring(nameEQ.length));
    }
  }

  return null;
}

/**
 * Deletes a cookie by name.
 *
 * @param {string} name - The name of the cookie to delete.
 * @param {Object} [options] - Optional settings for the cookie.
 * @param {string} [options.path] - The URL path the cookie is valid for.
 * @param {string} [options.domain] - The domain the cookie is valid for.
 * @returns {boolean} - Returns true if the cookie was successfully deleted.
 */
function deleteCookie(name, options = {}) {
  if (!name) {
    throw new Error("Cookie name is required.");
  }

  // To delete a cookie, set its expiration date to a past date
  setCookie(name, "", {
    ...options,
    expires: new Date(0),
  });

  return !getCookie(name) ? true : false;
}

// LocalStorage Management Functions

/**
 * Sets a key-value pair in LocalStorage with encoding.
 *
 * @param {string} name - The key name.
 * @param {string} value - The value to store.
 * @returns {boolean} - Returns true if the item was successfully set.
 */
function setLocalStorage(name, value) {
  if (!name) {
    throw new Error("Key name is required.");
  }

  const encodedName = encodeURIComponent(name);
  const encodedValue = encodeURIComponent(value);
  localStorage.setItem(encodedName, encodedValue);
  return localStorage.getItem(encodedName) === encodedValue;
}

/**
 * Retrieves the value associated with a key from LocalStorage with decoding.
 *
 * @param {string} name - The key name.
 * @returns {string|null} - The decoded value or null if not found.
 */
function getLocalStorage(name) {
  if (!name) {
    throw new Error("Key name is required.");
  }

  const encodedName = encodeURIComponent(name);
  const encodedValue = localStorage.getItem(encodedName);
  return encodedValue ? decodeURIComponent(encodedValue) : null;
}

/**
 * Deletes a key-value pair from LocalStorage.
 *
 * @param {string} name - The key name.
 * @returns {boolean} - Returns true if the item was successfully deleted.
 */
function deleteLocalStorage(name) {
  if (!name) {
    throw new Error("Key name is required.");
  }

  const encodedName = encodeURIComponent(name);
  localStorage.removeItem(encodedName);
  return localStorage.getItem(encodedName) === null;
}

// Enhanced Storage Functions

/**
 * Sets a key-value pair in both Cookies and LocalStorage.
 * Also tracks the key in a dedicated LocalStorage array.
 *
 * @param {string} name - The key name.
 * @param {string} value - The value to store.
 * @param {Object} [options] - Optional settings for the cookie.
 * @param {number|Date} [options.expires] - Expiration time in days or a specific Date object.
 * @param {string} [options.path] - The URL path the cookie is valid for.
 * @param {string} [options.domain] - The domain the cookie is valid for.
 * @param {boolean} [options.secure] - Whether the cookie should only be transmitted over secure protocols.
 * @param {string} [options.sameSite] - The SameSite attribute ('Strict', 'Lax', 'None').
 * @returns {boolean} - Returns true if both storage operations were successful.
 */
function setData(name, value, options = {}) {
  if (!name) {
    throw new Error("Key name is required.");
  }
console.log('reach sd');
  // Set Cookie
  const cookieSet = setCookie(name, value, options);

  // Set LocalStorage
  const localStorageSet = setLocalStorage(name, value);

  // Track the key in LocalStorage using ternary operator
  let trackedKeys = JSON.parse(localStorage.getItem("trackedKeys")) || [];
  trackedKeys.includes(name)
    ? null
    : (trackedKeys.push(name),
      localStorage.setItem("trackedKeys", JSON.stringify(trackedKeys)));

  return (
    cookieSet &&
    localStorageSet &&
    localStorage.getItem("trackedKeys").includes(name)
  );
}

/**
 * Retrieves the value associated with a key from both Cookies and LocalStorage.
 * Returns the value only if both storage mediums have consistent data.
 *
 * @param {string} name - The key name.
 * @returns {string|null} - The value if consistent, otherwise null.
 */
function getData(name) {
  if (!name) {
    throw new Error("Key name is required.");
  }

  const cookieValue = getCookie(name);
  const localStorageValue = getLocalStorage(name);

  return cookieValue === localStorageValue &&
    localStorage.getItem("trackedKeys").includes(name)
    ? cookieValue
    : null;
}

/**
 * Deletes a key-value pair from both Cookies and LocalStorage.
 * Also removes the key from the tracked keys array.
 *
 * @param {string} name - The key name.
 * @param {Object} [options] - Optional settings for the cookie.
 * @param {string} [options.path] - The URL path the cookie is valid for.
 * @param {string} [options.domain] - The domain the cookie is valid for.
 * @returns {boolean} - Returns true if the key was successfully deleted from both storages.
 */
function deleteData(name, options = {}) {
  if (!name) {
    throw new Error("Key name is required.");
  }

  // Delete Cookie
  const cookieDeleted = deleteCookie(name, options);

  // Delete LocalStorage
  const localStorageDeleted = deleteLocalStorage(name);

  // Remove the key from trackedKeys using ternary operator
  let trackedKeys = JSON.parse(localStorage.getItem("trackedKeys")) || [];
  const index = trackedKeys.indexOf(name);
  index !== -1
    ? (trackedKeys.splice(index, 1),
      localStorage.setItem("trackedKeys", JSON.stringify(trackedKeys)))
    : null;

  return (
    cookieDeleted &&
    localStorageDeleted &&
    !localStorage.getItem("trackedKeys").includes(name)
  );
}

/**
 * Verifies that all tracked keys have consistent values in Cookies and LocalStorage.
 *
 * @returns {Object} - An object containing the verification status and any discrepancies.
 */
function verifyData() {
  const trackedKeys = JSON.parse(localStorage.getItem("trackedKeys")) || [];
  let discrepancies = [];

  for (let key of trackedKeys) {
    const cookieValue = getCookie(key);
    const localStorageValue = getLocalStorage(key);

    cookieValue !== localStorageValue &&
      discrepancies.push({
        key: key,
        cookieValue: cookieValue,
        localStorageValue: localStorageValue,
      });
  }

  return discrepancies.length === 0
    ? {
        status: "Success",
        message: "All Cookies and LocalStorage values are consistent.",
      }
    : {
        status: "Discrepancies Found",
        discrepancies: discrepancies,
      };
}

/**
 * Fixes data inconsistencies between Cookies and LocalStorage based on the given priority.
 *
 * @param {string} priority - The priority storage medium ('cookie' or 'ls').
 * @returns {Object} - An object containing the fix status and details of changes made.
 */
function fixData(priority = "cookie") {
  const validPriorities = ["cookie", "ls"];

  return validPriorities.includes(priority.toLowerCase())
    ? (function () {
        const trackedKeys =
          JSON.parse(localStorage.getItem("trackedKeys")) || [];
        let changes = [];

        trackedKeys.forEach((key) => {
          const cookieValue = getCookie(key);
          const localStorageValue = getLocalStorage(key);

          if (cookieValue !== localStorageValue) {
            if (priority.toLowerCase() === "cookie") {
              cookieValue !== null
                ? (setLocalStorage(key, cookieValue),
                  changes.push({
                    key,
                    updated: "localStorage",
                    value: cookieValue,
                  }))
                : (deleteLocalStorage(key),
                  changes.push({ key, updated: "localStorage", value: null }));
            } else {
              // priority === "ls"
              localStorageValue !== null
                ? (setCookie(key, localStorageValue, { path: "/" }),
                  changes.push({
                    key,
                    updated: "cookie",
                    value: localStorageValue,
                  }))
                : (deleteCookie(key, { path: "/" }),
                  changes.push({ key, updated: "cookie", value: null }));
            }
          }
        });

        return {
          priority: priority.toLowerCase(),
          changes: changes,
          message:
            changes.length === 0
              ? "No discrepancies found. All data is consistent."
              : `Fixed ${changes.length} discrepancies based on priority '${priority}'.`,
        };
      })()
    : (() => {
        throw new Error("Invalid priority value. Must be 'cookie' or 'ls'.");
      })();
}

// New Function: getAllData

/**
 * Retrieves all tracked keys and their values from both Cookies and LocalStorage.
 *
 * @returns {Array} - An array of objects containing key, cookieValue, localStorageValue, and consistency status.
 */
function getAllData() {
  const trackedKeys = JSON.parse(localStorage.getItem("trackedKeys")) || [];
  return trackedKeys.map((key) => {
    const value = getCookie(key);
    const localStorageValue = getLocalStorage(key);
    return value === localStorageValue ? { key, value } : null;
  });
}

// Utility Functions

/**
 * Retrieves all cookies as an object.
 *
 * @returns {Object} - An object containing all cookies.
 */
function getAllCookies() {
  const cookies = document.cookie ? document.cookie.split("; ") : [];
  const result = {};

  for (let cookie of cookies) {
    const [name, ...rest] = cookie.split("=");
    const value = rest.join("=");
    result[decodeURIComponent(name)] = decodeURIComponent(value);
  }

  return result;
}

/**
 * Retrieves all items from LocalStorage as an object.
 *
 * @returns {Object} - An object containing all LocalStorage key-value pairs.
 */
function getAllLocalStorageItems() {
  const result = {};
  for (let i = 0; i < localStorage.length; i++) {
    const encodedKey = localStorage.key(i);
    const encodedValue = localStorage.getItem(encodedKey);
    const key = decodeURIComponent(encodedKey);
    const value = decodeURIComponent(encodedValue);
    result[key] = value;
  }
  return result;
}

window.onload = function () {

    fixData();
  // Theme Toggle Script
  const themeToggleBtn = document.getElementById("theme-toggle");
  const themeToggleLightIcon = document.getElementById(
    "theme-toggle-light-icon"
  );
  const themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
  const htmlElement = document.documentElement;

  // On page load or when changing themes, best to add inline in `head` to avoid FOUC
  if (
    getData("color-theme") === "dark" ||
    (!("color-theme" in localStorage) &&
      window.matchMedia("(prefers-color-scheme: dark)").matches) ||
      htmlElement.classList.includes('dark')
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
    setData(
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
};
