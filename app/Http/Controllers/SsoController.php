<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SsoController extends Controller
{
    private string $ssoServerUrl = 'http://127.0.0.1:8002';

    public function callback(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Token SSO tidak ditemukan.');
        }

        try {
            // 1. Verifikasi token ke SSO Server
            $response = Http::timeout(10)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ])
                ->get($this->ssoServerUrl . '/api/user');

            if (!$response->successful()) {
                return redirect()->route('login')->with('error', 'Token SSO tidak valid atau kadaluarsa.');
            }

            $data = $response->json();
            if (!isset($data['user'])) {
                return redirect()->route('login')->with('error', 'Data user tidak lengkap dari SSO.');
            }

            $ssoUser = $data['user'];

            // ========================================================
            // EKSTRAK ROLE DARI SSO UNTUK SIPERDI (BLOK BARU)
            // ========================================================
            $roleFromSso = 'pegawai'; // Default role jika tidak ada di SSO
            if (isset($ssoUser['apps']) && is_array($ssoUser['apps'])) {
                foreach ($ssoUser['apps'] as $app) {
                    if (isset($app['slug']) && $app['slug'] === 'siperdi') {
                        $roleFromSso = $app['role'] ?? 'pegawai';
                        break;
                    }
                }
            }

            // Jika Super Admin di SSO, paksa jadi Pimpinan di SIPERDI
            if (isset($ssoUser['role']) && $ssoUser['role'] === 'super_admin') {
                $roleFromSso = 'pimpinan'; 
            }

            // 2. Cari user di SIPERDI
            $user = User::where('sso_id', (string) $ssoUser['id'])->first();

            if (!$user && !empty($ssoUser['email'])) {
                $user = User::where('email', $ssoUser['email'])->first();
            }
            if (!$user && !empty($ssoUser['username'])) {
                $user = User::where('username', $ssoUser['username'])->first();
            }

            // ========================================================
            // AUTO-REGISTER & SINKRONISASI ROLE
            // ========================================================
            if ($user) {
                // Update sso_id jika kosong
                if (empty($user->sso_id)) {
                    $user->update(['sso_id' => (string) $ssoUser['id']]);
                }
                
                // Update role menggunakan Spatie (hapus role lama, ganti baru)
                $user->syncRoles([$roleFromSso]);

            } else {
                // Buat user baru jika belum ada
                $username = $ssoUser['username'] ?? explode('@', $ssoUser['email'] ?? 'user')[0] . $ssoUser['id'];
                $nip = $ssoUser['nip'] ?? '999' . str_pad($ssoUser['id'], 12, '0', STR_PAD_LEFT);
                $email = $ssoUser['email'] ?? $username . '@sso.local';

                $user = User::create([
                    'name'          => $ssoUser['name'] ?? 'User SSO',
                    'sso_id'        => (string) $ssoUser['id'],
                    'auth_provider' => 'sso',
                    'nip'           => $nip,
                    'username'      => $username,
                    'email'         => $email,
                    'password'      => null,
                    'aktif'         => 1,
                    'divisi_id'     => 1, 
                    'jabatan_id'    => 1,
                    'golongan_id'   => 1,
                ]);

                // Assign role untuk user baru
                $user->assignRole($roleFromSso);

                Log::info('SSO SIPERDI: User baru didaftarkan', [
                    'sso_id' => $ssoUser['id'],
                    'role' => $roleFromSso
                ]);
            }

            // ========================================================
            // BERSIHKAN SESI LAMA & LOGIN BARU
            // ========================================================
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Auth::login($user, true);
            $request->session()->regenerate();

            // Redirect ke dashboard SIPERDI (semua role masuk ke sini)
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            Log::error('SSO SIPERDI Callback Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Terjadi kesalahan sistem saat verifikasi SSO.');
        }
    }
}