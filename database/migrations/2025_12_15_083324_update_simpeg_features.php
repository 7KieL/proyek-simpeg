<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <--- INI YANG TADI KURANG

return new class extends Migration
{
    public function up()
    {
        // 1. Tambah Gaji Pokok di User (Master Gaji)
        if (!Schema::hasColumn('users', 'gaji_pokok')) {
            Schema::table('users', function (Blueprint $table) {
                $table->bigInteger('gaji_pokok')->default(0)->after('email');
            });
        }

        // 2. Tambah Keterangan di Absensi (Terlambat/Tepat Waktu)
        if (!Schema::hasColumn('absensis', 'keterangan')) {
            Schema::table('absensis', function (Blueprint $table) {
                $table->string('keterangan')->nullable()->after('status');
            });
        }

        // 3. Buat Tabel Konfigurasi (Untuk Koordinat Kantor Dinamis)
        if (!Schema::hasTable('config_kantor')) {
            Schema::create('config_kantor', function (Blueprint $table) {
                $table->id();
                $table->string('latitude');
                $table->string('longitude');
                $table->integer('radius_km')->default(200); 
                $table->time('jam_masuk')->default('08:00:00'); 
                $table->timestamps();
            });

            // 4. Isi Data Awal Kantor
            DB::table('config_kantor')->insert([
                'latitude' => '-6.986152703451534',
                'longitude' => '107.63636582058076',
                'radius_km' => 200,
                'jam_masuk' => '08:00:00'
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('config_kantor');
        
        if (Schema::hasColumn('users', 'gaji_pokok')) {
            Schema::table('users', function (Blueprint $table) { $table->dropColumn('gaji_pokok'); });
        }
        
        if (Schema::hasColumn('absensis', 'keterangan')) {
            Schema::table('absensis', function (Blueprint $table) { $table->dropColumn('keterangan'); });
        }
    }
};