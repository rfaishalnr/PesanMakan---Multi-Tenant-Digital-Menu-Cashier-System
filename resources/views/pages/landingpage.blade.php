<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>{{ config('app.name') }} - Platform Kasir & E-Menu Otomatis</title>
        <meta name="description" content="PesanMakan adalah platform SaaS E-Menu dan Kasir Digital. Pelanggan scan QR meja, pesan, dan bayar otomatis via Midtrans. Kelola bisnis kuliner tanpa ribet!">
        
        <meta name="keywords" content="aplikasi kasir, e-menu, point of sales, pesanan qr code, aplikasi restoran, pesanmakan, midtrans, qris otomatis">
        <meta name="author" content="PesanMakan Team">
    
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:title" content="PesanMakan - Platform Kasir & E-Menu Otomatis">
        <meta property="og:description" content="Tinggalkan antrean kasir! Pelanggan scan QR, bayar online otomatis, dan pesanan langsung masuk ke dapur Anda.">
        <meta property="og:image" content="{{ asset('assets/images/logo-banner.jpg') }}"> <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo.svg') }}">
    
        <script src="https://cdn.tailwindcss.com"></script>
        </head>
<body class="bg-[#FAFAFA] text-[#353535] antialiased selection:bg-[#FF801A] selection:text-white">

    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-md z-50 border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-[#FF801A] tracking-tight">
                {{ config('app.name') }}<span class="text-[#353535]">.</span>
            </a>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="#fitur" class="text-sm font-medium text-gray-500 hover:text-[#FF801A] transition-colors">Fitur Unggulan</a>
                <a href="#harga" class="text-sm font-medium text-gray-500 hover:text-[#FF801A] transition-colors">Harga Langganan</a>
                <div class="h-5 w-[1px] bg-gray-200"></div>
                
                @guest
                    <a href="/admin/login" class="text-sm font-semibold text-gray-600 hover:text-[#FF801A] transition-colors">Masuk</a>
                    <a href="/admin/register" class="px-5 py-2.5 bg-[#FF801A] text-white text-sm font-semibold rounded-full hover:bg-[#E67317] hover:shadow-lg hover:shadow-[#FF801A]/30 transition-all">
                        Buka Toko
                    </a>
                @endguest

                @auth
                    <a href="/admin" class="px-5 py-2.5 bg-[#353535] text-white text-sm font-semibold rounded-full hover:bg-black transition-all flex items-center gap-2">
                        Dashboard Toko Saya
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 md:pt-48 md:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#FF801A]/10 text-[#FF801A] text-sm font-semibold mb-6">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FF801A] opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#FF801A]"></span>
                </span>
                Sistem E-Menu & Pemesanan Mandiri
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 tracking-tight leading-[1.1] mb-8 max-w-4xl mx-auto">
                Tinggalkan Antrean Kasir,<br> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF923C] to-[#FF801A]">Otomatiskan Pesanan Anda.</span>
            </h1>
            
            <p class="text-lg md:text-xl text-gray-500 mb-10 max-w-2xl mx-auto leading-relaxed">
                Ubah cara Anda berjualan. Pelanggan cukup scan QR Code di meja, pesan makanan, bayar via bayar online, dan pesanan langsung masuk ke dapur Anda secara <strong>Real-time!</strong>
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @guest
                    <a href="/admin/register" class="w-full sm:w-auto px-8 py-4 bg-[#FF801A] text-white font-semibold rounded-full hover:bg-[#E67317] hover:shadow-xl hover:shadow-[#FF801A]/20 transition-all flex items-center justify-center gap-2">
                        Mulai Bisnis Digital
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                @endguest

                @auth
                    <a href="/admin" class="w-full sm:w-auto px-8 py-4 bg-[#353535] text-white font-semibold rounded-full hover:bg-black hover:shadow-xl transition-all flex items-center justify-center gap-2">
                        Kelola Toko Saya
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0m0 0H4.5m0 1.5v13.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V7.5m-9 .75h6V15h-6v-6z" />
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <section id="fitur" class="py-20 bg-white border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Satu Platform, Berbagai Keunggulan</h2>
                <p class="text-gray-500 max-w-xl mx-auto">Sistem cerdas yang dirancang khusus untuk memotong waktu tunggu dan mempermudah operasional kafe atau restoran Anda.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:shadow-lg transition-all group">
                    <div class="w-14 h-14 rounded-xl bg-[#FF801A]/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-[#FF801A]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pesanan via QR Meja</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Cetak kode QR unik untuk setiap meja. Pelanggan cukup scan dengan HP, lihat katalog menu, dan pesan tanpa harus memanggil pelayan.</p>
                </div>
                
                <div class="p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:shadow-lg transition-all group">
                    <div class="w-14 h-14 rounded-xl bg-[#FF801A]/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-[#FF801A]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pembayaran Online Otomatis</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Terintegrasi penuh dengan Payment Gateway. Validasi pembayaran QRIS & E-Wallet terjadi secara otomatis (real-time) tanpa perlu cek mutasi manual!</p>
                </div>
                
                <div class="p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:shadow-lg transition-all group">
                    <div class="w-14 h-14 rounded-xl bg-[#FF801A]/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-[#FF801A]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0m0 0H4.5m0 1.5v13.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V7.5m-9 .75h6V15h-6v-6z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Dashboard Manajemen Dapur</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Kelola pesanan dari satu layar. Ubah status pesanan dari "Menunggu", "Diproses", hingga "Siap Diambil", dan pelanggan akan melihatnya di HP mereka.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="harga" class="py-20 bg-[#FAFAFA]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Pilih Paket Sesuai Kebutuhan Bisnis Anda</h2>
                <p class="text-gray-500 max-w-xl mx-auto">Dari yang gratis untuk kedai rintisan, hingga yang tanpa batas untuk restoran yang sedang bertumbuh pesat.</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto items-stretch">
                
                <div class="bg-white rounded-3xl border border-gray-200 shadow-sm hover:shadow-md transition-all overflow-hidden relative flex flex-col">
                    <div class="p-8 md:p-10 border-b border-gray-100">
                        <span class="inline-block py-1.5 px-3.5 rounded-full bg-gray-100 text-gray-600 font-semibold text-xs tracking-wide uppercase mb-4">Paket Pemula</span>
                        <div class="flex items-end gap-1 mb-2">
                            <span class="text-4xl font-extrabold text-gray-900">Rp 0</span>
                            <span class="text-gray-500 font-medium mb-2">/ Selamanya</span>
                        </div>
                        <p class="text-gray-500 text-sm leading-relaxed">Fasilitas dasar yang cukup untuk kedai kecil membuktikan kehebatan sistem pemesanan digital.</p>
                    </div>
                    <div class="p-8 md:p-10 bg-white flex flex-col flex-1">
                        <ul class="flex flex-col gap-4 mb-8 flex-1">
                            <li class="flex items-start gap-3 text-gray-700 text-sm font-medium">
                                <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Akses Dashboard Kasir & Dapur</span>
                            </li>
                            <li class="flex items-start gap-3 text-gray-700 text-sm font-medium">
                                <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Terima Pembayaran Otomatis (Midtrans)</span>
                            </li>
                            <li class="flex items-start gap-3 text-gray-700 text-sm font-medium">
                                <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Tarik Saldo Pendapatan ke Rekening</span>
                            </li>
                            
                            <div class="border-t border-gray-100 my-2"></div>

                            <li class="flex items-start gap-3 text-gray-500 text-sm">
                                <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Katalog dibatasi maksimal <strong>5 Menu</strong></span>
                            </li>
                            <li class="flex items-start gap-3 text-gray-500 text-sm">
                                <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>QR Code dibatasi maksimal <strong>5 Meja</strong></span>
                            </li>
                            {{-- <li class="flex items-start gap-3 text-gray-500 text-sm">
                                <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Layanan Mandiri (Tanpa Prioritas CS)</span>
                            </li> --}}
                        </ul>
                        
                        <div class="mt-auto">
                            @guest
                                <a href="/admin/register" class="block w-full py-3.5 text-center bg-white text-[#353535] border border-gray-300 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all shadow-sm">
                                    Coba Gratis Sekarang
                                </a>
                            @endguest
                            @auth
                                <a href="/admin" class="block w-full py-3.5 text-center bg-white text-[#353535] border border-gray-300 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all shadow-sm">
                                    Ke Dashboard Toko
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border-2 border-[#FF801A] shadow-xl overflow-hidden relative transform md:-translate-y-2 flex flex-col">
                    <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-[#FF923C] to-[#FF801A]"></div>
                    {{-- <div class="absolute top-0 right-0 bg-[#FF801A] text-white text-[10px] font-extrabold px-4 py-1.5 rounded-bl-xl tracking-widest uppercase shadow-sm">
                        Paling Laris
                    </div> --}}

                    <div class="p-8 md:p-10 border-b border-gray-100 bg-[#FFF7F0]/40">
                        <span class="inline-block py-1.5 px-3.5 rounded-full bg-[#FF801A]/10 text-[#FF801A] font-bold text-xs tracking-wide uppercase mb-4">Paket Bisnis</span>
                        <div class="flex items-end gap-1 mb-2">
                            <span class="text-4xl font-extrabold text-gray-900">Rp 50.000</span>
                            <span class="text-gray-500 font-medium mb-2">/ Bulan</span>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">Investasi setara 2 porsi makanan untuk membebaskan waktu Anda mengurus antrean kasir.</p>
                    </div>
                    <div class="p-8 md:p-10 bg-white flex flex-col flex-1">
                        <ul class="flex flex-col gap-4 mb-8 flex-1">
                            <li class="flex items-start gap-3 text-gray-900 text-sm font-semibold">
                                <svg class="w-5 h-5 text-[#FF801A] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                <span>Akses Dashboard Kasir & Dapur</span>
                            </li>
                            <li class="flex items-start gap-3 text-gray-900 text-sm font-semibold">
                                <svg class="w-5 h-5 text-[#FF801A] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                <span>Terima Pembayaran Otomatis (Midtrans)</span>
                            </li>
                            <li class="flex items-start gap-3 text-gray-900 text-sm font-semibold">
                                <svg class="w-5 h-5 text-[#FF801A] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                <span>Tarik Saldo Pendapatan ke Rekening</span>
                            </li>
                            
                            <div class="border-t border-gray-100 my-2"></div>

                            <li class="flex items-start gap-3 text-gray-900 text-sm font-bold">
                                <svg class="w-5 h-5 text-[#FF801A] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                <span>Upload Menu <span class="text-[#FF801A] uppercase">Tanpa Batas</span></span>
                            </li>
                            <li class="flex items-start gap-3 text-gray-900 text-sm font-bold">
                                <svg class="w-5 h-5 text-[#FF801A] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                <span>QR Code Meja <span class="text-[#FF801A] uppercase">Tanpa Batas</span></span>
                            </li>
                            {{-- <li class="flex items-start gap-3 text-gray-900 text-sm font-bold">
                                <svg class="w-5 h-5 text-[#FF801A] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                <span>Layanan Kotak Saran & Prioritas CS</span>
                            </li> --}}
                        </ul>       
                        
                        <div class="mt-auto">
                            @guest
                                <a href="/admin/register" class="block w-full py-3.5 text-center bg-[#FF801A] text-white font-bold rounded-xl hover:bg-[#E67317] hover:shadow-lg hover:shadow-[#FF801A]/40 transition-all">
                                    Buka Toko Premium
                                </a>
                            @endguest
                            @auth
                                <a href="/admin" class="block w-full py-3.5 text-center bg-[#FF801A] text-white font-bold rounded-xl hover:bg-[#E67317] hover:shadow-lg hover:shadow-[#FF801A]/40 transition-all">
                                    Berlangganan Sekarang
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-gray-100 py-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xl font-bold text-[#FF801A]">{{ config('app.name') }}</span>
                {{-- <span class="text-gray-400 text-sm">© {{ date('Y') }} All rights reserved.</span> --}}
            </div>
            <div class="flex items-center gap-6 text-sm font-medium text-gray-500">
                <a href="#" class="hover:text-[#FF801A] transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-[#FF801A] transition-colors">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

</body>
</html>