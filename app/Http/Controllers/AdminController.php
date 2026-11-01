<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAppAccess;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Ambil semua user beserta akses aplikasinya.
     */
    public function index()
    {
        $users = User::with('appAccesses')->get();
        
        // Format data agar mudah dibaca frontend
        $formattedUsers = $users->map(function($user) {
            // Ubah relasi menjadi array objek { slug, role }
            $appsWithRoles = $user->appAccesses->map(function($access) {
                return [
                    'slug' => $access->app_slug,
                    'role' => $access->role_in_app
                ];
            })->toArray();

            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'nip' => $user->nip,
                'role' => $user->role,
                'apps' => $appsWithRoles,
            ];
        });

        return response()->json(['success' => true, 'data' => $formattedUsers]);
    }

    /**
     * Simpan/Update akses aplikasi (beserta role) untuk user tertentu.
     */
    public function updateAccess(Request $request, $id)
    {
        // Pastikan user ada
        $user = User::findOrFail($id);
        
        // Hapus semua akses lama user ini
        UserAppAccess::where('user_id', $id)->delete();

        // Simpan akses baru
        if ($request->has('apps') && is_array($request->apps)) {
            foreach ($request->apps as $appData) {
                UserAppAccess::create([
                    'user_id' => $id,
                    'app_slug' => $appData['slug'],
                    'role_in_app' => $appData['role'] ?? 'user', // Default role jika kosong
                ]);
            }
        }

        return response()->json([
            'success' => true, 
            'message' => 'Hak akses berhasil diperbarui.'
        ]);
    }
}