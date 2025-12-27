<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $guarded = []; // Mengizinkan semua kolom diisi

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}