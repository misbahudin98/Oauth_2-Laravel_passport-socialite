<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

Route::get('/user', function () {
    return User::all()->toJson();
})->middleware("auth:api");

Route::post('refresh', function (Request $request) {
    $request->validate([
        'refresh_token' => 'required|string',
        "scoope" => 'sometimes|string'
    ]);

    $response = Http::asForm()->post(url('/oauth/token'), [
        'grant_type' => 'refresh_token',
        'client_id' => '1',
        'refresh_token' => $request->refresh_token,
        'scope'         => $request->input('scope', ''), // gunakan scope jika ada, atau default ''

    ]);
    if ($response->successful()) {
        $data = $response->json();
        // Tambahkan expires_in ke array data
        $data['expires_in'] = env("PASSPORT_REFRESH") * 60;
        
        // Periksa jika ada error dalam respons
        if (isset($data['error'])) {
            return response()->json(['message' => $data['error_description']], 401);
        }
        
        return response()->json($data);
    }
    

    // Jika tidak berhasil, periksa kode status
    switch ($response->status()) {
        case 400:
            return response()->json(['message' => 'Permintaan tidak valid. Periksa kembali username atau password anda.'], 400);
        case 401:
            return response()->json(['message' => 'Hak akses tidak valid.'], 401);
        case 403:
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengakses.'], 403);
        case 500:
            return response()->json(['message' => 'Terjadi kesalahan pada server.'], 500);
        default:
            return response()->json(['message' => 'Terjadi kesalahan yang tidak diketahui.'], 500);
    }
});


Route::delete('logout', function (Request $request) {
    $token = $request->user()->token();
    if ($token) {
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        // Revoke an access token...
        $tokenRepository->revokeAccessToken($token->id);

        // Revoke all of the token's refresh tokens...
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);

        return response()->json(['message' => 'Token revoked successfully']);
    }
})->middleware("auth:api");
