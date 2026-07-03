<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('kamar', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_kamar')->unique();
        // Foreign key (aman karena tipe_kamar sudah dibuat duluan)
        $table->foreignId('id_tipe_kamar')->nullable()->constrained('tipe_kamar')->nullOnDelete();
        $table->enum('status', ['tersedia', 'dibersihkan', 'rusak', 'terisi'])->default('tersedia');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};