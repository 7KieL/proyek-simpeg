<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\SlipGajiController;
use App\Http\Controllers\ConfigKantorController;
use App\Http\Controllers\QrCodeController;

// Model untuk Dashboard Statistik
use App\Models\User;
use App\Models\Absensi;
use App\Models\Izin;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// --- DASHBOARD LOGIC (STATISTIK ADMIN & KARYAWAN) ---
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role == 'admin') {
        // 1. DATA ADMIN (GRAFIK & KARTU)
        $total_karyawan = User::where('role', 'karyawan')->count();
        $hadir_hari_ini = Absensi::where('tanggal', date('Y-m-d'))->count();
        $izin_pending   = Izin::where('status', 'Pending')->count(); 
        $terlambat      = Absensi::where('tanggal', date('Y-m-d'))->where('keterangan', 'Terlambat')->count();

        // Data Grafik 7 Hari Terakhir
        $chart_labels = [];
        $chart_data   = [];
        for ($i=6; $i>=0; $i--) {
            $tanggal = date('Y-m-d', strtotime("-$i days"));
            $chart_labels[] = date('d M', strtotime($tanggal));
            $chart_data[]   = Absensi::where('tanggal', $tanggal)->count();
        }

        // PERBAIKAN PENTING DISINI:
        // Arahkan ke 'dashboard.admin' (file admin.blade.php di dalam folder dashboard)
        return view('dashboard.admin', compact(
            'total_karyawan', 'hadir_hari_ini', 'izin_pending', 'terlambat', 'chart_labels', 'chart_data'
        ));

    } else {
        // 2. DATA KARYAWAN (JAM & REKAP PRIBADI)
        $bulan_ini = date('m');
        $hadir_bulan_ini = Absensi::where('user_id', $user->id)->whereMonth('tanggal', $bulan_ini)->count();
        $izin_bulan_ini  = Izin::where('user_id', $user->id)->whereMonth('tanggal_mulai', $bulan_ini)->where('status', 'Disetujui')->count();
        $telat_bulan_ini = Absensi::where('user_id', $user->id)->whereMonth('tanggal', $bulan_ini)->where('keterangan', 'Terlambat')->count();

        return view('dashboard.karyawan', compact('hadir_bulan_ini', 'izin_bulan_ini', 'telat_bulan_ini'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// --- GROUP ROUTE YANG BUTUH LOGIN ---
Route::middleware('auth')->group(function () {
    
    // 1. PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. KELOLA KARYAWAN
    Route::resource('karyawan', KaryawanController::class);

    // 3. ABSENSI (GPS + FOTO)
    Route::get('/absensi/export', [AbsensiController::class, 'exportExcel'])->name('absensi.export'); // Export Excel
    Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store'); // Proses Absen
    Route::resource('absensi', AbsensiController::class)->except(['store']); // Rekap Absensi

    // 4. PERIZINAN (IZIN & CUTI)
    Route::resource('izin', IzinController::class);

    // 5. SLIP GAJI
    Route::get('/gaji/cetak/{id}', [SlipGajiController::class, 'cetak'])->name('gaji.cetak'); // Cetak PDF
    Route::get('/gaji-saya', [SlipGajiController::class, 'indexKaryawan'])->name('gaji.pribadi'); // Karyawan Liat Gaji
    Route::resource('gaji', SlipGajiController::class); // Admin Kelola Gaji

    // 6. PENGATURAN KANTOR (TITIK LOKASI)
    Route::get('/pengaturan-kantor', [ConfigKantorController::class, 'index'])->name('config.index');
    Route::put('/pengaturan-kantor', [ConfigKantorController::class, 'update'])->name('config.update');

    // 7. FITUR QR CODE (OPSIONAL)
    Route::get('/qr-monitor', [QrCodeController::class, 'index'])->name('qr.monitor');
    Route::get('/qr-generate', [QrCodeController::class, 'generate'])->name('qr.generate');
    Route::get('/scan-qr', [QrCodeController::class, 'scanner'])->name('qr.scan');
    Route::post('/scan-store', [QrCodeController::class, 'scanStore'])->name('qr.store');
});

require __DIR__.'/auth.php';