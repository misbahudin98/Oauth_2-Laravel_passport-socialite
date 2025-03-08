<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'google' => [
        /*
     * ---------------------------------------------------------------------
     * Mandatory Parameters (Wajib)
     * ---------------------------------------------------------------------
     */

        // Client ID dari Google, didapatkan dari Google Cloud Console.
        'client_id'     => env('GOOGLE_CLIENT_ID'),

        // Client Secret dari Google, digunakan untuk memverifikasi aplikasi Anda.
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),

        // Redirect URI: URL callback yang telah didaftarkan di Google Cloud Console.
        'redirect'      => env('GOOGLE_REDIRECT_URI'),

        /*
     * ---------------------------------------------------------------------
     * Scope
     * ---------------------------------------------------------------------
     * Scope menentukan izin apa saja yang diminta.
     * - 'openid' wajib jika menggunakan OpenID Connect (mendapatkan ID token).
     * - 'email' untuk mendapatkan alamat email pengguna.
     * - 'profile' untuk mendapatkan data profil dasar (opsional, tambahkan jika diperlukan).
     */
        'scope'         => ['email', 'openid'], // Tambahkan 'profile' jika ingin data profil lengkap.

        /*
     * ---------------------------------------------------------------------
     * Optional Parameters (Opsional)
     * ---------------------------------------------------------------------
     * Parameter di bawah ini akan ditambahkan ke query string saat permintaan OAuth.
     */
        'options' => [
            // prompt: Mengontrol tampilan halaman otorisasi.
            // Nilai yang mungkin:
            // - "none"    : Tidak menampilkan prompt (jika memungkinkan).
            // - "consent" : Memaksa pengguna untuk menyetujui ulang.
            // - "select_account" : Meminta pengguna memilih akun jika mereka memiliki beberapa akun.
            // Contoh gabungan: "select_account consent" untuk kedua efek tersebut.
            'prompt' => 'select_account consent',

            // hd: Hosted Domain.
            // Membatasi login hanya untuk akun dari domain tertentu, misalnya "example.com".
            // Jika tidak ada pembatasan, Anda bisa menggunakan '*' atau tidak menyertakan parameter ini.
            'hd' => env("APP_URL", "http://laravel.org"),

            // access_type: Menentukan jenis akses.
            // - "online"  : Akses online saja (tanpa refresh token).
            // - "offline" : Menghasilkan refresh token agar aplikasi dapat mengakses data saat pengguna tidak aktif.
            // Uncomment dan atur jika diperlukan:
            // 'access_type' => 'offline',

            // include_granted_scopes: Menentukan apakah scope yang sudah diberikan sebelumnya
            // ikut dipertahankan atau tidak.
            // - "true"  : Scope sebelumnya akan disertakan.
            // - "false" : Scope tidak dipertahankan.
            // Uncomment jika diperlukan:
            // 'include_granted_scopes' => 'true',

            // login_hint: Memberikan petunjuk kepada Google untuk menampilkan akun tertentu (misalnya email pengguna).
            'login_hint' => 'user@example.com',

            // response_type: Menentukan tipe respons.
            // Biasanya "code" untuk authorization code flow.
            // Secara default, Socialite menggunakan "code", jadi parameter ini biasanya tidak perlu diatur ulang.
            // 'response_type' => 'code',

            // max_age: Menentukan usia maksimum (dalam detik) dari sesi autentikasi yang diterima.
            // Nilai 0 atau 1 berarti memaksa login ulang setiap kali, Anda bisa mengubah sesuai kebutuhan (misalnya, 3600 untuk satu jam).
            'max_age' => 1,

            // PKCE (Proof Key for Code Exchange)
            // Jika Anda menerapkan PKCE, Anda harus mengirimkan code_challenge dan code_challenge_method.
            // 'code_challenge'        => $challenge, // Nilai code challenge, dihasilkan dari code verifier dengan metode S256.
            // 'code_challenge_method' => 'S256',      // Metode code challenge (biasanya 'S256').

            // nonce: Nilai acak yang mengikat sesi pengguna dengan ID token.
            // Pastikan setiap permintaan memiliki nilai nonce yang unik untuk keamanan.
            // 'nonce' => 'unique_random_string',

            // authuser: Digunakan jika pengguna memiliki beberapa akun Google dan ingin memilih akun tertentu.
            // Nilai 0 biasanya untuk akun default.
            // 'authuser' => 0,

            // state: Parameter keamanan untuk mencegah serangan CSRF.
            // Socialite biasanya mengelolanya secara otomatis, tetapi Anda bisa mengaturnya jika perlu.
            // 'state' => 'custom_state_value',
        ],
    ],

    'facebook' => [
        /*
     * ------------------------------
     *  Mandatory Parameters
     * ------------------------------
     */
        'client_id'         => env('FACEBOOK_CLIENT_ID'),
        // Facebook App ID, didapatkan dari Facebook Developer Portal.

        'client_secret'     => env('FACEBOOK_CLIENT_SECRET'),
        // Facebook App Secret, digunakan untuk memverifikasi aplikasi Anda.

        'redirect'          => env('FACEBOOK_REDIRECT_URI'),
        // URL callback yang akan dipanggil oleh Facebook setelah autentikasi.
        // URL ini harus didaftarkan di bagian "Authorized Redirect URIs" di Facebook Developer.

        'graph_api_version' => 'v12.0',
        // Versi Graph API yang akan digunakan. Pastikan sesuai dengan versi yang aktif di Facebook Developer.

        /*
     * ------------------------------
     *  Optional Parameters
     * ------------------------------
     */

        'fields'            => 'name,email,picture',
        // Field yang akan diminta dari profil pengguna.
        // Misalnya, 'name,email,picture' untuk mendapatkan nama, email, dan foto profil.

        'scopes'            => ['email', 'public_profile'],
        // Izin (permissions) yang diminta dari pengguna.
        // Contoh: 'email' untuk mendapatkan alamat email, 'public_profile' untuk data profil dasar.
        // Anda bisa menambahkan scope tambahan seperti 'user_friends', 'user_birthday', dsb. sesuai kebutuhan.

        // 'display'         => 'popup',
        // Menentukan mode tampilan halaman login Facebook.
        // Nilai umum: 'page' (default), 'popup', 'touch', 'wap'.
        // Uncomment baris ini jika Anda ingin menggunakan tampilan popup.

        // 'locale'          => 'en_US',
        // Menentukan bahasa yang digunakan pada halaman login.
        // Contoh: 'en_US' untuk Bahasa Inggris Amerika, 'id_ID' untuk Bahasa Indonesia.

        // 'auth_type'       => 'rerequest',
        // Digunakan untuk mengatur tipe autentikasi tambahan:
        // 'rerequest' memaksa permintaan ulang izin jika pengguna sebelumnya menolak.
        // 'reauthenticate' memaksa pengguna untuk login ulang.
        // Uncomment dan atur nilai ini jika diperlukan.

        /*
     * ------------------------------
     *  Parameter Tambahan (Optional via with())
     * ------------------------------
     *
     * Anda juga dapat menambahkan parameter kustom tambahan ketika memanggil driver Facebook
     * menggunakan method with(), misalnya:
     *
     * return Socialite::driver('facebook')
     *     ->with(['display' => 'popup', 'locale' => 'en_US'])
     *     ->redirect();
     *
     * Parameter tambahan lainnya yang didukung oleh Facebook juga dapat ditambahkan jika diperlukan.
     */
    ],

    'github' => [
        /*
     * ---------------------------------------------------------------------
     * Mandatory Parameters
     * ---------------------------------------------------------------------
     */

        // Client ID dari GitHub
        // Diperoleh dari GitHub Developer Settings, merupakan identifikasi unik aplikasi Anda.
        'client_id'     => env('GITHUB_CLIENT_ID'),

        // Client Secret dari GitHub
        // Kunci rahasia aplikasi, digunakan untuk verifikasi dan penukaran kode otorisasi dengan token.
        'client_secret' => env('GITHUB_CLIENT_SECRET'),

        // Redirect URI (Callback URL)
        // URL ini adalah tempat GitHub akan mengarahkan kembali pengguna setelah proses otentikasi.
        // Pastikan URL ini terdaftar di Authorized Redirect URIs pada pengaturan aplikasi GitHub.
        'redirect'      => env('GITHUB_REDIRECT_URI'),

        /*
     * ---------------------------------------------------------------------
     * Optional Parameters
     * ---------------------------------------------------------------------
     */

        // Scopes
        // Menentukan izin (permissions) yang diminta dari pengguna.
        // Contoh umum:
        // - 'read:user' untuk mengakses data profil publik.
        // - 'user:email' untuk mendapatkan alamat email.
        // Anda dapat menambahkan scope tambahan sesuai kebutuhan.
        'scopes'        => ['read:user', 'user:email'],

        // State
        // Digunakan untuk mencegah serangan CSRF (Cross-Site Request Forgery).
        // Anda bisa menyetel nilai statis di sini atau menghasilkannya secara dinamis di controller.
        'state'         => env('GITHUB_OAUTH_STATE', null),

        // Stateless
        // Menentukan apakah alur OAuth dilakukan tanpa menyimpan state (misalnya, untuk API atau aplikasi mobile).
        // Jika diset ke true, Socialite tidak akan menyimpan state di session.
        'stateless'     => true,

        /*
     * ---------------------------------------------------------------------
     * Additional Custom Parameters (for reference)
     * ---------------------------------------------------------------------
     *
     * Parameter tambahan biasanya tidak disetel langsung di config, melainkan
     * dikirim secara dinamis melalui method ->with() di controller.
     *
     * Misalnya, jika Anda ingin mencegah signup baru via GitHub, Anda bisa mengirim:
     *   ->with(['allow_signup' => 'false'])
     *
     * Jika ingin mengatur parameter ini secara default, Anda dapat menyimpannya di sini:
     */

        // Allow Signup
        // Mengatur apakah tampilan otorisasi GitHub mengizinkan pengguna mendaftar akun baru.
        // Nilai 'true' (default) memungkinkan signup, sedangkan 'false' menonaktifkannya.
        'allow_signup'  => env('GITHUB_ALLOW_SIGNUP', 'true'),
    ],



    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
