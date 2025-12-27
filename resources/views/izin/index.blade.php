<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pengajuan Izin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-700">Data Izin Karyawan</h3>
                    
                    @if(Auth::user()->role == 'karyawan')
                        <a href="{{ route('izin.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Ajukan Izin Baru
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 border-b text-left text-sm font-bold text-gray-600">No</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-bold text-gray-600">Nama Karyawan</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-bold text-gray-600">Jenis & Tanggal</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-bold text-gray-600">Keterangan</th>
                                <th class="py-3 px-4 border-b text-center text-sm font-bold text-gray-600">Bukti Surat</th> 
                                <th class="py-3 px-4 border-b text-center text-sm font-bold text-gray-600">Status</th>
                                <th class="py-3 px-4 border-b text-center text-sm font-bold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($izins as $izin)
                            @php $status_izin = strtolower($izin->status); @endphp

                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 px-4 border-b text-sm">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 border-b text-sm font-bold">{{ $izin->user->name }}</td>
                                <td class="py-3 px-4 border-b text-sm">
                                    <span class="px-2 py-1 rounded text-xs font-bold 
                                        {{ $izin->jenis_izin == 'Sakit' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $izin->jenis_izin }}
                                    </span>
                                    <br>
                                    <span class="text-xs text-gray-500">
                                        {{ date('d/m', strtotime($izin->tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($izin->tanggal_selesai)) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 border-b text-sm max-w-xs truncate">{{ $izin->keterangan }}</td>
                                
                                <td class="py-3 px-4 border-b text-center">
                                    @if($izin->file_surat)
                                        <a href="{{ asset('storage/' . $izin->file_surat) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-sm border border-blue-200 bg-blue-50 px-3 py-1 rounded hover:bg-blue-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                            Lihat File
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Tidak ada file</span>
                                    @endif
                                </td>

                                <td class="py-3 px-4 border-b text-center">
                                    @if($status_izin == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">⏳ Menunggu</span>
                                    @elseif($status_izin == 'disetujui')
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">✅ Disetujui</span>
                                    @elseif($status_izin == 'ditolak')
                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">❌ Ditolak</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-bold">{{ $izin->status }}</span>
                                    @endif
                                </td>

                                <td class="py-3 px-4 border-b text-center">
                                    @if(Auth::user()->role == 'admin' && $status_izin == 'pending')
                                        <div class="flex justify-center gap-2">
                                            <form action="{{ route('izin.update', $izin->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Disetujui">
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded shadow transition transform hover:scale-110" title="Setujui">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('izin.update', $izin->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded shadow transition transform hover:scale-110" title="Tolak">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($status_izin == 'disetujui')
                                        <span class="text-green-500 text-xs font-bold">Selesai</span>
                                    @elseif($status_izin == 'ditolak')
                                        <span class="text-red-500 text-xs font-bold">Ditolak</span>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-gray-500">Belum ada data pengajuan izin.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>