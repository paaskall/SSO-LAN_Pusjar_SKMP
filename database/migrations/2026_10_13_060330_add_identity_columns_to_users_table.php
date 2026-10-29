<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom identitas
            $table->string('username')->unique()->nullable()->after('name');
            $table->string('nip', 30)->unique()->nullable()->after('email');
            $table->string('nik', 30)->unique()->nullable()->after('nip');
            
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'nip', 'nik']);
        });
    }
};