<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->string('type');
            $table->unsignedBigInteger('user_id')->nullable(); // ID resepsionis yang daftar
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('status')->default('unread'); // unread, read
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};