/**
 * Prompts the user to reload the page when something goes wrong.
 */
function reloadPage() {
    // Message to display in the confirmation dialog.
    let text = "Something went wrong, please confirm to reload the page";
    // If the user confirms, reload the current page.
    if (confirm(text) == true) {
        location.reload();
    }
}

/**
 * Global AJAX error handler.
 * This handler listens for any AJAX errors on the document and processes them accordingly.
 */
$(document).ajaxError((event, jqXHR, ajaxSettings, thrownError) => {
    // Get the current path of the application.
    const currentRoute = window.location.pathname;
    console.error("AJAX Error:", thrownError, jqXHR);

    // If the AJAX request is a GET request and a network error occurs,
    // prompt the user to reload the page.
    if (ajaxSettings.type?.toLowerCase() === 'get' && thrownError === 'ERR_NETWORK') {
        return reloadPage();
    }

    // If the current route is not the login page, the request URL is valid,
    // the URL is not for the OAuth token endpoint, and the status is 401 (Unauthorized),
    // attempt to refresh the authentication token.
    if (
        !currentRoute.includes('/login/') &&
        ajaxSettings.url &&
        !ajaxSettings.url.includes(DOMAIN_API + '/oauth/token') &&
        jqXHR.status === 401
    ) {
        refreshAuthToken();
    }
    
    // Retrieve the response URL if it exists.
    let responseUrl = jqXHR.responseURL || '';

    // If the response URL contains 'api', skip showing an alert to avoid unnecessary error popups.
    if (responseUrl.indexOf('api') !== -1) {
        return;
    }

    // Extract error information from the AJAX response.
    let er = jqXHR.responseJSON || {};
    let t = '';

    // If the error response contains detailed error messages, iterate through them and build a string.
    if (er && er.data && er.data.errors) {
        let errors = er.data.errors;
        for (const key in errors) {
            t += ` ${key}: ${errors[key]} `;
        }
    } else {
        // Otherwise, use a generic error message based on available error information.
        t = er.message || thrownError || jqXHR.statusText;
    }

    // Display an alert to the user with the error details.
    // The alert title is 'Gagal' (Indonesian for "Failed"), and it shows the constructed error message.
    alert(
        'Gagal',
        (er.status >= 400 && er.status < 500 && er.status != 0) ? t : ( er.message || 'Something went wrong'),
        'error'
    );
});
