<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('username');
            $table->string('password'); // HASH
            $table->string('gambar')->nullable();
            $table->enum('level', ['super_admin','kasir']);
            $table->enum('status', ['on','off','blokir'])->default('on');
            $table->integer('login_attempts')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin');
    }
};
