<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Karyawan Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg">
                
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <strong class="font-bold">Gagal Menyimpan!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('karyawan.store') }}" method="POST">
                    @csrf
                    
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">1. Pengaturan Akun Login</h3>
                    <div class="mb-4">
                        <label class="block mb-1">Nama Lengkap</label>
                        <input type="text" name="name" class="w-full border rounded p-2" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Email</label>
                        <input type="email" name="email" class="w-full border rounded p-2" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Password</label>
                        <input type="password" name="password" class="w-full border rounded p-2" required>
                    </div>

                    <h3 class="text-lg font-bold mb-4 border-b pb-2 mt-6">2. Data Pribadi</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-1">Jabatan</label>
                            <input type="text" name="jabatan" class="w-full border rounded p-2" placeholder="Contoh: Staff IT" value="{{ old('jabatan') }}" required>
                        </div>
                        <div>
                            <label class="block mb-1">No HP</label>
                            <input type="number" name="no_hp" class="w-full border rounded p-2" value="{{ old('no_hp') }}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Alamat</label>
                        <textarea name="alamat" class="w-full border rounded p-2">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('karyawan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-bold">Simpan Karyawan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>