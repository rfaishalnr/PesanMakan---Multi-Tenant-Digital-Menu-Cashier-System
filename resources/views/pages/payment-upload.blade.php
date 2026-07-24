@extends('layouts.app')

@section('content')
    <style>
        /* Animasi murni CSS untuk spinner agar aman dari Tailwind Purge */
        .spinner-white {
            width: 20px; height: 20px;
            border: 3px solid rgba(255,255,255,0.4);
            border-top: 3px solid #ffffff;
            border-radius: 50%;
            animation: spin-custom 1s linear infinite;
        }
        @keyframes spin-custom { 100% { transform: rotate(360deg); } }
    </style>

    <div id="Background" class="absolute top-0 w-full h-[170px] rounded-b-[45px] bg-[linear-gradient(90deg,#FF923C_0%,#FF801A_100%)] z-0"></div>

    <div id="TopNav" class="relative flex items-center justify-between px-5 mt-[20px] h-[60px] z-10">
        <a href="javascript:history.back()" class="w-11 h-11 flex items-center justify-center shrink-0 rounded-full transition-all text-white backdrop-blur-sm" style="background-color: rgba(255,255,255,0.2); text-decoration: none;">
            <span style="font-size: 18px; font-weight: bold; margin-right: 2px;">&#10094;</span>
        </a>
        <div class="flex flex-col items-center gap-0.5 text-center">
            <h1 class="text-white font-bold text-lg leading-none">Pembayaran QRIS</h1>
        </div>
        <div class="w-11 h-11 flex shrink-0"></div>
    </div>

    <div id="toast" class="fixed top-24 left-1/2 -translate-x-1/2 bg-gray-900 text-white px-5 py-2.5 rounded-full text-sm font-medium opacity-0 transition-opacity duration-300 pointer-events-none z-50 shadow-lg">
        Nominal berhasil disalin!
    </div>

    <div class="relative flex flex-col px-5 mt-[30px] mb-32 gap-5 z-10">
        
        <div class="relative flex flex-col items-center justify-center bg-white p-7 rounded-[8px] shadow-sm border border-[#F1F2F6] overflow-hidden">
            <div class="absolute top-0 inset-x-0 h-1 bg-[linear-gradient(90deg,#FF923C_0%,#FF801A_100%)]"></div>
            <p class="text-[11px] text-gray-400 font-bold mb-1 tracking-widest uppercase">Total Pembayaran</p>
            
            <div class="flex items-center justify-center gap-3 my-2">
                <h1 class="text-4xl font-black text-[#FF001A] tracking-tight">
                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                </h1>
                <button type="button" onclick="copyAmount({{ $transaction->total_price }})" class="flex items-center justify-center w-10 h-10 bg-[#FFF7F0] rounded-full hover:bg-orange-100 active:scale-90 transition-all text-[#FF801A] focus:outline-none" title="Salin Nominal">
                    <span style="font-size: 18px; line-height: 1;">&#128203;</span>
                </button>
            </div>
            
            <div class="mt-4 px-4 py-1.5 bg-gray-50 border border-[#F1F2F6] rounded-full flex items-center gap-2">
                <span class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Order ID</span>
                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                <span class="text-sm font-bold text-[#353535]">{{ $transaction->code }}</span>
            </div>
        </div>

        <div class="flex flex-col items-center bg-white p-6 rounded-[8px] shadow-sm border border-[#F1F2F6]">
            <h2 class="font-bold text-[#353535] mb-5 text-sm uppercase tracking-wider">Scan QRIS Berikut</h2>
            
            <div class="w-[200px] h-[200px] bg-[#FFF7F0] rounded-xl border-2 border-dashed border-[#FF801A] flex items-center justify-center p-2 mb-4">
                @if ($store->qris_image)
                    <img src="{{ Storage::url($store->qris_image) }}" alt="QRIS" class="w-full h-full object-contain rounded-lg">
                @else
                    <p class="text-[10px] text-gray-400">QRIS Kosong</p>
                @endif
            </div>

            @if ($store->qris_image)
                <a href="{{ Storage::url($store->qris_image) }}" download="QRIS-{{ $store->name }}.jpg" class="flex items-center justify-center gap-2 text-sm font-bold text-[#FF801A] hover:bg-orange-50 transition-colors w-full bg-[#FFF7F0] py-3 rounded-[8px] mb-4">
                    <span style="font-size: 16px;">&#11123;</span> Simpan Gambar QRIS
                </a>
            @endif

            <div class="flex bg-gray-50 p-4 rounded-[8px] items-start gap-3 w-full border border-gray-100">
                <span style="font-size: 18px; color: #FF801A;">&#8505;</span>
                <p class="text-[11px] text-left text-gray-500 leading-relaxed">
                    Buka aplikasi E-Wallet Anda (GoPay, DANA, BCA, dll), lalu scan gambar QRIS di atas. Pastikan nama penerima <strong>{{ $store->name }}</strong>.
                </p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[8px] shadow-sm border border-[#F1F2F6]">
            <h3 class="font-bold text-[#353535] mb-4 text-sm uppercase tracking-wider text-center">Upload Bukti Transfer</h3>
            
            @if($transaction->proof_of_payment)
                <div class="text-center">
                    <img src="{{ Storage::url($transaction->proof_of_payment) }}" class="w-full max-w-[200px] mx-auto rounded-[8px] border border-gray-200">
                    <div class="mt-4 p-3 bg-green-50 text-green-700 text-xs font-bold rounded-[8px] w-full text-center border border-green-100">
                        &#10004; Bukti pembayaran berhasil diunggah!
                    </div>
                </div>
            @else
                <form action="{{ route('payment.process', $transaction->code) }}" method="POST" enctype="multipart/form-data" onsubmit="submitForm()">
                    @csrf
                    
                    <label class="flex flex-col items-center justify-center w-full h-[180px] border-2 border-dashed border-[#D1D5DB] rounded-[8px] cursor-pointer bg-gray-50 hover:bg-[#FFF7F0] hover:border-[#FF801A] transition-all relative overflow-hidden" id="upload-container">
                        
                        <div class="flex flex-col items-center justify-center w-full h-full" id="upload-placeholder">
                            <span style="font-size: 28px; color: #9CA3AF;">&#8682;</span>
                            <p class="text-xs text-gray-500 font-bold mt-2">Klik pilih struk</p>
                            <p class="text-[10px] text-gray-400 mt-1">PNG, JPG (Max. 2MB)</p>
                        </div>
                        
                        <div id="preview-wrapper" class="absolute inset-0 w-full h-full hidden bg-white flex-col items-center justify-center p-1">
                            <img id="image-preview" class="w-full h-full object-contain rounded-md">
                            <div class="absolute bottom-0 inset-x-0 bg-black/60 py-1.5 text-center">
                                <p class="text-[10px] text-white font-medium">Ketuk untuk ganti gambar</p>
                            </div>
                        </div>

                        <input type="file" name="proof_of_payment" class="hidden" accept="image/png, image/jpeg, image/jpg" required onchange="previewImage(event)" />
                    </label>
                    
                    <p id="file-error" class="text-xs text-red-500 font-medium text-center mt-3 hidden">Ukuran file terlalu besar! Maksimal 2MB.</p>
                    
                    @error('proof_of_payment')
                        <p class="text-xs text-red-500 font-medium text-center mt-3">{{ $message }}</p>
                    @enderror

                    <button type="submit" id="submit-btn" class="w-full mt-5 py-3.5 rounded-full bg-[#FF801A] text-white font-bold text-sm shadow-sm transition-all flex items-center justify-center" style="background-color: #FF801A;">
                        <span id="btn-text">Konfirmasi Pembayaran</span>
                        <div id="btn-spinner" class="spinner-white hidden ml-2"></div>
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const orderCode = "{{ $transaction->code }}";
        let history = JSON.parse(localStorage.getItem('pesanmakan_orders') || '[]');

        if (!history.includes(orderCode)) {
            history.push(orderCode);
            localStorage.setItem('pesanmakan_orders', JSON.stringify(history));
        }
    });

    function copyAmount(amount) {
        navigator.clipboard.writeText(amount).then(() => {
            const toast = document.getElementById('toast');
            toast.classList.remove('opacity-0');
            setTimeout(() => toast.classList.add('opacity-0'), 2000);
        });
    }

    function previewImage(event) {
        const input = event.target;
        const errorText = document.getElementById('file-error');
        const container = document.getElementById('upload-container');

        if (input.files && input.files[0]) {
            const fileSize = input.files[0].size / 1024 / 1024; // MB

            if (fileSize > 2) {
                input.value = ''; 
                errorText.classList.remove('hidden');
                container.style.borderColor = '#EF4444'; 
                
                // Kembalikan ke tampilan awal jika error
                document.getElementById('preview-wrapper').classList.add('hidden');
                document.getElementById('upload-placeholder').classList.remove('hidden');
                return;
            }

            errorText.classList.add('hidden');
            container.style.borderColor = '#FF801A'; 

            const reader = new FileReader();
            reader.onload = function(e) {
                // Tampilkan gambar dan wrapper preview, lalu sembunyikan tulisan placeholder
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('preview-wrapper').classList.remove('hidden');
                document.getElementById('preview-wrapper').classList.add('flex');
                document.getElementById('upload-placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function submitForm() {
        document.getElementById('btn-text').innerText = "Mengunggah...";
        document.getElementById('btn-spinner').classList.remove('hidden');
        document.getElementById('submit-btn').style.pointerEvents = 'none';
        document.getElementById('submit-btn').style.opacity = '0.7';
    }
</script>
@endsection