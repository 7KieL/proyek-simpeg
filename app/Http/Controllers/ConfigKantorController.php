<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Wajib import DB

class ConfigKantorController extends Controller
{
    // Menampilkan halaman form edit
    public function index()
    {
        // Ambil data konfigurasi pertama (karena cuma ada 1 kantor)
        $config = DB::table('config_kantor')->first();
        
        // Jika belum ada data (kasus langka), buat data dummy agar tidak error
        if (!$config) {
            DB::table('config_kantor')->insert([
                'latitude' => '-6.986152703451534',
                'longitude' => '107.63636582058076',
                'radius_km' => 200,
                'jam_masuk' => '08:00:00'
            ]);
            $config = DB::table('config_kantor')->first();
        }

        return view('config.edit', compact('config'));
    }

    // Menyimpan perubahan
    public function update(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'radius_km' => 'required|numeric', 
            'jam_masuk' => 'required',
        ]);

        // Update data (ID 1 selalu dianggap data utama)
        DB::table('config_kantor')->where('id', 1)->update([
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'radius_km' => $request->radius_km,
            'jam_masuk' => $request->jam_masuk,
            'updated_at'=> now(),
        ]);

        return back()->with('success', 'Lokasi & Aturan Kantor Berhasil Diupdate!');
    }
}