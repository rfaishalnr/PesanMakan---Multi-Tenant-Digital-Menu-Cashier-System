<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajahi Toko - {{ config('app.name') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#FAFAFA] text-[#353535] antialiased">

    <nav class="w-full bg-white shadow-sm py-4 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-[#FF801A] tracking-tight">
                {{ config('app.name', 'PesanMakan') }}<span class="text-[#353535]">.</span>
            </a>
            <a href="/" class="text-sm font-semibold text-gray-500 hover:text-[#FF801A] transition-colors">Kembali ke Home</a>
        </div>
    </nav>

    <div class="w-full bg-white border-b border-gray-100 pb-10 pt-12">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Mau makan apa hari ini?</h1>
            <p class="text-gray-500 mb-8">Temukan berbagai hidangan lezat dari toko kuliner terbaik kami.</p>
            
            <form action="" method="GET" class="relative max-w-2xl mx-auto">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-12 pr-4 py-4 rounded-full border border-gray-200 focus:ring-2 focus:ring-[#FF801A] focus:border-transparent outline-none transition-shadow shadow-sm text-gray-700" placeholder="Cari nama toko kuliner...">
                <button type="submit" class="absolute inset-y-1 right-1 px-6 bg-[#FF801A] text-white font-semibold rounded-full hover:bg-[#E67317] transition-colors">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-16">
        <h2 class="text-xl font-bold text-gray-900 mb-8">
            {{ request('search') ? 'Hasil Pencarian: ' . request('search') : 'Toko Terpopuler' }}
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($stores as $store)
                <div class="group relative bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:border-[#FF801A]/30 transition-all duration-300 flex flex-col">
                    
                    <a href="{{ route('index', $store->username) }}" class="absolute inset-0 z-10"></a>

                    <div class="h-32 bg-gray-200 relative overflow-hidden">
                        @if($store->store_logo)
                            <img src="{{ Storage::url($store->store_logo) }}" alt="{{ $store->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-[#FF801A]/80 to-[#FF923C]/80 opacity-80 group-hover:opacity-100 transition-opacity"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <h2 class="text-4xl font-black text-white/30">{{ strtoupper(substr($store->name, 0, 1)) }}</h2>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-[#FF801A] transition-colors line-clamp-1">{{ $store->name }}</h3>
                        
                        <div class="mt-3 flex flex-col gap-2">
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                                📍 {{ $store->address ?? 'Alamat belum dilengkapi' }}
                            </p>
                            <p class="text-xs text-gray-500 font-medium">
                                📞 {{ $store->phone_number ?? '-' }}
                            </p>
                        </div>
                        
                        <div class="mt-auto pt-4 flex items-center justify-between gap-2 border-t border-gray-50 relative z-20">
                            @if($store->address)
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($store->name . ' ' . $store->address) }}" target="_blank" class="relative z-30 px-3 py-1.5 bg-gray-100 text-gray-600 text-xs font-semibold rounded-lg hover:bg-gray-200 transition-colors flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                Maps
                            </a>
                            @endif

                            <span class="text-sm font-semibold text-[#FF801A] flex items-center gap-1 ml-auto pointer-events-none">
                                Buka Menu <span class="group-hover:translate-x-1 transition-transform">→</span>
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada toko</h3>
                    <p class="text-gray-500 mt-1">Jadilah yang pertama membuka toko di platform PesanMakan!</p>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>