<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Gaji Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('gaji.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6 border-b pb-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Data Karyawan</h3>
                            
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Karyawan</label>
                                    <select name="user_id" id="select-karyawan" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 cursor-pointer" required>
                                        <option value="">-- Pilih Nama --</option>
                                        @foreach($users as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }} - {{ $u->email }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-400 mt-1">*Gaji pokok akan terisi otomatis jika sudah diatur di database.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Periode Gaji</label>
                                    <input type="text" name="bulan" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Contoh: Desember 2025" value="{{ date('F Y') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Rincian Gaji</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Gaji Pokok</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                                        </div>
                                        <input type="number" name="gaji_pokok" id="input-gaji" class="block w-full rounded-md border-gray-300 pl-10 focus:border-green-500 focus:ring-green-500 sm:text-sm bg-gray-50" placeholder="0" required>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tunjangan Lainnya</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                                        </div>
                                        <input type="number" name="tunjangan" class="block w-full rounded-md border-gray-300 pl-10 focus:border-green-500 focus:ring-green-500 sm:text-sm" placeholder="0">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">*Opsional (Transport/Makan)</p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Total Potongan</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-red-500 sm:text-sm font-bold">Rp</span>
                                    </div>
                                    <input type="number" name="potongan" class="block w-full rounded-md border-gray-300 pl-10 text-red-600 focus:border-red-500 focus:ring-red-500 sm:text-sm" placeholder="0" value="0">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">*Kosongkan jika tidak ada potongan</p>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t">
                            <a href="{{ route('gaji.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 transition">
                                Hitung & Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="data-gaji-master" data-json="{{ json_encode($users->pluck('gaji_pokok', 'id')) }}" style="display: none;"></div>

    <script>
        // 1. Ambil data dari elemen HTML di atas (Cara ini 100% Valid JS)
        const element = document.getElementById('data-gaji-master');
        const dataGajiMaster = JSON.parse(element.getAttribute('data-json'));

        // 2. Event Listener
        document.getElementById('select-karyawan').addEventListener('change', function() {
            let userId = this.value;
            let inputGaji = document.getElementById('input-gaji');
            
            // Cek data
            if(userId && dataGajiMaster[userId]) {
                inputGaji.value = dataGajiMaster[userId];
                
                // Efek visual
                inputGaji.classList.add('bg-green-100');
                setTimeout(() => inputGaji.classList.remove('bg-green-100'), 500);
            } else {
                inputGaji.value = 0;
            }
        });
    </script>
</x-app-layout>