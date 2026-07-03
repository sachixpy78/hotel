<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            if (!Schema::hasColumn('pemesanan', 'verified_by')) {
                $table->integer('verified_by')->nullable()->after('jam_terlambat');
            }
            if (!Schema::hasColumn('pemesanan', 'jam_terlambat')) {
                $table->integer('jam_terlambat')->default(0)->after('denda_keterlambatan');
            }
        });
    }

    public function down()
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn(['verified_by', 'jam_terlambat']);
        });
    }
};