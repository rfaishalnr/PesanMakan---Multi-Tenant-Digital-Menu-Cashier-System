@php
    $currentRoute = Route::currentRouteName();
@endphp

<div class="fixed inset-x-0 bottom-0 max-w-[640px] z-50 bg-white shadow-[0_-4px_15px_rgba(0,0,0,0.05)] mx-auto rounded-t-[20px]">
    <div class="flex items-center justify-around px-6 py-4">
        
        <!-- Menu 1: Home -->
        <a href="{{ route('index', $store->username ?? '') }}" class="flex flex-col items-center gap-1 transition-all duration-300">
            @if ($currentRoute == 'index')
                <img src="{{ asset('assets/images/icons/Home.svg') }}" class="w-[26px] h-[26px] object-contain" alt="Home Active">
            @else
                <img src="{{ asset('assets/images/icons/Home_Default.svg') }}" class="w-[26px] h-[26px] object-contain opacity-80" alt="Home Inactive">
            @endif
            <p class="{{ $currentRoute == 'index' ? 'text-[#FF801A] font-semibold' : 'text-[#606060] font-normal' }} text-[11px] mt-[2px]">
                Home
            </p>
        </a>

        <!-- Menu 2: Cart -->
        <a href="{{ route('cart', $store->username ?? '') }}" class="flex flex-col items-center gap-1 transition-all duration-300">
            <div class="relative flex items-center justify-center">
                <img src="{{ asset('assets/images/icons/Buy.svg') }}" class="w-[26px] h-[26px] object-contain {{ $currentRoute == 'cart' ? '' : 'opacity-80' }}" alt="Cart">
                
                <!-- WADAH BADGE KOSONG -->
                <div id="cart-badge-wrapper"></div>
                
            </div>
            <p class="{{ $currentRoute == 'cart' ? 'text-[#FF801A] font-semibold' : 'text-[#606060] font-normal' }} text-[11px] mt-[2px]">
                Cart
            </p>
        </a>

        <!-- Menu 3: Find -->
        <a href="{{ route('product.find', $store->username ?? '') }}" class="flex flex-col items-center gap-1 transition-all duration-300">
            @if (Str::startsWith($currentRoute, 'product.find'))
                <img src="{{ asset('assets/images/icons/Search.svg') }}" class="w-[26px] h-[26px] object-contain" alt="Find Active">
            @else
                <img src="{{ asset('assets/images/icons/Search_default.svg') }}" class="w-[26px] h-[26px] object-contain opacity-80" alt="Find Inactive">
            @endif
            <p class="{{ Str::startsWith($currentRoute, 'product.find') ? 'text-[#FF801A] font-semibold' : 'text-[#606060] font-normal' }} text-[11px] mt-[2px]">
                Find
            </p>
        </a>

        <!-- Menu 4: Pesanan -->
        <a href="#" onclick="checkLastOrderNav(event)" id="nav-pesanan" class="hidden flex-col items-center gap-1 transition-all duration-300">
            @if ($currentRoute == 'success')
                <div class="w-[26px] h-[26px] flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-[26px] h-[26px] text-[#FF801A]">
                        <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 004.25 22.5h15.5a1.875 1.875 0 001.865-2.071l-1.263-12a1.875 1.875 0 00-1.865-1.679H16.5V6a4.5 4.5 0 10-9 0zM12 3a3 3 0 00-3 3v.75h6V6a3 3 0 00-3-3zm-3 8.25a3 3 0 106 0v-.75a.75.75 0 011.5 0v.75a4.5 4.5 0 11-9 0v-.75a.75.75 0 011.5 0v.75z" clip-rule="evenodd" />
                    </svg>
                </div>
            @else
                <div class="w-[26px] h-[26px] flex items-center justify-center opacity-80">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-[26px] h-[26px] text-[#606060]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                    </svg>
                </div>
            @endif
            <p class="{{ $currentRoute == 'success' ? 'text-[#FF801A] font-semibold' : 'text-[#606060] font-normal' }} text-[11px] mt-[2px]">
                Pesanan
            </p>
        </a>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cartData = JSON.parse(localStorage.getItem("cart")) || [];
        const badgeWrapper = document.getElementById("cart-badge-wrapper");
        
        let totalItems = 0;
        cartData.forEach(item => {
            totalItems += parseInt(item.qty) || 0;
        });

        if (totalItems > 0) {
            let countText = totalItems > 99 ? '99+' : totalItems;
            
            // PERBAIKAN FINAL: Menggunakan Inline CSS Style agar 100% Anti-Gepeng
            badgeWrapper.innerHTML = `
                <div class="absolute flex items-center justify-center rounded-full bg-[#FF001A] ring-2 ring-white shadow-sm" 
                     style="top: -6px; right: -8px; height: 18px; min-width: 18px; padding: 0 5px;">
                    <span class="text-white font-bold leading-none" style="font-size: 10px;">${countText}</span>
                </div>
            `;
        } else {
            badgeWrapper.innerHTML = ''; 
        }

        let history = JSON.parse(localStorage.getItem('pesanmakan_orders') || '[]');
        const navPesanan = document.getElementById('nav-pesanan');
        
        if (history.length > 0) {
            navPesanan.classList.remove('hidden'); 
            navPesanan.classList.add('flex'); 
        }
    });

    function checkLastOrderNav(e) {
        e.preventDefault();
        let history = JSON.parse(localStorage.getItem('pesanmakan_orders') || '[]');
        
        if (history.length > 0) {
            let lastOrder = history[history.length - 1];
            window.location.href = "{{ route('success') }}?order_id=" + lastOrder;
        }
    }
</script>