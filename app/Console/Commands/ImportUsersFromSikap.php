<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
            $existing = User::where('username', $sikapUser->username)->first();

            if (!$existing && !empty($sikapUser->email)) {
                $existing = User::where('email', $sikapUser->email)->first();
            }

            if ($existing) {
                // Update data termasuk password
                $existing->update([
                    'name'     => $sikapUser->name     ?? $existing->name,
                    'email'    => $sikapUser->email    ?? $existing->email,
                    // Sinkronkan password SIKAP ke SSO
                    'password' => $sikapUser->password, 
                ]);

                $updated++;
                $this->line("🔄 Update: {$sikapUser->username} ({$sikapUser->name})");
                continue;
            }

            // Buat user baru di SSO Server
            User::create([
                'name'     => $sikapUser->name     ?? 'User',
                'username' => $sikapUser->username,
                'email'    => $sikapUser->email    ?? null,
                // Cek apakah tabel SIKAP punya kolom nip/nik sebelum mengambilnya
                'nip'      => property_exists($sikapUser, 'nip') ? $sikapUser->nip : null,
                'nik'      => property_exists($sikapUser, 'nik') ? $sikapUser->nik : null,
                'password' => $sikapUser->password, 
            ]);

            $imported++;
            $this->info("✅ Import: {$sikapUser->username} ({$sikapUser->name})");
        }

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