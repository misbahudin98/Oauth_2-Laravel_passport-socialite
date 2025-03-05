/**
 * Extracts URL query parameters and returns them as a JSON string.
 * This function parses the current window's search string and
 * converts the parameters into a JSON object.
 *
 * @returns {string} JSON string representing the query parameters.
 */
function callback() {
    // Create a URLSearchParams instance from the current URL's query string
    let params = new URLSearchParams(window.location.search);
    let data = {};

    // Loop through each parameter and add it to the data object
    for (const [key, value] of params.entries()) {
        data[key] = value;
    }

    // Return the parameters as a JSON string
    return JSON.stringify(data);
}

/**
 * Retrieves the JWT token from a cookie and parses it into an object.
 * If the token cannot be parsed, logs an error and displays an error message.
 *
 * @returns {object|null} The parsed token object or null if parsing fails.
 */
function token() {
    let tokenObj = null;
    try {
        // Retrieve the token string from the cookie (assumed to be URL-decoded already)
        var token = getCookie(COOKIE_NAME);
        // Parse the token string as JSON to obtain an object
        tokenObj = JSON.parse(token);

        // Optional: Display token details (e.g., in an <h1> element)
        // $("h1").html("Access Token: " + tokenObj.access + "<br>Refresh Token: " + tokenObj.refresh);
    } catch (e) {
        console.error("Error parsing JWT:", e);
        $("h1").html("Error parsing JWT.");
    }
    // Return the token object, or null if it is not valid
    return tokenObj ?? null;
}

/**
 * Retrieves the refresh token from the JWT cookie.
 * This helper function parses the JWT cookie and extracts the refresh token.
 *
 * @returns {string|null} The refresh token, or null if it is not available or invalid.
 */
function getRefreshToken() {
    // Retrieve the JWT cookie value
    var jwtCookie = getCookie(COOKIE_NAME);
    if (jwtCookie) {
        try {
            // Parse the JWT cookie as JSON to extract the token data
            var jwtData = JSON.parse(jwtCookie);
            return jwtData.refresh_token;
        } catch (e) {
            console.error("Invalid JWT cookie format.");
        }
    }
    return null;
}

/**
 * Refreshes the authentication token using the refresh token.
 * Sends an AJAX request to the token refresh endpoint and updates the JWT cookie
 * with the new access and refresh tokens along with the expiration time.
 */
function refreshAuthToken() {
    var refreshToken = getRefreshToken();
    if (!refreshToken) {
        console.error("Refresh token not found.");
        return;
    }

    // Send a POST request to the token refresh API endpoint
    $.ajax({
        url: DOMAIN_API + 'api/refresh',
        method: 'POST',
        data: {
            refresh_token: refreshToken
        },
        success: function (data) {
            // Create a new token object with the refreshed tokens
            var jwtData = {
                access_token: data.access_token,
                refresh_token: data.refresh_token
            };
            // Set the updated JWT in a cookie with the new expiration time (in seconds)
            setCookie('jwt', JSON.stringify(jwtData), data.expires_in);
            console.log("Token refreshed successfully.");
            // Optional: Retry the original request if needed
        },
        error: function (xhr, status, error) {
            console.error("Token refresh failed:", error);
            alert("Token refresh failed: " + error);
            // Optional: Handle token refresh failure (e.g., redirect to the login page)
        }
    });
}

/**
 * Logs out the user by clearing all cookies and revoking the token on the server.
 * This function sends an AJAX DELETE request to the logout endpoint with the current access token.
 */
function logout() {
    // Clear all cookies on the client side
    clearAllCookie();

    // Send a DELETE request to the logout API endpoint to revoke the token
    $.ajax({
        type: "delete",
        url: DOMAIN_API + "/api/logout",
        headers: {
            // Use the access token retrieved from the token() function
            "Authorization": "Bearer " + tokenObj.access
        },
        success: function (response) {
            console.log(response);
        },
        // Optionally, you can handle errors here as well
    });
}
