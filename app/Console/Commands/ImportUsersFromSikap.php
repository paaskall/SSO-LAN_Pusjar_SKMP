<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImportUsersFromSikap extends Command
{
    /**
     * Nama command yang dipanggil di terminal.
     */
    protected $signature = 'sso:import-sikap';

    /**
     * Deskripsi command.
     */
    protected $description = 'Import users dari database SIKAP ke SSO Server';

    /**
     * Jalankan command.
     */
    public function handle()
    {
        $this->info('🚀 Mulai import user dari SIKAP...');
        $this->newLine();

        // ============================================
        // 1. Ambil semua user dari database SIKAP
        // ============================================
        try {
            $sikapUsers = DB::connection('sikap')->table('users')->get();
        } catch (\Exception $e) {
            $this->error('❌ Gagal konek ke database SIKAP: ' . $e->getMessage());
            return 1;
        }

        if ($sikapUsers->isEmpty()) {
            $this->warn('⚠️  Tidak ada user di database SIKAP.');
            return 0;
        }

        $this->info("Ditemukan {$sikapUsers->count()} user di SIKAP.");
        $this->newLine();

        // ============================================
        // 2. Loop & import satu per satu
        // ============================================
        $imported = 0;
        $updated  = 0;
        $skipped  = 0;

        foreach ($sikapUsers as $sikapUser) {
            // Skip kalau username kosong (SSO butuh username)
            if (empty($sikapUser->username)) {
                $this->warn("⏭️  Skip: user tanpa username (ID SIKAP: {$sikapUser->id})");
                $skipped++;
                continue;
            }

            // Cek user sudah ada di SSO Server atau belum
            // Prioritas cek: username dulu, baru email
            $existing = User::where('username', $sikapUser->username)->first();

            if (!$existing && !empty($sikapUser->email)) {
                $existing = User::where('email', $sikapUser->email)->first();
            }

            if ($existing) {
                // ============================================
                // Update user yang sudah ada
                // ============================================
                $existing->update([
                    'name'     => $sikapUser->name     ?? $existing->name,
                    'email'    => $sikapUser->email    ?? $existing->email,
                    'password' => $sikapUser->password, // copy hash langsung
                ]);

                $updated++;
                $this->line("🔄 Update: {$sikapUser->username} ({$sikapUser->name})");
                continue;
            }

            // ============================================
            // Buat user baru di SSO Server
            // ============================================
            User::create([
                'name'     => $sikapUser->name     ?? 'User',
                'username' => $sikapUser->username,
                'email'    => $sikapUser->email    ?? null,
                'nip'      => $sikapUser->nip      ?? null,
                'nik'      => $sikapUser->nik      ?? null,
                'password' => $sikapUser->password, // copy hash langsung dari SIKAP
            ]);

            $imported++;
            $this->info("✅ Import: {$sikapUser->username} ({$sikapUser->name})");
        }

        // ============================================
        // 3. Ringkasan
        // ============================================
        $this->newLine();
        $this->info('🎉 Selesai!');
        $this->table(
            ['Status', 'Jumlah'],
            [
                ['✅ Diimport baru', $imported],
                ['🔄 Diupdate',       $updated],
                ['⏭️  Dilewati',      $skipped],
                ['📊 Total diproses', $sikapUsers->count()],
            ]
        );

        return 0;
    }
}