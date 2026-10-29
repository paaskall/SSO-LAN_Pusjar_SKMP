<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportUsersFromSiperdi extends Command
{
    protected $signature = 'sso:import-siperdi';
    protected $description = 'Import users dari database SIPERDI ke SSO Server';

    public function handle()
    {
        $this->info('🚀 Mulai import user dari SIPERDI...');
        $this->newLine();

        try {
            $siperdiUsers = DB::connection('siperdi')->table('users')->get();
        } catch (\Exception $e) {
            $this->error('❌ Gagal konek ke database SIPERDI: ' . $e->getMessage());
            return 1;
        }

        $imported = 0;
        $updated  = 0;

        foreach ($siperdiUsers as $u) {
            // Cari user di SSO berdasarkan username atau NIP
            $existing = User::where('username', $u->username)
                            ->orWhere('nip', $u->nip)
                            ->first();

            if ($existing) {
                // Update data jika sudah ada (termasuk password)
                $existing->update([
                    'name'     => $u->name,
                    'nip'      => $u->nip,
                    'email'    => $u->email,
                    // Sinkronkan password SIPERDI ke SSO
                    'password' => $u->password, 
                ]);
                $updated++;
                $this->line("🔄 Update: {$u->username} ({$u->name})");
            } else {
                // Buat user baru di SSO
                User::create([
                    'name'     => $u->name,
                    'username' => $u->username,
                    'nip'      => $u->nip,
                    'email'    => $u->email,
                    'password' => $u->password, 
                ]);
                $imported++;
                $this->info("✅ Import: {$u->username} ({$u->name})");
            }
        }

        $this->info("🎉 Selesai! Diimport: {$imported}, Diupdate: {$updated}");
        return 0;
    }
}