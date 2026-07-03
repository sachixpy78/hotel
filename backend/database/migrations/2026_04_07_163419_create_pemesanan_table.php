<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pemesanan')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tipe_kamar_id');
            $table->integer('jumlah_kamar')->default(1);
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('jumlah_malam');
            $table->decimal('harga_per_malam', 12, 2);
            $table->decimal('total_harga', 12, 2);
            $table->enum('status', ['baru', 'menunggu_pembayaran', 'menunggu_verifikasi', 'dibayar', 'check_in', 'check_out', 'batal'])->default('baru');
            $table->enum('metode_pembayaran', ['transfer', 'tunai'])->nullable();
            $table->string('bukti_transfer')->nullable();
                $table->string('qr_code_path')->nullable()->after('bukti_transfer');
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('admin')->onDelete('cascade');
            $table->foreign('tipe_kamar_id')->references('id')->on('tipe_kamar');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemesanan');
    }
};