<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    // 1. Tampilkan Daftar Izin
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $izins = Izin::with('user')->latest()->get();
        } else {
            $izins = Izin::with('user')->where('user_id', Auth::id())->latest()->get();
        }
        
        return view('izin.index', compact('izins'));
    }

    // 2. Form Pengajuan (Khusus Karyawan)
    public function create()
    {
        return view('izin.create');
    }

    // 3. Simpan Pengajuan
    public function store(Request $request)
    {
        $request->validate([
            'jenis_izin'      => 'required',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan'      => 'required', // Ini validasi INPUT dari Form (name="keterangan")
            'file_surat'      => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // A. Proses Upload File
        $filePath = null;
        if ($request->hasFile('file_surat')) {
            $filePath = $request->file('file_surat')->store('izin_docs', 'public');
        }

        // B. Simpan ke Database
        Izin::create([
            'user_id'         => Auth::id(),
            'jenis_izin'      => $request->jenis_izin,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            
            // --- BAGIAN INI YANG DIPERBAIKI ---
            // Input dari form bernama 'keterangan', disimpan ke kolom DB bernama 'alasan'
            'alasan'          => $request->keterangan, 
            // ----------------------------------

            'status'          => 'Pending',
            'file_surat'      => $filePath
        ]);

        return redirect()->route('izin.index')->with('success', 'Pengajuan berhasil dikirim. Menunggu persetujuan Admin.');
    }

    // 4. Update Status (Admin)
    public function update(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak'
        ]);

        $izin->update([
            'status' => $request->status
        ]);

        $pesan = $request->status == 'Disetujui' 
            ? 'Izin telah DISETUJUI ✅' 
            : 'Izin telah DITOLAK ❌';

        return redirect()->back()->with('success', $pesan);
    }
}