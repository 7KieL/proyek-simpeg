<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('izins', function (Blueprint $table) {
            // PERBAIKAN: Ubah after('keterangan') menjadi after('alasan')
            // Karena di database Anda nama kolomnya 'alasan', bukan 'keterangan'
            $table->string('file_surat')->nullable()->after('alasan'); 
        });
    }

    public function down()
    {
        Schema::table('izins', function (Blueprint $table) {
            $table->dropColumn('file_surat');
        });
    }
};