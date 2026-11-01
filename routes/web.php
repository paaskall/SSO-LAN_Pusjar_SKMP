<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SsoController;
use Illuminate\Http\Request;

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

// Route Halaman Manajemen User (Super Admin)
Route::get('/admin/users', function () {
    return view('admin.users');
})->name('admin.users');

// Route Jembatan Logout SSO
Route::get('/sso-logout', function () {
    return view('auth.logout');
})->name('sso.logout');

/**
 * Route SSO Launch
 * Terima app slug + token, redirect ke aplikasi klien.
 */
Route::get('/sso/launch/{app}', function (Request $request, $app) {
    $apps = [
        'keuangan' => 'http://127.0.0.1:8000/sso/callback', // SIKAP
        'siperdi'  => 'http://127.0.0.1:8001/sso/callback', // SIPERDI
    ];

    if (!isset($apps[$app])) {
        abort(404, 'Aplikasi tidak ditemukan atau belum terintegrasi.');
    }

    $token = $request->query('token');

    if (!$token) {
        abort(400, 'Token SSO tidak ditemukan.');
    }

    // === VALIDASI KEAMANAN ===
    // Cek apakah token ini valid dan punya akses ke aplikasi tersebut
    // Kita tidak bisa memvalidasi via Auth::user() di web route karena pakai token (API)
    // Tapi kita bisa mencegah user iseng yang belum login SSO.
    
    // (Untuk production, validasi token ke Passport di sini. Untuk prototype, kita andalkan frontend).
    // Anda bisa menambahkan pengecekan via cURL ke /api/user di sini jika mau lebih aman.

    return redirect($apps[$app] . '?token=' . urlencode($token));
});