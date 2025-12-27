<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Karyawan (GPS + Selfie)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-center">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 font-bold">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-blue-600 rounded-xl shadow-lg p-6 text-white mb-6 flex flex-col md:flex-row justify-between items-center">
                <div class="text-left">
                    <h3 class="text-3xl font-bold mb-1">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-blue-100 text-sm">Semangat bekerja! Jangan lupa absen tepat waktu.</p>
                </div>
                <div class="text-center md:text-right mt-4 md:mt-0 bg-blue-700 p-3 rounded-lg shadow-inner">
                    <p class="text-xs text-blue-200 font-semibold uppercase tracking-wider mb-1">{{ date('l, d F Y') }}</p>
                    <div id="digital-clock" class="text-4xl md:text-5xl font-mono font-bold tracking-widest drop-shadow-md">00:00:00</div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow-md border-t-4 border-green-500 hover:shadow-lg transition">
                    <span class="text-gray-500 text-xs font-bold uppercase tracking-wide">Hadir</span>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $hadir_bulan_ini ?? 0 }}</p>
                    <span class="text-xs text-gray-400 font-normal">Hari</span>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md border-t-4 border-yellow-500 hover:shadow-lg transition">
                    <span class="text-gray-500 text-xs font-bold uppercase tracking-wide">Izin</span>
                    <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $izin_bulan_ini ?? 0 }}</p>
                    <span class="text-xs text-gray-400 font-normal">Hari</span>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md border-t-4 border-red-500 hover:shadow-lg transition">
                    <span class="text-gray-500 text-xs font-bold uppercase tracking-wide">Telat</span>
                    <p class="text-3xl font-bold text-red-600 mt-1">{{ $telat_bulan_ini ?? 0 }}</p>
                    <span class="text-xs text-gray-400 font-normal">Kali</span>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    
                    <div class="flex flex-col gap-2">
                        <div class="bg-black rounded-lg overflow-hidden relative h-64 flex justify-center items-center shadow-lg group">
                            <div id="my_camera" class="w-full h-full" style="display:none;"></div>
                            
                            <div id="camera_off" class="text-gray-400 flex flex-col items-center">
                                <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                <span>Kamera Nonaktif</span>
                            </div>

                            <div id="camera_loading" class="absolute text-white font-bold hidden">Menyiapkan...</div>
                        </div>

                        <button type="button" onclick="toggleCamera()" id="btn-toggle-camera" class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded shadow flex items-center justify-center gap-2 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span id="text-toggle-camera">Buka Kamera</span>
                        </button>
                    </div>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 flex flex-col justify-center items-center shadow-md">
                        <div id="location-status" class="mb-2 font-bold text-blue-700 text-lg">Mencari Lokasi... 🌍</div>
                        <p class="text-xs text-gray-500">Pastikan GPS aktif & Izinkan akses lokasi.</p>
                    </div>
                </div>

                <div class="flex justify-center gap-4">
                    
                    <form action="{{ route('absensi.store') }}" method="POST" id="form-masuk">
                        @csrf
                        <input type="hidden" name="jenis" value="masuk">
                        <input type="hidden" name="latitude" id="lat_masuk">
                        <input type="hidden" name="longitude" id="long_masuk">
                        <input type="hidden" name="foto" id="foto_masuk"> 

                        <button type="button" onclick="takeSnapshot()" id="btn-masuk" disabled class="bg-gray-400 text-white font-bold py-4 px-8 rounded-lg text-xl shadow-lg cursor-not-allowed transition duration-300 transform hover:scale-105">
                            📸 ABSEN MASUK
                        </button>
                    </form>

                    <form action="{{ route('absensi.store') }}" method="POST" id="form-pulang">
                        @csrf
                        <input type="hidden" name="jenis" value="pulang">
                        <input type="hidden" name="latitude" id="lat_pulang">
                        <input type="hidden" name="longitude" id="long_pulang">
                        
                        <button type="submit" id="btn-pulang" disabled class="bg-gray-400 text-white font-bold py-4 px-8 rounded-lg text-xl shadow-lg cursor-not-allowed transition duration-300 transform hover:scale-105">
                            🏠 ABSEN PULANG
                        </button>
                    </form>
                </div>

                <div class="mt-8 border-t pt-6">
                    <h4 class="font-semibold mb-4 text-gray-600">Menu Cepat</h4>
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('izin.create') }}" class="text-blue-600 hover:text-white hover:bg-blue-600 border border-blue-200 bg-blue-50 px-4 py-2 rounded transition shadow-sm">📝 Ajukan Izin</a>
                        <a href="{{ route('gaji.pribadi') }}" class="text-green-600 hover:text-white hover:bg-green-600 border border-green-200 bg-green-50 px-4 py-2 rounded transition shadow-sm flex items-center gap-2">💰 Slip Gaji Saya</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // --- 1. CONFIG JAM DIGITAL ---
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const clockElement = document.getElementById('digital-clock');
            if(clockElement) {
                clockElement.innerText = timeString;
            }
        }
        setInterval(updateClock, 1000);
        updateClock(); // Jalankan langsung

        // --- 2. CONFIG KAMERA ---
        Webcam.set({
            width: 480,
            height: 360,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        let isCameraOn = false; // Status kamera saat ini

        // --- 3. FUNGSI BUKA/TUTUP KAMERA ---
        function toggleCamera() {
            const cameraDiv = document.getElementById('my_camera');
            const placeholderDiv = document.getElementById('camera_off');
            const btnText = document.getElementById('text-toggle-camera');
            const btnToggle = document.getElementById('btn-toggle-camera');

            if (!isCameraOn) {
                // NYALAKAN KAMERA
                try {
                    Webcam.attach('#my_camera');
                    cameraDiv.style.display = 'block';
                    placeholderDiv.style.display = 'none';
                    btnText.innerText = 'Tutup Kamera';
                    btnToggle.classList.replace('bg-gray-800', 'bg-red-600');
                    btnToggle.classList.replace('hover:bg-gray-900', 'hover:bg-red-700');
                    isCameraOn = true;
                } catch (e) {
                    Swal.fire('Error', 'Kamera tidak terdeteksi!', 'error');
                }
            } else {
                // MATIKAN KAMERA
                Webcam.reset(); // Ini mematikan lampu kamera
                cameraDiv.style.display = 'none';
                placeholderDiv.style.display = 'flex';
                btnText.innerText = 'Buka Kamera';
                btnToggle.classList.replace('bg-red-600', 'bg-gray-800');
                btnToggle.classList.replace('hover:bg-red-700', 'hover:bg-gray-900');
                isCameraOn = false;
            }
        }

        // --- 4. FUNGSI AMBIL FOTO ---
        function takeSnapshot() {
            if (!isCameraOn) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kamera Mati',
                    text: 'Silakan tekan tombol "Buka Kamera" terlebih dahulu!',
                });
                return;
            }

            Webcam.snap(function(data_uri) {
                document.getElementById('foto_masuk').value = data_uri;
                document.getElementById('form-masuk').submit();
            });
        }

        // --- 5. SETUP LOKASI (GPS) ---
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            document.getElementById("location-status").innerHTML = "Browser tidak support GPS.";
        }

        function showPosition(position) {
            let lat = position.coords.latitude;
            let long = position.coords.longitude;

            document.getElementById("lat_masuk").value = lat;
            document.getElementById("long_masuk").value = long;
            document.getElementById("lat_pulang").value = lat;
            document.getElementById("long_pulang").value = long;

            let statusDiv = document.getElementById("location-status");
            statusDiv.innerHTML = "Lokasi Ditemukan! ✅<br><span class='text-xs font-normal'>(" + lat.toFixed(5) + ", " + long.toFixed(5) + ")</span>";
            statusDiv.className = "bg-green-50 border border-green-200 rounded-lg p-6 flex flex-col justify-center items-center text-green-700 font-bold shadow-md";

            // Aktifkan Tombol Absen
            document.getElementById("btn-masuk").disabled = false;
            document.getElementById("btn-masuk").classList.remove('bg-gray-400', 'cursor-not-allowed');
            document.getElementById("btn-masuk").classList.add('bg-blue-600', 'hover:bg-blue-700', 'cursor-pointer');
            
            document.getElementById("btn-pulang").disabled = false;
            document.getElementById("btn-pulang").classList.remove('bg-gray-400', 'cursor-not-allowed');
            document.getElementById("btn-pulang").classList.add('bg-gray-600', 'hover:bg-gray-700', 'cursor-pointer');
        }

        function showError(error) {
            document.getElementById("location-status").innerHTML = "❌ Gagal Deteksi Lokasi: " + error.message;
        }
    </script>
</x-app-layout>