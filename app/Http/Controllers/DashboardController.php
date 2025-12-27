<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// --- 1. JANGAN LUPA IMPORT MODEL INI ---
use App\Models\User;
use App\Models\Absensi;
use App\Models\Izin;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Cek Role
        if ($user->role === 'admin') {
            
            // --- 2. LOGIKA WIDGET ADMIN (Hitung Data) ---
            $total_karyawan = User::where('role', 'karyawan')->count();
            $hadir_hari_ini = Absensi::where('tanggal', date('Y-m-d'))->count();
            $izin_pending   = Izin::where('status', 'Pending')->count();

            // Kirim variabel ke view admin menggunakan compact
            return view('dashboard.admin', compact('total_karyawan', 'hadir_hari_ini', 'izin_pending'));
            
        } else {
            return view('dashboard.karyawan'); // Tampilan khusus karyawan
        }
    }
}