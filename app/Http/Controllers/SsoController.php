<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class SsoController extends Controller
{
    /**
     * URL SSO Server (SUDAH DIPERBAIKI KE PORT 8002)
     */
    private string $ssoServerUrl = 'http://127.0.0.1:8002';

    /**
     * Terima token dari SSO Server, verifikasi, lalu login-kan user.
     */
    public function callback(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect('/login')->with('error', 'Token SSO tidak ditemukan.');
        }

        try {
            // ============================================
            // 1. Verifikasi token ke SSO Server
            // ============================================
            $response = Http::timeout(10)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ])
                ->get($this->ssoServerUrl . '/api/user');

            if (!$response->successful()) {
                Log::warning('SSO: Token tidak valid', ['status' => $response->status()]);
                return redirect('/login')->with('error', 'Token SSO tidak valid atau sudah kadaluarsa.');
            }

            $data = $response->json();

            if (!isset($data['user'])) {
                return redirect('/login')->with('error', 'Data user tidak lengkap dari SSO.');
            }

            $ssoUser = $data['user'];

            // ============================================
            // 2. Cari user di database SIKAP (fleksibel)
            // ============================================
            $user = null;

            // Coba berdasarkan email
            if (!$user && !empty($ssoUser['email'])) {
                $user = User::where('email', $ssoUser['email'])->first();
            }

            // Coba berdasarkan username (Paling utama di SIKAP karena email sering null)
            if (!$user && !empty($ssoUser['username'])) {
                $user = User::where('username', $ssoUser['username'])->first();
            }

            // Coba berdasarkan NIP (kalau SIKAP punya kolom nip)
            if (!$user && !empty($ssoUser['nip'])) {
                if (Schema::hasColumn('users', 'nip')) {
                    $user = User::where('nip', $ssoUser['nip'])->first();
                }
            }

            // Kalau tetap tidak ketemu → tolak
            if (!$user) {
                Log::warning('SSO: User tidak ditemukan di SIKAP', [
                    'email' => $ssoUser['email'] ?? null,
                    'username' => $ssoUser['username'] ?? null,
                    'nip' => $ssoUser['nip'] ?? null,
                ]);

                return redirect('/login')->with('error', 
                    'Akun Anda belum terdaftar di SIKAP. Hubungi Administrator.');
            }

            // Cek apakah user aktif (sesuai kolom 'active' di tabel SIKAP)
            if (isset($user->active) && !$user->active) {
                return redirect('/login')->with('error', 'Akun Anda di SIKAP sedang tidak aktif.');
            }

            // ============================================
            // 3. Auto-login di SIKAP
            // ============================================
            Auth::login($user, true);

            // Regenerate session biar aman (cegah session fixation)
            $request->session()->regenerate();

            Log::info('SSO: User berhasil auto-login', [
                'user_id' => $user->id,
                'role' => $user->role
            ]);

            // ============================================
            // 4. Redirect ke dashboard SIKAP SESUAI ROLE
            // ============================================
            return redirect($this->dashboardUrlFor($user));

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('SSO: Tidak bisa konek ke SSO Server', ['error' => $e->getMessage()]);
            return redirect('/login')->with('error', 'SSO Server tidak dapat dihubungi.');

        } catch (\Exception $e) {
            Log::error('SSO Callback Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect('/login')->with('error', 'Terjadi kesalahan saat verifikasi SSO.');
        }
    }

    /**
     * Tentukan URL dashboard berdasarkan role user SIKAP.
     */
    private function dashboardUrlFor(User $user): string
    {
        // Sesuaikan dengan routing role yang ada di routes/web.php SIKAP
        $role = $user->role ?? 'user';

        return match ($role) {
            'admin_keuangan' => '/admin',
            'keuangan'       => '/keuangan',
            'pimpinan'       => '/pimpinan',
            'user'           => '/viewer', 
            default          => '/viewer',
        };
    }
}