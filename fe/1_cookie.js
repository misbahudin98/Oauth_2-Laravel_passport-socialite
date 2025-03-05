// Constant for the cookie name (JWT token)
const COOKIE_NAME = "jwt";

// Constant for the cookie path; using "/" for all paths on the domain
const COOKIE_PATH = "/;";

// Determines if the cookie should be marked as Secure (only sent over HTTPS)
// The "Secure;" attribute is added only if the current protocol is HTTPS.
const COOKIE_SECURE = (location.protocol === "https:") ? "Secure;" : "";

// Sets the SameSite attribute for the cookie to enhance CSRF protection.
// Options include "Lax;", "None;", or "Strict;". Here, we use "Strict;".
const COOKIE_SAME_SITE = "Strict;";

// Optionally, you can specify a domain for the cookie (e.g., ".fe.org" for subdomains).
// Leave empty if not needed.
const COOKIE_DOMAIN = "";

// Constants for domain URLs (useful if you need to reference these elsewhere in your code)
const DOMAIN = "http://fe.org/";
const DOMAIN_API = "http://laravel.org/";

/**
 * Retrieves the value of a cookie by its name.
 *
 * @param {string} name - The name of the cookie.
 * @returns {string|undefined} - The decoded cookie value, or undefined if not found.
 */
function getCookie(name) {
    // Construct a regular expression to match the cookie name and capture its value
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    // Return the decoded value if a match is found, otherwise undefined.
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

/**
 * Sets a cookie with a specified name, value, and expiration time (in seconds).
 *
 * @param {string} name - The name of the cookie.
 * @param {string} value - The value to be stored in the cookie.
 * @param {number} seconds - The lifetime of the cookie in seconds.
 */
function setCookie(name, value, seconds) {
    var expires = "";
    // If an expiration time is provided, calculate the expiration date in UTC format.
    if (seconds) {
        var date = new Date();
        date.setTime(date.getTime() + seconds * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    // Log expiration details for debugging purposes.
    console.log(seconds, expires);

    // Construct the cookie string with all attributes (path, secure, sameSite, and domain if provided)
    document.cookie = name + "=" + (value || "") + expires +
        "; path=" + COOKIE_PATH +
        COOKIE_SECURE +
        COOKIE_SAME_SITE +
        COOKIE_DOMAIN;
}

/**
 * Clears all cookies by setting their expiration dates to a past date.
 * This function iterates over all cookies and effectively deletes them.
 */
function clearAllCookie() {
    document.cookie.split(";").forEach(function (c) {
        // Remove leading spaces and set the cookie's expiration date to the Unix epoch (January 1, 1970)
        document.cookie = c.replace(/^ +/, "")
            .replace(/=.*/, "=;expires=" + new Date(0).toUTCString() + ";path=/");
    });
}
