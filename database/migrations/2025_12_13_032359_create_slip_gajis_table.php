<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slip_gajis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('bulan_tahun'); // Misal: '2025-12'
            $table->decimal('gaji_pokok', 15, 2);
            $table->decimal('potongan_izin', 15, 2)->default(0);
            $table->decimal('potongan_lain', 15, 2)->default(0);
            $table->decimal('total_gaji', 15, 2);
            $table->timestamps();
            
            $table->unique(['user_id', 'bulan_tahun']); // Satu slip gaji per karyawan per bulan
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slip_gajis');
    }
};