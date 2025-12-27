<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    // 1. Tampilkan Daftar Karyawan
    public function index()
    {
        $data_karyawan = Karyawan::with('user')->get();
        return view('karyawan.index', compact('data_karyawan'));
    }

    // 2. Buka Form Tambah
    public function create()
    {
        return view('karyawan.create');
    }

    // 3. Simpan Data Baru (User + Karyawan)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'jabatan' => 'required',
            'no_hp' => 'required',
        ]);

        // A. Buat Akun User Dulu
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'karyawan', // Otomatis jadi karyawan
        ]);

        // B. Buat Detail Karyawan
        Karyawan::create([
            'user_id' => $user->id,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan Berhasil Ditambahkan');
    }

    // 4. Buka Form Edit
    public function edit($id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        return view('karyawan.edit', compact('karyawan'));
    }

    // 5. Update Data
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $user = $karyawan->user;

        // Update Data User (Nama & Email)
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Jika password diisi, update passwordnya
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Update Data Karyawan
        $karyawan->update([
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data Berhasil Diupdate');
    }

    // 6. Hapus Data
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        // Hapus User-nya (otomatis data karyawan ikut terhapus karena on delete cascade)
        $karyawan->user->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan Berhasil Dihapus');
    }
}