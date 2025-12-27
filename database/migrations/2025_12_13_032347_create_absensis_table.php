<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal')->index();
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->enum('status', ['Hadir', 'Terlambat', 'Alpha', 'Izin'])->default('Alpha');
            $table->timestamps();

            $table->unique(['user_id', 'tanggal']); // Absensi hanya sekali per hari per karyawan
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};