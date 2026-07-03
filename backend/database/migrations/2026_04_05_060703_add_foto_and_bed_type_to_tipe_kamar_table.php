<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tipe_kamar', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('nama');
            $table->enum('tipe_tempat_tidur', ['King', 'Queen', 'Twin', 'Single', 'Double', 'Suite'])->nullable();
            $table->boolean('tersedia')->default(true)->after('tipe_tempat_tidur');
        });
    }

    public function down(): void
    {
        Schema::table('tipe_kamar', function (Blueprint $table) {
            $table->dropColumn(['foto', 'tipe_tempat_tidur', 'tersedia']);
        });
    }
};