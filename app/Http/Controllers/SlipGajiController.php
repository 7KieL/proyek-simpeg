<?php

namespace App\Http\Controllers;

use App\Models\SlipGaji;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth; 

class SlipGajiController extends Controller
{
    // 1. Tampilkan History Gaji
    public function index()
    {
        $gajis = SlipGaji::with('user')->latest()->get();
        return view('gaji.index', compact('gajis'));
    }

    // 2. Form Buat Gaji Baru
    public function create()
    {
        // Ambil hanya user yang role-nya karyawan
        $users = User::where('role', 'karyawan')->get();
        return view('gaji.create', compact('users'));
    }

    // 3. Hitung dan Simpan
   public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'bulan' => 'required',
            'gaji_pokok' => 'required|numeric',
            // 'tunjangan' dan 'potongan' opsional, jadi tidak perlu required
        ]);

        // Ambil data input (kalau kosong dianggap 0)
        $gaji_pokok = $request->gaji_pokok;
        $tunjangan  = $request->tunjangan ?? 0; // <--- BARU
        $potongan   = $request->potongan ?? 0;

        // Rumus Baru: (Gaji Pokok + Tunjangan) - Potongan
        $total = ($gaji_pokok + $tunjangan) - $potongan;

        SlipGaji::create([
            'user_id'       => $request->user_id,
            'bulan_tahun'   => $request->bulan,
            'gaji_pokok'    => $gaji_pokok,
            'tunjangan_lain'=> $tunjangan, // <--- SIMPAN KE DATABASE
            'potongan_lain' => $potongan,
            'total_gaji'    => $total
        ]);

        return redirect()->route('gaji.index')->with('success', 'Slip Gaji Berhasil Dibuat!');
    }

    // 4. DOWNLOAD PDF (FUNGSI BARU)
    public function cetak($id)
    {
        // Cari data slip gaji berdasarkan ID
        $gaji = SlipGaji::with('user')->findOrFail($id);

        // Load tampilan PDF dari file resources/views/gaji/cetak.blade.php
        $pdf = Pdf::loadView('gaji.cetak', compact('gaji'));

        // Atur ukuran kertas dan orientasi (Opsional)
        $pdf->setPaper('A4', 'portrait');

        // Download file dengan nama otomatis
        // Contoh: Slip-Gaji-Budi-Desember-2025.pdf
        $nama_file = 'Slip-Gaji-' . str_replace(' ', '-', $gaji->user->name) . '-' . $gaji->bulan_tahun . '.pdf';
        
        return $pdf->download($nama_file);
    }

    // --- FITUR KARYAWAN: LIHAT GAJI SENDIRI ---
    public function indexKaryawan()
    {
        // Ambil data gaji diman user_id = id user yang login
        $gajis = SlipGaji::where('user_id', Auth::id())
                         ->latest()
                         ->get();

        return view('gaji.pribadi', compact('gajis'));
    }
}