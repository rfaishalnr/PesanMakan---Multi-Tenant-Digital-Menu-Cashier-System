@extends('layouts.app')

@section('content')
    <style>
        @keyframes spin-custom { 
            100% { transform: rotate(360deg); } 
        }
        .spinner-orange {
            width: 18px; height: 18px;
            border: 3px solid #ffd0a8;
            border-top: 3px solid #FF801A;
            border-radius: 50%;
            animation: spin-custom 1s linear infinite;
        }
        .spinner-white {
            width: 18px; height: 18px;
            border: 3px solid rgba(255,255,255,0.4);
            border-top: 3px solid #ffffff;
            border-radius: 50%;
            animation: spin-custom 1s linear infinite;
        }
    </style>

    <div id="Background" class="absolute top-0 w-full h-[170px] rounded-b-[45px] bg-[linear-gradient(90deg,#FF923C_0%,#FF801A_100%)]"></div>

    <div id="TopNav" class="relative flex flex-col px-5 mt-[20px] h-[140px]">
        <div class="relative flex items-center justify-between">
            <a href="{{ route('index', $store->username) }}" class="w-11 h-11 flex items-center justify-center shrink-0 rounded-full transition-all text-white backdrop-blur-sm" style="background-color: rgba(255,255,255,0.2); text-decoration: none;">
                <span style="font-size: 18px; font-weight: bold; margin-right: 2px;">&#10094;</span>
            </a>
            <div class="flex flex-col items-center gap-0.5 text-center">
                <h1 class="text-white font-bold text-lg leading-none">Info Pesanan</h1>
            </div>
            <div class="w-11 h-11 flex shrink-0"></div>
        </div>
        <h1 class="text-white font-[600] text-2xl leading-[30px] mt-[20px]">Detail Pesanan Anda</h1>
    </div>

    <div class="relative flex flex-col px-5 mt-[20px] mb-24">
        
        <div class="flex flex-col rounded-[8px] border border-[#F1F2F6] p-5 gap-3 bg-white shadow-sm mb-5">
            <div class="flex justify-between items-center border-b border-[#F1F2F6] pb-3">
                <div>
                    <p class="text-[11px] text-gray-400 uppercase tracking-wider">Kode Transaksi</p>
                    <h2 class="text-lg font-bold text-[#353535] mt-0.5">{{ $transaction->code }}</h2>
                </div>
                <div class="text-right">
                    <p class="text-[11px] text-gray-400 uppercase tracking-wider">Antrian / Meja</p>
                    <span class="inline-block mt-1 px-3 py-1 bg-[#FFF7F0] text-[#FF801A] font-bold rounded-full text-xs">
                        Antrian #{{ str_pad($transaction->queue_number ?? 0, 3, '0', STR_PAD_LEFT) }} • Meja {{ $transaction->table_number }}
                    </span>
                </div>
            </div>
            <p class="text-xs text-gray-400">{{ $transaction->created_at->format('H:i, d M Y') }}</p>
        </div>

        <div class="flex flex-col rounded-[8px] border border-[#F1F2F6] p-5 gap-4 bg-white shadow-sm mb-5">
            <h3 class="text-[#353535] font-[500] text-base border-b border-[#F1F2F6] pb-2">Status</h3>
            
            <div class="relative flex flex-col gap-6 mt-1">
                <div class="absolute left-[15px] top-2 bottom-2 w-0.5 bg-gray-100"></div>

                <div class="flex items-start gap-4 relative z-10">
                    @if($transaction->status == 'pending')
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background-color: #FFF7F0; border: 2px solid #FF801A;">
                            <div class="spinner-orange"></div>
                        </div>
                    @elseif(in_array($transaction->status, ['success', 'ready', 'completed']))
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background-color: #10B981; color: white;">
                            <span style="font-size: 16px; font-weight: 900;">&#10004;</span>
                        </div>
                    @else
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background-color: #EF4444; color: white;">
                            <span style="font-size: 16px; font-weight: 900;">&#10006;</span>
                        </div>
                    @endif
                    <div>
                        <h4 class="text-sm font-semibold {{ in_array($transaction->status, ['pending', 'success', 'ready', 'completed']) ? 'text-[#353535]' : 'text-gray-400' }}">Menunggu Validasi</h4>
                    </div>
                </div>

                <div class="flex items-start gap-4 relative z-10">
                    @if($transaction->status == 'success')
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background-color: #FFF7F0; border: 2px solid #FF801A;">
                            <div class="spinner-orange"></div>
                        </div>
                    @elseif(in_array($transaction->status, ['ready', 'completed']))
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background-color: #10B981; color: white;">
                            <span style="font-size: 16px; font-weight: 900;">&#10004;</span>
                        </div>
                    @else
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background-color: white; border: 2px solid #E5E7EB;">
                            <div style="width: 8px; height: 8px; background-color: #D1D5DB; border-radius: 50%;"></div>
                        </div>
                    @endif
                    <div>
                        <h4 class="text-sm font-semibold {{ in_array($transaction->status, ['success', 'ready', 'completed']) ? 'text-[#353535]' : 'text-gray-400' }}">Pesanan Diproses</h4>
                    </div>
                </div>

                <div class="flex items-start gap-4 relative z-10">
                    @if($transaction->status == 'ready')
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background-color: #FF801A; color: white; box-shadow: 0 4px 6px -1px rgba(255, 128, 26, 0.4);">
                            <div class="spinner-white"></div>
                        </div>
                    @elseif($transaction->status == 'completed')
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background-color: #10B981; color: white;">
                            <span style="font-size: 16px; font-weight: 900;">&#10004;</span>
                        </div>
                    @else
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background-color: white; border: 2px solid #E5E7EB;">
                            <div style="width: 8px; height: 8px; background-color: #D1D5DB; border-radius: 50%;"></div>
                        </div>
                    @endif
                    <div>
                        <h4 class="text-sm font-semibold {{ in_array($transaction->status, ['ready', 'completed']) ? 'text-[#353535]' : 'text-gray-400' }}">Siap Diambil!</h4>
                    </div>
                </div>
            </div>

            @if($transaction->status == 'failed')
            <div class="flex items-start gap-3 mt-4 p-3 rounded-[8px]" style="background-color: #FEF2F2; border: 1px solid #FEE2E2;">
                <div class="w-6 h-6 rounded-full flex items-center justify-center shrink-0" style="background-color: #EF4444; color: white;">
                    <span style="font-size: 12px; font-weight: 900;">&#10006;</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold" style="color: #B91C1C;">Pesanan Dibatalkan</h4>
                    <p class="text-xs mt-1" style="color: #DC2626;">Pesanan dibatalkan atau pembayaran tidak valid.</p>
                </div>
            </div>
            @endif

            @if($transaction->status == 'ready')
            <div class="mt-4 pt-4 border-t border-gray-100">
                <form action="{{ route('transaction.complete', $transaction->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2" style="padding: 14px 0; background-color: #10B981; color: #ffffff; font-weight: bold; border-radius: 8px; border: none; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);">
                        <span style="font-size: 16px; font-weight: 900;">&#10004;</span> 
                        <span>Selesaikan Pesanan</span>
                    </button>
                    <p class="text-[10px] text-center text-gray-400 mt-2">Klik tombol ini jika Anda sudah menerima makanan.</p>
                </form>
            </div>
            @endif

            @if($transaction->status == 'completed')
            <div class="mt-4 p-4 bg-green-50 rounded-[8px] border border-green-100 text-center">
                <h4 class="text-sm font-bold text-green-700 mb-1">Pesanan Selesai 🎉</h4>
                <p class="text-xs text-green-600">Terima kasih, selamat menikmati pesanan Anda!</p>
            </div>
            @endif

            @if($transaction->status == 'pending' && $transaction->payment_method == 'midtrans')
            <div class="mt-5 pt-4 border-t border-gray-100">
                <div class="p-4 bg-orange-50 rounded-[8px] border border-orange-100 text-center">
                    <h4 class="text-sm font-bold text-orange-700 mb-1">Belum Diselesaikan</h4>
                    <p class="text-xs text-orange-600 mb-3">Pop-up pembayaran tertutup? Jangan khawatir, klik tombol di bawah untuk melanjutkan.</p>
                    
                    <button id="pay-button" class="w-full flex items-center justify-center gap-2" style="padding: 12px 0; background-color: #FF801A; color: #ffffff; font-weight: bold; border-radius: 8px; border: none; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(255, 128, 26, 0.3);">
                        Lanjutkan Pembayaran
                    </button>
                </div>
            </div>
            @endif
        </div>

        <div class="flex flex-col rounded-[8px] border border-[#F1F2F6] p-5 gap-4 bg-white shadow-sm mb-5">
            <h3 class="text-[#353535] font-[500] text-base border-b border-[#F1F2F6] pb-2">Rincian Belanja</h3>
            <div class="flex flex-col gap-3">
                @foreach($transaction->transactionDetails as $detail)
                <div class="flex justify-between items-start border-b border-gray-50 pb-2 last:border-none last:pb-0">
                    <div class="flex gap-2">
                        <span class="font-bold text-[#FF801A] text-sm">{{ $detail->quantity }}x</span>
                        <div>
                            <p class="font-medium text-[#353535] text-sm">{{ $detail->product->name }}</p>
                        </div>
                    </div>
                    <p class="font-bold text-[#353535] text-sm">Rp {{ number_format($detail->product->price * $detail->quantity) }}</p>
                </div>
                @endforeach
            </div>
            <div class="border-t border-[#F1F2F6] pt-3 flex justify-between items-center">
                <p class="font-medium text-gray-400 text-sm">Total Bayar</p>
                <p class="font-bold text-[#FF001A] text-lg">Rp {{ number_format($transaction->total_price) }}</p>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const currentStatus = "{{ $transaction->status }}";
        let reloadTimer;

        // Fungsi Menyalakan Auto-Reload Halaman
        function startAutoReload() {
            if (['pending', 'success', 'ready'].includes(currentStatus)) {
                reloadTimer = setTimeout(() => {
                    window.location.reload();
                }, 5000); 
            }
        }

        // Jalankan auto-reload pertama saat halaman dibuka
        startAutoReload();

        // Logika Pengaktifan Kembali Pop-up Midtrans yang Tertutup
        const payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.onclick = function () {
                // 1. BEKUKAN TIMER REFRESH BIAR POP-UP TIDAK MATI TIBA-TIBA
                clearTimeout(reloadTimer);

                // 2. Tembak Ulang Pop-up Midtrans menggunakan token yang sama
                snap.pay('{{ $transaction->snap_token }}', {
                    onSuccess: function(result) {
                        window.location.reload();
                    },
                    onPending: function(result) {
                        alert("Menunggu pembayaran Anda!");
                        window.location.reload();
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal!");
                        startAutoReload(); // Nyalakan kembali timer refresh jika gagal
                    },
                    onClose: function() {
                        alert('Anda menutup halaman sebelum menyelesaikan pembayaran.');
                        startAutoReload(); // Nyalakan kembali timer refresh jika hanya ditutup
                    }
                });
            };
        }
    });
</script>
@endsection