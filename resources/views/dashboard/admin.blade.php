<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin Executive') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-blue-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-700 rounded-full mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-medium text-blue-100">Total Karyawan</p>
                            <p class="text-3xl font-bold">{{ $total_karyawan ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-green-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-700 rounded-full mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-medium text-green-100">Hadir Hari Ini</p>
                            <p class="text-3xl font-bold">{{ $hadir_hari_ini ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-500 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-600 rounded-full mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="font-medium text-yellow-100">Izin Pending</p>
                            <p class="text-3xl font-bold">{{ $izin_pending ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-red-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-700 rounded-full mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-medium text-red-100">Terlambat</p>
                            <p class="text-3xl font-bold">{{ $terlambat ?? 0 }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-white p-6 rounded-lg shadow-lg lg:col-span-2 border-t-4 border-blue-500">
                    <h3 class="text-gray-700 text-lg font-bold mb-4 flex items-center gap-2">
                        <span>📈</span> Grafik Kehadiran 7 Hari Terakhir
                    </h3>
                    <div class="relative h-64 w-full">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg border-t-4 border-indigo-500 flex flex-col justify-center p-6">
                    <h3 class="text-xl font-bold text-indigo-700 mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Selamat datang di panel kontrol administrator. Pantau terus performa kedisiplinan karyawan Anda.
                    </p>
                    <div class="mt-auto pt-4 border-t text-right text-sm text-gray-500 font-mono">
                        {{ date('l, d F Y') }} <br>
                        <span class="text-xs text-green-600 font-bold">System Online ●</span>
                    </div>
                </div>
            </div>

            <h3 class="text-lg font-bold text-gray-700 mb-4 px-1">Akses Cepat Menu</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6"> 
                
                <a href="{{ route('karyawan.index') }}" class="group block bg-white border border-gray-200 rounded-lg p-6 shadow hover:bg-blue-50 hover:border-blue-300 transition cursor-pointer transform hover:-translate-y-1">
                    <div class="flex flex-col items-center text-center">
                        <div class="p-3 bg-blue-100 rounded-full text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition mb-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 group-hover:text-blue-700">Kelola Karyawan</h4>
                        <p class="text-xs text-gray-500">Data Pegawai</p>
                    </div>
                </a>

                <a href="{{ route('absensi.index') }}" class="group block bg-white border border-gray-200 rounded-lg p-6 shadow hover:bg-purple-50 hover:border-purple-300 transition cursor-pointer transform hover:-translate-y-1">
                    <div class="flex flex-col items-center text-center">
                        <div class="p-3 bg-purple-100 rounded-full text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition mb-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 group-hover:text-purple-700">Rekap Absensi</h4>
                        <p class="text-xs text-gray-500">Cek Kehadiran</p>
                    </div>
                </a>

                <a href="{{ route('izin.index') }}" class="group block bg-white border border-gray-200 rounded-lg p-6 shadow hover:bg-yellow-50 hover:border-yellow-300 transition cursor-pointer transform hover:-translate-y-1">
                    <div class="flex flex-col items-center text-center">
                        <div class="p-3 bg-yellow-100 rounded-full text-yellow-600 group-hover:bg-yellow-600 group-hover:text-white transition mb-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 group-hover:text-yellow-700">Approval Izin</h4>
                        <p class="text-xs text-gray-500">Persetujuan Cuti</p>
                    </div>
                </a>

                <a href="{{ route('gaji.index') }}" class="group block bg-white border border-gray-200 rounded-lg p-6 shadow hover:bg-green-50 hover:border-green-300 transition cursor-pointer transform hover:-translate-y-1">
                    <div class="flex flex-col items-center text-center">
                        <div class="p-3 bg-green-100 rounded-full text-green-600 group-hover:bg-green-600 group-hover:text-white transition mb-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 group-hover:text-green-700">Hitung Gaji</h4>
                        <p class="text-xs text-gray-500">Slip Gaji Bulanan</p>
                    </div>
                </a>

                <a href="{{ route('config.index') }}" class="group block bg-white border border-gray-200 rounded-lg p-6 shadow hover:bg-red-50 hover:border-red-300 transition cursor-pointer transform hover:-translate-y-1">
                    <div class="flex flex-col items-center text-center">
                        <div class="p-3 bg-red-100 rounded-full text-red-600 group-hover:bg-red-600 group-hover:text-white transition mb-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 group-hover:text-red-700">Lokasi Kantor</h4>
                        <p class="text-xs text-gray-500">Setting Koordinat</p>
                    </div>
                </a>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data diambil dari Controller (routes/web.php)
        const labels = <?php echo json_encode($chart_labels ?? []); ?>;
        const dataHadir = <?php echo json_encode($chart_data ?? []); ?>;

        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Karyawan Hadir',
                    data: dataHadir,
                    borderColor: 'rgb(59, 130, 246)', // Warna Biru
                    backgroundColor: 'rgba(59, 130, 246, 0.1)', // Warna Biru Transparan
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: 'rgb(59, 130, 246)',
                    pointRadius: 5,
                    fill: true,
                    tension: 0.4 // Garis Melengkung
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda biar bersih
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5] // Garis putus-putus
                        },
                        ticks: {
                            stepSize: 1 // Angka bulat (tidak ada 1.5 orang)
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>