<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitor Absensi QR Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-center">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                <h3 class="text-2xl font-bold mb-2">Scan untuk Absensi</h3>
                <p class="text-gray-500 mb-8">QR Code akan diperbarui otomatis setiap 10 detik.</p>

                <div id="qr-container" class="flex justify-center items-center h-64">
                    <div class="animate-pulse bg-gray-200 w-64 h-64 rounded flex items-center justify-center">
                        Loading QR...
                    </div>
                </div>

                <div class="mt-6 font-mono text-xl text-red-500 font-bold">
                    Refresh dalam: <span id="timer">10</span> detik
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let timeLeft = 10;
            
            function loadQr() {
                $.ajax({
                    url: "{{ route('qr.generate') }}",
                    type: "GET",
                    success: function(response) {
                        $('#qr-container').html(response.qr_code); // Tampilkan Gambar QR
                    }
                });
            }

            // Panggil pertama kali
            loadQr();

            // Hitung mundur & Refresh tiap 10 detik
            setInterval(function() {
                timeLeft--;
                $('#timer').text(timeLeft);

                if (timeLeft <= 0) {
                    loadQr(); // Ambil QR baru
                    timeLeft = 10; // Reset timer
                }
            }, 1000);
        });
    </script>
</x-app-layout>