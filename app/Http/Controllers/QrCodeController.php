<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrToken;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class QrCodeController extends Controller
{
    // --- FITUR ADMIN: MONITOR QR ---
    
    // 1. Tampilkan Halaman Monitor (Layar Besar)
    public function index()
    {
        return view('absensi.qr_monitor');
    }

    // 2. Generate QR Code Baru (Dipanggil via AJAX tiap 10 detik)
    public function generate()
    {
        // Hapus token lama biar database bersih
        QrToken::truncate();

        // Buat token acak baru
        $token_acak = Str::random(60);
        
        // Simpan ke database (berlaku 30 detik)
        QrToken::create([
            'token' => $token_acak,
            'expires_at' => Carbon::now()->addSeconds(30)
        ]);

        // Generate gambar QR Code (SVG)
        $qr_image = QrCode::size(300)->generate($token_acak);

        return response()->json([
            'qr_code' => (string) $qr_image,
            'token' => $token_acak
        ]);
    }


    // --- FITUR KARYAWAN: SCAN QR ---

    // 3. Tampilkan Kamera Scanner
    public function scanner()
    {
        return view('absensi.scanner');
    }

    // 4. Proses Hasil Scan
    public function scanStore(Request $request)
    {
        $token_dikirim = $request->token;
        $user_id = Auth::id();
        $hari_ini = date('Y-m-d');
        $jam_sekarang = date('H:i:s');

        // A. Cek Validitas Token QR
        $cek_token = QrToken::where('token', $token_dikirim)
                            ->where('expires_at', '>', Carbon::now())
                            ->first();

        if (!$cek_token) {
            return response()->json([
                'status' => 'error', 
                'message' => 'QR Code Kadaluarsa! Silakan scan ulang.'
            ]);
        }

        // B. Cek Apakah Sudah Absen Hari Ini?
        $cek_absen = Absensi::where('user_id', $user_id)->where('tanggal', $hari_ini)->first();

        // LOGIKA ABSEN MASUK
        if (!$cek_absen) {
            Absensi::create([
                'user_id' => $user_id,
                'tanggal' => $hari_ini,
                'jam_masuk' => $jam_sekarang,
                'status' => 'Hadir'
            ]);
            return response()->json(['status' => 'success', 'message' => 'Berhasil Absen Masuk!']);
        }
        
        // LOGIKA ABSEN PULANG
        elseif ($cek_absen->jam_pulang == null) {
            // Opsional: Cek jam pulang min 16:00 (Saya matikan dulu biar gampang dites)
            // if ($jam_sekarang < '16:00:00') return response()->json(['status' => 'error', 'message' => 'Belum jam pulang!']);

            $cek_absen->update(['jam_pulang' => $jam_sekarang]);
            return response()->json(['status' => 'success', 'message' => 'Berhasil Absen Pulang!']);
        }

        else {
            return response()->json(['status' => 'error', 'message' => 'Anda sudah selesai absen hari ini.']);
        }
    }
}