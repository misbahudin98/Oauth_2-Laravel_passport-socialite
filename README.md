# Laravel Passport PKCE Authentication with Nginx Virtual Hosts

## Overview
This project demonstrates how to set up a Laravel 12 application with Laravel Passport using the PKCE flow for secure OAuth2 authentication. It is designed to be easy to understand, even for beginners. The backend is hosted on `http://laravel.org` and the frontend on `http://fe.org`, with both running on separate domains. A public client configuration is used.

## What Does This Project Do?

- **User Login:** Allows users to log in using a simple form.
- **OAuth2 PKCE Flow:** Uses a secure method (PKCE) to authenticate users.
- **Separate Domains:** Backend (Laravel) and Frontend are hosted on different domains.
- **Token Management:** After login, users receive an access token and a refresh token for secure API calls.
- **Automatic Token Refresh:** If a token expires, the system automatically tries to refresh it.
- **Logout:** Users can log out, which clears their tokens both on the client and the server.

## How to Set Up the Project

### Prerequisites
- PHP and Composer installed.
- Basic knowledge of Laravel and web development.

## Steps to Install Laravel Passport

1. **Clone the Repository:**
   ```bash
   git clone <repository-url>
   cd <repository-directory>

2. **Install Dependencies:**
   ```bash
    composer install
    npm install
    npm run dev

3. **Configure Environment Variables:**
   Open the <mark>.env</mark> file and update these settings
   ```bash
        APP_URL=http://laravel.org
        SESSION_DRIVER=database
        SESSION_LIFETIME=1
        SESSION_ENCRYPT=false
        SESSION_SECURE_COOKIE=false
        SESSION_PATH=/
        SESSION_DOMAIN=.laravel.org

        PASSPORT_ACCESS=1
        PASSPORT_REFRESH=3

4. **Generate the Application Key:**
   ```bash
        php artisan key:generate

5. **Run Database Migrations:**
   ```bash
        php artisan migrate

6. **Install Laravel Passport (Public Client):**
   ```bash
        php artisan passport:install --client=public

## Nginx Virtual Host Setup
   Create a virtual host file for 
    · Backend <mark>laravel.org</mark>:
    · Frontend <mark>fe.org</mark>:

## Laravel Passport & Application Configuration

    **Update AppServiceProvider**
    In your <mark>AppServiceProvider.php</mark> within the boot method, add:
   ```bash
        use Laravel\Passport\Passport;

        public function boot()
        {
            Passport::hashClientSecrets();

            // Set token expiration times using values from the .env file.
            Passport::tokensExpireIn(now()->addMinutes((int) env("PASSPORT_ACCESS", 1)));
            Passport::refreshTokensExpireIn(now()->addMinutes((int) env("PASSPORT_REFRESH", 3)));
            Passport::personalAccessTokensExpireIn(now()->addMonths(6));
        }
    
    **CORS Settings**
    Ensure that your <mark>config/cors.php</mark> file allows cross-origin requests between <mark>http://laravel.org</mark> and <mark>http://fe.org</mark>.

## How the Routes Work

    **Web Routes (Frontend Interaction)**
   · <mark>/login</mark>: Displays the login form.
   · <mark>/submit</mark>: Processes the login form and validates user credentials.
   · <mark>/redirect</mark>: Forces users to log in if they are not authenticated.
   · <mark>/callback-action</mark>: Receives the authorization code and state from Laravel, then sends these to the frontend.
   · <mark>/callback</mark>: Redirects the user back to the frontend with their token details.

    **API Routes (Token and User Management)**
   · <mark>/api/user</mark>: Returns the authenticated user’s data.
   · <mark>/api/refresh</mark>: Refreshes the access token.
   · <mark>/api/logout</mark>: Revokes the user’s token, logging them out.

## How the Frontend Works

    **The frontend (using simple JavaScript) should:**

   1. Callback Page:
   · If it receives a <mark>state</mark> and <mark>code</mark>, send them to <mark>/callback-action</mark>.
   · If it receives token details (like an access token), store them (e.g., in cookies) and redirect to the main page.

   2. Index Page:
   Check if a token exists.
   · If there is a token, make a request to <mark>/api/user</mark> to get user information.
   · If the token is valid, display the access token (for example, in an <mark>H1</mark> element).
   · If no valid token is found, redirect the user to the login page.
   · Include a logout button to clear the token from both the client and the server.

## Error Handling

   · Network Errors: If a network error occurs, the page will reload.
   · 401 Unauthorized Errors: If a 401 error occurs, the application will try to refresh the token by calling <mark>/api/refresh</mark>. If refreshing fails, an alert will be shown.
   · Other Errors: For all other errors, a relevant error message will be displayed via an alert.

## Final Notes
   · This project uses a public client configuration with Laravel Passport.
   · The system is designed for separate domains (backend and frontend).
   · Always use HTTPS in production to secure token transmission.
   · Refer to the Laravel and Passport documentation for more details if needed.

## License
This project is licensed under the MIT License.