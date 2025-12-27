<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('absensis', function (Blueprint $table) {
        $table->double('latitude')->nullable()->after('jam_masuk');
        $table->double('longitude')->nullable()->after('latitude');
    });
}

public function down()
{
    Schema::table('absensis', function (Blueprint $table) {
        $table->dropColumn(['latitude', 'longitude']);
    });
}
};
