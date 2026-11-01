<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $login = trim($request->login);
        $password = $request->password;
        $field = $this->detectIdentifierType($login);

        if (!Auth::attempt([$field => $login, 'password' => $password])) {
            return response()->json([
                'success' => false,
                'message' => 'Kredensial salah. Periksa kembali.'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('SSO-Token')->accessToken;

        // Ambil daftar akses aplikasi beserta role-nya
        $userApps = $user->role === 'super_admin' 
            ? [
                ['slug' => 'keuangan', 'role' => 'admin_keuangan'],
                ['slug' => 'siperdi', 'role' => 'pimpinan'],
                ['slug' => 'sdm', 'role' => 'admin'],
                ['slug' => 'latjar', 'role' => 'admin'],
                ['slug' => 'corpu', 'role' => 'admin'],
                ['slug' => 'kajian', 'role' => 'admin'],
              ]
            : $user->appAccesses->map(function($access) {
                return [
                    'slug' => $access->app_slug,
                    'role' => $access->role_in_app
                ];
            })->toArray();

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'nip' => $user->nip,
                'nik' => $user->nik,
                'role' => $user->role,
                'apps' => $userApps, // Array of objects {slug, role}
            ],
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    private function detectIdentifierType(string $input): string
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }
        if (ctype_digit($input)) {
            $length = strlen($input);
            if ($length === 16) {
                return 'nik';
            }
            if ($length >= 8 && $length <= 20) {
                return 'nip';
            }
        }
        return 'username';
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('SSO-Token')->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil.',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function user(Request $request)
    {
        $user = $request->user();
        
        // Format akses aplikasi
        $userApps = $user->role === 'super_admin' 
            ? [
                ['slug' => 'keuangan', 'role' => 'admin_keuangan'],
                ['slug' => 'siperdi', 'role' => 'pimpinan'],
                ['slug' => 'sdm', 'role' => 'admin'],
                ['slug' => 'latjar', 'role' => 'admin'],
                ['slug' => 'corpu', 'role' => 'admin'],
                ['slug' => 'kajian', 'role' => 'admin'],
              ]
            : $user->appAccesses->map(function($access) {
                return [
                    'slug' => $access->app_slug,
                    'role' => $access->role_in_app
                ];
            })->toArray();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'nip' => $user->nip,
                'nik' => $user->nik,
                'role' => $user->role,
                'apps' => $userApps, // <-- INI KUNCINYA
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.'
        ]);
    }
}