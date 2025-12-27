<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // <--- WAJIB UNTUK SIMPAN FILE

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query
        $query = Absensi::with('user');

        // Jika ada filter tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        // Ambil data (urutkan dari yang terbaru)
        $data_absensi = $query->latest()->get();

        return view('absensi.index', compact('data_absensi'));
    }

    // Fungsi Hitung Jarak (Haversine Formula)
    private function distance($lat1, $lon1, $lat2, $lon2) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344); // Konversi ke Kilometer
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();
        $tanggal = date('Y-m-d');
        $waktu   = date('H:i:s');
        
        // 1. CEK KONFIGURASI KANTOR
        $config = DB::table('config_kantor')->first();
        if (!$config) return back()->with('error', 'Konfigurasi kantor belum diatur oleh Admin!');

        // 2. VALIDASI RADIUS
        $jarak = $this->distance($config->latitude, $config->longitude, $request->latitude, $request->longitude);
        $jarak_meter = $jarak * 1000;
        
        // Ambil radius dari DB (default 200m jika kosong)
        $max_radius = $config->radius_km ?? 200;

        if ($jarak_meter > $max_radius) { 
            return back()->with('error', 'Jarak terlalu jauh: ' . round($jarak_meter) . ' m. (Maksimal: '.$max_radius.' m)');
        }

        // --- LOGIKA ABSEN MASUK ---
        if ($request->jenis == 'masuk') {
            $cek = Absensi::where('user_id', $user_id)->where('tanggal', $tanggal)->first();
            if ($cek) return back()->with('error', 'Anda sudah absen masuk hari ini!');

            // A. PROSES SIMPAN FOTO
            $fotoPath = null;
            if ($request->foto) {
                // Foto dikirim dalam format Base64 (data:image/jpeg;base64,...)
                $image = $request->foto;  
                $image = str_replace('data:image/jpeg;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                
                // Buat nama file unik: absen_ID_TIMESTAMP.jpg
                $imageName = 'absen_' . $user_id . '_' . date('YmdHis') . '.jpg';
                
                // Simpan ke folder public/storage/absensi
                Storage::disk('public')->put('absensi/' . $imageName, base64_decode($image));
                
                $fotoPath = 'absensi/' . $imageName;
            }

            // B. STATUS TERLAMBAT
            $keterangan = ($waktu > $config->jam_masuk) ? 'Terlambat' : 'Tepat Waktu';

            Absensi::create([
                'user_id' => $user_id,
                'tanggal' => $tanggal,
                'jam_masuk' => $waktu,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => 'Hadir',
                'keterangan' => $keterangan,
                'foto_masuk' => $fotoPath // Simpan lokasi file foto
            ]);
            
            return back()->with('success', 'Absen Masuk Berhasil! 📸');
        } 
        
        // --- LOGIKA ABSEN PULANG ---
        elseif ($request->jenis == 'pulang') {
            $absen = Absensi::where('user_id', $user_id)->where('tanggal', $tanggal)->first();
            if (!$absen) return back()->with('error', 'Belum absen masuk!');
            if ($absen->jam_pulang) return back()->with('error', 'Sudah absen pulang!');

            $absen->update(['jam_pulang' => $waktu]);
            return back()->with('success', 'Hati-hati di jalan! 👋');
        }
    }

    // Export Excel
    public function exportExcel()
    {
        $filename = 'Rekap-Absensi-'.date('d-m-Y').'.csv';
        $absensis = Absensi::with('user')->latest()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Tanggal', 'Nama', 'Jam Masuk', 'Jam Pulang', 'Status', 'Keterangan', 'Foto'];

        $callback = function() use($absensis, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($absensis as $row) {
                fputcsv($file, [
                    $row->tanggal,
                    $row->user->name,
                    $row->jam_masuk,
                    $row->jam_pulang,
                    $row->status,
                    $row->keterangan ?? '-',
                    $row->foto_masuk ? 'Ada' : '-'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
}