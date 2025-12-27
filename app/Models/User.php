<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Penting: agar kolom role bisa diisi
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi: User (Karyawan) punya satu data detail Karyawan
    public function detailKaryawan()
    {
        return $this->hasOne(Karyawan::class);
    }

    // Relasi: User punya banyak history absensi
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}