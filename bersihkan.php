<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

echo "=== MEMBERSIHKAN SSO SERVER ===\n";

// 1. Revoke semua token OAuth (memaksa semua user login ulang)
DB::table('oauth_access_tokens')->update(['revoked' => 1]);
echo "✅ Token OAuth lama dicabut.\n";

// 2. Hapus semua sesi
DB::table('sessions')->delete();
echo "✅ Sesi database dihapus.\n";

// 3. Bersihkan cache Laravel
Cache::flush();
Artisan::call('optimize:clear');
echo "✅ Cache Laravel dibersihkan.\n";

echo "=== SELESAI ===\n";
