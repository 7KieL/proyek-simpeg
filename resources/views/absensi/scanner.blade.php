<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Scanner Absensi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg text-center">
                
                <div id="reader" width="600px" class="border-2 border-dashed border-gray-400 rounded-lg"></div>
                
                <p class="mt-4 text-sm text-gray-500">Arahkan kamera ke layar Monitor Admin.</p>

                <div id="result-message" class="hidden mt-4 p-4 rounded-lg font-bold"></div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Token CSRF untuk keamanan Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function onScanSuccess(decodedText, decodedResult) {
            // Hentikan suara bip berulang
            // html5QrcodeScanner.clear(); 

            // Kirim Kode ke Server
            $.ajax({
                url: "{{ route('qr.store') }}",
                type: "POST",
                data: { token: decodedText },
                success: function(response) {
                    if(response.status == 'success') {
                        // Tampilkan Pesan Sukses
                        $('#result-message').removeClass('hidden bg-red-100 text-red-700').addClass('bg-green-100 text-green-700').text(response.message);
                        alert(response.message); // Alert Popup
                        window.location.href = "{{ route('dashboard') }}"; // Redirect ke dashboard
                    } else {
                        // Tampilkan Pesan Error
                        $('#result-message').removeClass('hidden bg-green-100 text-green-700').addClass('bg-red-100 text-red-700').text(response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan koneksi!');
                }
            });
        }

        function onScanFailure(error) {
            // Biarkan kosong agar tidak spam console log saat belum mendeteksi QR
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: {width: 250, height: 250} }, /* verbose= */ false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
</x-app-layout>