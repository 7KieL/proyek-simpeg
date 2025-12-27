<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('slip_gajis', function (Blueprint $table) {
        // Menambahkan kolom tunjangan_lain setelah gaji_pokok
        $table->bigInteger('tunjangan_lain')->default(0)->after('gaji_pokok');
    });
}

public function down()
{
    Schema::table('slip_gajis', function (Blueprint $table) {
        $table->dropColumn('tunjangan_lain');
    });
}
};
