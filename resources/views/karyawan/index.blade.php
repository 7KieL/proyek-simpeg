<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('karyawan.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold">
                    + Tambah Karyawan Baru
                </a>

                <table class="w-full mt-4 border-collapse border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-3 text-left">Nama Lengkap</th>
                            <th class="border p-3 text-left">Email (Login)</th>
                            <th class="border p-3 text-left">Jabatan</th>
                            <th class="border p-3 text-left">No HP</th>
                            <th class="border p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data_karyawan as $k)
                        <tr class="hover:bg-gray-50">
                            <td class="border p-3">{{ $k->user->name }}</td>
                            <td class="border p-3">{{ $k->user->email }}</td>
                            <td class="border p-3">{{ $k->jabatan }}</td>
                            <td class="border p-3">{{ $k->no_hp }}</td>
                            <td class="border p-3 text-center flex justify-center gap-2">
                                <a href="{{ route('karyawan.edit', $k->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Edit</a>
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('karyawan.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>