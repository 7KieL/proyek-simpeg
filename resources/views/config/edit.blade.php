<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Lokasi Kantor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('config.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="col-span-2 bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h3 class="font-bold text-blue-800 mb-2">📍 Koordinat Kantor</h3>
                            <p class="text-sm text-blue-600 mb-4">Buka <a href="https://www.google.com/maps" target="_blank" class="underline font-bold">Google Maps</a>, klik kanan pada lokasi kantor Anda, lalu klik angka koordinat untuk menyalinnya.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                                    <input type="text" name="latitude" value="{{ $config->latitude }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                                    <input type="text" name="longitude" value="{{ $config->longitude }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                            <h3 class="font-bold text-yellow-800 mb-2">📏 Radius Jangkauan</h3>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jarak Maksimal (Meter)</label>
                            <input type="number" name="radius_km" value="{{ $config->radius_km }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500" required>
                            <p class="text-xs text-gray-500 mt-1">Karyawan tidak bisa absen jika jaraknya lebih jauh dari ini.</p>
                        </div>

                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <h3 class="font-bold text-red-800 mb-2">⏰ Jam Masuk</h3>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Batas Waktu Terlambat</label>
                            <input type="time" name="jam_masuk" value="{{ $config->jam_masuk }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500" required>
                            <p class="text-xs text-gray-500 mt-1">Lewat dari jam ini statusnya "Terlambat".</p>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>