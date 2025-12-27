<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Permohonan Izin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('izin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Izin</label>
                        <select name="jenis_izin" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Cuti">Cuti</option>
                            <option value="Keperluan Pribadi">Keperluan Pribadi</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Alasan / Keterangan</label>
                        <textarea name="keterangan" rows="3" class="shadow border rounded w-full py-2 px-3 text-gray-700" required placeholder="Jelaskan alasan izin Anda..."></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Upload Surat Dokumen (Opsional)
                        </label>
                        <input type="file" name="file_surat" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100"
                            accept=".pdf,.jpg,.jpeg,.png">
                        <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG. Maksimal 2MB.</p>
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 mr-4">Batal</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Kirim Pengajuan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>