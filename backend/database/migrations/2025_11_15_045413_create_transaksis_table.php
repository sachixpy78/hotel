<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pembelian');
            $table->string('total_harga');
            $table->foreignId('fid_admin')->constrained('admin')->onDelete('cascade');
            $table->foreignId('fid_produk')->constrained('produk')->onDelete('cascade');
            $table->string('detail')->nullable();
            $table->string('total_keuntungan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
