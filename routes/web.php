<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SsoController;

// Route SSO Callback
Route::get('/sso/callback', [SsoController::class, 'callback'])->name('sso.callback');

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

/**
 * Route SSO Launch
 * Terima app slug + token, redirect ke aplikasi klien.
 */
Route::get('/sso/launch/{app}', function ($app) {
    // Daftar aplikasi klien & URL callback-nya
    $apps = [
        'keuangan' => 'http://127.0.0.1:8000/sso/callback',
        // 'sdm'    => 'http://127.0.0.1:8002/sso/callback',
        // 'latjar' => 'http://127.0.0.1:8003/sso/callback',
        // 'corpu'  => 'http://127.0.0.1:8004/sso/callback',
        // 'kajian' => 'http://127.0.0.1:8005/sso/callback',
    ];

    if (!isset($apps[$app])) {
        abort(404, 'Aplikasi tidak ditemukan atau belum terintegrasi.');
    }

    $token = request('token');

    if (!$token) {
        abort(400, 'Token SSO tidak ditemukan.');
    }

    return redirect($apps[$app] . '?token=' . urlencode($token));
});