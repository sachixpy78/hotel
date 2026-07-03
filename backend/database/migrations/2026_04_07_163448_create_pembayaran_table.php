<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pemesanan_id');
            $table->decimal('jumlah', 12, 2);
            $table->enum('metode', ['transfer', 'tunai']);
            $table->string('bukti_transfer')->nullable();
            $table->enum('status', ['pending', 'verified', 'failed'])->default('pending');
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->datetime('verified_at')->nullable();
            $table->timestamps();
            
            $table->foreign('pemesanan_id')->references('id')->on('pemesanan')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('admin');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
};