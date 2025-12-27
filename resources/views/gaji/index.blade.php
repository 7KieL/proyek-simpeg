<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Penggajian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-700">Daftar Slip Gaji Karyawan</h3>
                            <p class="text-sm text-gray-500">Kelola dan lihat riwayat gaji bulanan.</p>
                        </div>
                        
                        <a href="{{ route('gaji.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Buat Slip Gaji Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto border rounded-lg shadow-sm">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 border-b">Bulan</th>
                                    <th scope="col" class="px-6 py-3 border-b">Nama Karyawan</th>
                                    <th scope="col" class="px-6 py-3 border-b text-right">Gaji Pokok</th>
                                    <th scope="col" class="px-6 py-3 border-b text-right">Potongan</th>
                                    <th scope="col" class="px-6 py-3 border-b text-right">Total Terima</th>
                                    <th scope="col" class="px-6 py-3 border-b text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($gajis as $g)
                                <tr class="bg-white border-b hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $g->bulan_tahun }}</td>
                                    <td class="px-6 py-4">{{ $g->user->name }}</td>
                                    <td class="px-6 py-4 text-right">Rp {{ number_format($g->gaji_pokok, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right text-red-500">
                                        @if($g->potongan_lain > 0)
                                            - Rp {{ number_format($g->potongan_lain, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-green-700 text-base">
                                        Rp {{ number_format($g->total_gaji, 0, ',', '.') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('gaji.cetak', $g->id) }}" target="_blank" class="text-blue-600 hover:text-blue-900 font-bold flex items-center justify-center gap-1 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            PDF
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-gray-100 p-4 rounded-full mb-3">
                                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900">Belum ada data slip gaji</h3>
                                            <p class="text-sm mt-1 mb-4">Silakan buat slip gaji pertama untuk karyawan Anda.</p>
                                            
                                            <a href="{{ route('gaji.create') }}" class="text-green-600 hover:underline font-semibold">
                                                + Buat Sekarang
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 text-xs text-gray-400 text-right">
                        * Data diurutkan dari yang terbaru
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>