<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_app_access', function (Blueprint $table) {
            // Menyimpan role user di aplikasi tujuan (misal: admin, pimpinan, pegawai)
            $table->string('role_in_app')->nullable()->after('app_slug');
        });
    }

    public function down(): void
    {
        Schema::table('user_app_access', function (Blueprint $table) {
            $table->dropColumn('role_in_app');
        });
    }
};