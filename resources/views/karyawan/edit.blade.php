<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Karyawan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $karyawan->user->name }}" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Email</label>
                        <input type="email" name="email" value="{{ $karyawan->user->email }}" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" name="password" class="w-full border rounded p-2">
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-1">Jabatan</label>
                            <input type="text" name="jabatan" value="{{ $karyawan->jabatan }}" class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block mb-1">No HP</label>
                            <input type="text" name="no_hp" value="{{ $karyawan->no_hp }}" class="w-full border rounded p-2" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Alamat</label>
                        <textarea name="alamat" class="w-full border rounded p-2">{{ $karyawan->alamat }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('karyawan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-bold">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>