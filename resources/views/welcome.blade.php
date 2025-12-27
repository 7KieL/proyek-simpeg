<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Absensi & Manajemen Karyawan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-900">
    
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
        
        <img src="{{ asset('images/bg-depan.jpg') }}" 
             alt="Background Kerjasama" 
             class="absolute inset-0 w-full h-full object-cover object-center opacity-60">
        
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative z-10 text-center p-6 max-w-3xl">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-4 drop-shadow-lg">
                Sistem Absensi & <br> Manajemen Karyawan
            </h1>
            <p class="text-xl text-gray-200 mb-8 drop-shadow-md">
                Platform terintegrasi untuk produktivitas dan pengelolaan SDM yang lebih baik.
            </p>

            @if (Route::has('login'))
                <div class="space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="inline-block px-8 py-3 bg-blue-600 text-white font-bold rounded-lg shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Masuk ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="inline-block px-8 py-3 bg-blue-600 text-white font-bold rounded-lg shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Login Karyawan / Admin
                        </a>
                    @endauth
                </div>
            @endif
        </div>

        <div class="absolute bottom-4 text-gray-400 text-sm z-10">
            &copy; {{ date('Y') }} Proyek SIMPEG. All rights reserved.
        </div>
    </div>

</body>
</html>