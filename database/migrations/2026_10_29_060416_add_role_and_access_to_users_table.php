<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom role di tabel users (default: user)
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('nik'); 
        });

        // 2. Buat tabel pivot untuk menyimpan akses aplikasi
        Schema::create('user_app_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('app_slug'); // contoh: 'keuangan', 'siperdi'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_app_access');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};