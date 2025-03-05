<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
// use InvalidArgumentException; // pastikan diimport




// Route untuk menampilkan halaman login
Route::get('/auth/login', function () {
    return view('auth.login');
})->name('login');

// Route untuk proses login
Route::post('/auth/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => 'required',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        // $request->session()->regenerate();

        // dd($request->all());
        // Regenerate session ID untuk keamanan
        return redirect()->intended('/auth/redirect');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah',
    ]);
})->name('login.submit');

Route::prefix('auth')->middleware(['auth'])->group(function () {
    // Endpoint inisiasi: simpan state dan code_verifier, lalu redirect ke Passport authorization endpoint
    Route::get('/redirect', function (Request $request) {
        // Simpan nilai state dan code_verifier ke session (disimpan di database atau storage session lain)
        $state = Str::random(10);
        $codeVerifier = Str::random(128);
        $request->session()->put('state', $state);
        $request->session()->put('code_verifier', $codeVerifier);

        // Buat code_challenge dari code_verifier
        $codeChallenge = strtr(
            rtrim(base64_encode(hash('sha256', $codeVerifier, true)), '='),
            '+/',
            '-_'
        );

        // Siapkan parameter query untuk redirect ke /oauth/authorize
        $query = http_build_query([
            'client_id'             => '1',
            'redirect_uri'          => 'http://fe.org/callback.php', // Callback URL di FE.org
            'response_type'         => 'code',
            'scope'                 => '', // sesuaikan scope jika perlu
            'state'                 => $state,
            'code_challenge'        => $codeChallenge,
            'code_challenge_method' => 'S256',
            'prompt'                => 'consent', // Memaksa login, bisa diubah jika tidak diinginkan
        ]);

        return redirect(url('/oauth/authorize?' . $query));
    })->name('redirect');

    // Endpoint callback: menukarkan authorization code dengan token
    Route::get('/callback', function (Request $request) {
        // Ambil nilai state dan code_verifier yang disimpan di session
        $storedState = $request->session()->pull("state");
        $codeVerifier = $request->session()->pull("code_verifier");
        Log::info($storedState . "  |=|     " . $request->state . "   0-0     " . $codeVerifier . "  |=|     " . $request->code);

        // Validasi state untuk mencegah CSRF
        throw_unless(
            strlen($storedState) > 0 && $storedState === $request->state,
            \InvalidArgumentException::class,
            'Invalid state value.'
        );

        // Tukar authorization code dengan token dari endpoint OAuth token
        $response = Http::asForm()->post(url('/oauth/token'), [
            'grant_type'    => 'authorization_code',
            'client_id'     => '1',
            'redirect_uri'  => 'http://fe.org/callback.php',
            'code_verifier' => $codeVerifier,
            'code'          => $request->code, // gunakan authorization code yang benar
        ]);
        // return $response;
        // Jika terjadi error pada response token, tangani dengan mengembalikan error message
        if (!$response->successful()) {
            // dd($response);
            return response()->json(['error' => 'Token exchange failed'], $response->status());
        }

        $response = $response->json();
        // protected string $name,
        // protected ?string $value = null,
        // int|string|\DateTimeInterface $expire = 0,
        // ?string $path = '/',
        // protected ?string $domain = null,
        // protected ?bool $secure = null,
        // protected bool $httpOnly = true,
        // private bool $raw = false,
        // ?string $sameSite = self::SAMESITE_LAX,
        // private bool $partitioned = false,
        // return $response;
        $accessToken  = rawurldecode($response['access_token']);
        $refreshToken = rawurldecode($response['refresh_token']);
        $expiresIn    = env("PASSPORT_REFRESH") * 60 ; // second

        // Redirect ke FE dengan parameter token yang sudah "mentah"
        return redirect("http://fe.org/callback.php?access_token={$accessToken}&refresh_token={$refreshToken}&expires_in={$expiresIn}");
    })->name('callback');
});

Route::get('/callback', function () {
    $code = $_GET['code'];
    $state = $_GET['state'];
    return redirect("http://laravel.org/auth/callback?code={$code}&state={$state}");
});

Route::get("/data", function (Request $request) {
    return view("api.users");
});
