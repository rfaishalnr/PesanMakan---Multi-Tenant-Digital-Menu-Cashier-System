<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesaikan Pembayaran - PesanMakan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4" style="font-family: system-ui, -apple-system, sans-serif;">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full text-center border border-gray-100">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-1">Selesaikan Pesanan</h2>
            <p class="text-sm text-gray-500 mb-4">Toko: <span class="font-semibold text-gray-700">{{ $store->name }}</span></p>
            
            <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">
                <p class="text-sm text-orange-800 mb-1">Total Tagihan:</p>
                <p class="text-3xl font-bold text-orange-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
            </div>
        </div>
        
        <button id="pay-button" class="w-full bg-[#FF801A] text-white font-bold py-3.5 px-4 rounded-xl hover:bg-[#E67317] transition-colors mb-4 shadow-lg shadow-orange-200">
            Pilih Metode Pembayaran
        </button>

        <a href="{{ route('index', $store->username) }}" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
            &larr; Kembali ke Menu
        </a>
    </div>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            // Memanggil pop-up Midtrans menggunakan Snap Token dari controller
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    // Jika sukses dibayar, lempar ke halaman nota (success)
                    window.location.href = "{{ route('success', ['order_id' => $transaction->code]) }}";
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran Anda!");
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                },
                onClose: function() {
                    alert('Anda menutup pop-up sebelum menyelesaikan pembayaran.');
                }
            });
        };
    </script>
</body>
</html>