<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->integer('stok');
            $table->string('modal');
            $table->string('harga_jual');
            $table->string('keuntungan')->nullable();
            $table->foreignId('fid_kategori')->constrained('kategori')->onDelete('cascade');
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('ketersediaan', ['tersedia', 'tidaktersedia']);
            $table->enum('estimasi', ['langsung_ambil', '7_hari_kerja']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
};
