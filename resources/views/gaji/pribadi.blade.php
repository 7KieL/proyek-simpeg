<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Slip Gaji Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold text-gray-700 mb-4">Riwayat Penghasilan</h3>

                <div class="overflow-x-auto border rounded-lg shadow-sm">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 border-b">Bulan</th>
                                <th class="px-6 py-3 border-b text-right">Gaji Pokok</th>
                                <th class="px-6 py-3 border-b text-right">Tunjangan</th>
                                <th class="px-6 py-3 border-b text-right">Potongan</th>
                                <th class="px-6 py-3 border-b text-right">Total Terima</th>
                                <th class="px-6 py-3 border-b text-center">Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gajis as $g)
                            <tr class="bg-white border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $g->bulan_tahun }}</td>
                                <td class="px-6 py-4 text-right">Rp {{ number_format($g->gaji_pokok, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right text-blue-600">
                                    + Rp {{ number_format($g->tunjangan_lain, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right text-red-500">
                                    - Rp {{ number_format($g->potongan_lain, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-green-700 text-base">
                                    Rp {{ number_format($g->total_gaji, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('gaji.cetak', $g->id) }}" target="_blank" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-xs px-3 py-2 inline-flex items-center gap-1 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        PDF
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                    Belum ada data slip gaji untuk Anda.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>