<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekapitulasi Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6 pb-6 border-b">
                    
                    <form action="{{ route('absensi.index') }}" method="GET" class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600 text-sm font-bold">Dari:</span>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="border-gray-300 rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600 text-sm font-bold">Sampai:</span>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="border-gray-300 rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-bold shadow transition">
                            🔍 Cari Data
                        </button>
                        <a href="{{ route('absensi.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-bold transition">
                            Reset
                        </a>
                    </form>

                    <a href="{{ route('absensi.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-bold shadow flex items-center gap-2 transition transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Export CSV
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-4 border-b text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="py-3 px-4 border-b text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Karyawan</th>
                                <th class="py-3 px-4 border-b text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                                <th class="py-3 px-4 border-b text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                                <th class="py-3 px-4 border-b text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Foto Masuk</th>
                                <th class="py-3 px-4 border-b text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="py-3 px-4 border-b text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($data_absensi as $absen)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ date('d F Y', strtotime($absen->tanggal)) }}
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap text-sm font-bold text-gray-800">
                                    {{ $absen->user->name }}
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap text-center text-sm font-mono text-blue-600 font-bold">
                                    {{ $absen->jam_masuk }}
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap text-center text-sm font-mono text-gray-600">
                                    {{ $absen->jam_pulang ?? '-' }}
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap text-center">
                                    @if($absen->foto_masuk)
                                        <div class="group relative inline-block">
                                            <img src="{{ asset('storage/' . $absen->foto_masuk) }}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm cursor-pointer hover:scale-150 transition-transform duration-300">
                                            <div class="hidden group-hover:block absolute z-50 bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-48 bg-white p-2 rounded shadow-xl border">
                                                <img src="{{ asset('storage/' . $absen->foto_masuk) }}" class="w-full rounded">
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">No Foto</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap text-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $absen->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap text-center">
                                    @if($absen->keterangan == 'Terlambat')
                                        <span class="text-xs text-red-600 font-bold bg-red-100 px-2 py-1 rounded">Terlambat</span>
                                    @else
                                        <span class="text-xs text-gray-500">{{ $absen->keterangan }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-500 italic">
                                    Belum ada data absensi untuk periode ini.
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