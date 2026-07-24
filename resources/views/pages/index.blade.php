@extends('layouts.app')

@section('content')
    <div id="Background"
        class="absolute top-0 w-full h-[170px] rounded-b-[45px] bg-[linear-gradient(90deg,#FF923C_0%,#FF801A_100%)]">
    </div>

    <div id="TopNav" class="relative flex flex-col px-5 mt-[20px] h-[170px]">
        <div class="relative flex items-center justify-between">
            
            @if(auth()->check() && auth()->user()->role === 'store')
                <a href="{{ url('/admin') }}" class="w-11 h-11 flex items-center justify-center shrink-0 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 transition-all text-white backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @else
                <div class="w-11 h-11 flex shrink-0"></div>
            @endif

            <div class="flex flex-col items-center gap-0.5 text-center">
                <p class="text-white/80 text-xs font-medium uppercase tracking-wider">Toko Kuliner</p>
                <h1 class="text-white font-bold text-lg leading-none line-clamp-1 max-w-[180px]">{{ $store->name }}</h1>
            </div>

            <a href="#" class="w-11 h-11 flex items-center justify-center shrink-0 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 transition-all text-white backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            </a>
            
        </div>

        <h1 class="text-white font-[600] text-2xl leading-[30px] mt-[20px]">Order Delicious Meal!</h1>

        <form action="{{ route('product.find.results', $store->username) }}" method="GET" class="absolute bottom-0 left-0 right-0 w-full gap-2 px-5">
            <label
                class="flex items-center w-full rounded-full p-[8px_8px] gap-3 bg-white ring-1 ring-[#F1F2F6] focus-within:ring-[#F3AF00] transition-all duration-300 shadow-sm">
                <div class="pl-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 shrink-0 text-[#FF801A]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <input type="text" name="search"
                    class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-light"
                    placeholder="Search menu, or etc...">
            </label>
        </form>
    </div>

    <div id="Categories" class="relative flex flex-col px-5 mt-[20px]">
        <div class="flex items-end justify-between ">
            <h1 class="text-[#353535] font-[500] text-lg">Explore Categories</h1>
            <a href="{{ route('product.find.results', $store->username) }}" class="text-[#FF801A] text-sm font-medium">See All</a>
        </div>

        <div class="swiper w-full">
            <div class="swiper-wrapper mt-[20px]">
                @foreach ($store->productCategories as $category)
                    <a href="{{ route('product.find.results', $store->username) . '?category=' . $category->slug }}" class="swiper-slide !w-fit mr-4">
                        <div class="flex flex-col items-center w-[75px] shrink-0 gap-2 text-center">
                            <div class="w-[64px] h-[64px] rounded-full flex items-center justify-center shrink-0 overflow-hidden p-3 bg-[#9393931A] bg-opacity-10 hover:bg-[#FFF7F0] transition-all">
                                <img src="{{ Storage::url($category->icon) }}" class="w-full h-full object-contain" alt="icon">
                            </div>
                            <div class="flex flex-col gap-[2px]">
                                <h3 class="font-light text-[#504D53] text-[13px] leading-tight">{{ $category->name }}</h3>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div id="Favorites" class="relative flex flex-col px-5 mt-[20px]">
        <div class="flex items-end justify-between">
            <h1 class="text-[#353535] font-[500] text-lg">Menu Favorite</h1>
            <a href="{{ route('product.find.results', $store->username) }}" class="text-[#FF801A] text-sm font-medium">See All</a>
        </div>

        <div class="swiper w-full">
            <div class="swiper-wrapper mt-[10px] pb-4">
                @foreach ($populars as $popular)
                    <div class="swiper-slide !w-fit mr-4">
                        <a href="{{ route('product.show', ['username' => $store->username, 'id' => $popular->id]) }}" class="card">
                            <div class="flex flex-col w-[210px] shrink-0 rounded-[8px] bg-white p-[12px] pb-5 gap-[10px] hover:bg-[#FFF7F0] hover:border-[1px] hover:border-[#F3AF00] transition-all duration-300 shadow-sm cursor-pointer">
                                <div class="position-relative flex w-full h-[150px] shrink-0 rounded-[8px] bg-[#D9D9D9] overflow-hidden relative">
                                    <img src="{{ Storage::url($popular->image) }}" class="w-full h-full object-cover" alt="thumbnail">

                                    <div class="absolute top-3 right-3 flex items-center gap-1 bg-white px-[8px] py-[4px] rounded-full shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-[#F3AF00]">
                                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                        </svg>
                                        <p class="text-sm font-semibold">{{ $popular->rating }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 mt-1">
                                    <p class="text-[#F3AF00] font-[400] text-[12px]">{{ $popular->productCategory->name }}</p>
                                    <h3 class="text-[#353535] font-[500] text-[14px] truncate">{{ $popular->name }}</h3>
                                    <p class="text-[#606060] font-[400] text-[10px] line-clamp-2">{{ $popular->description }}</p>
                                </div>

                                <div class="flex items-center justify-between mt-auto pt-2">
                                    <p class="text-[#FF001A] font-[600] text-[14px]">Rp {{ number_format($popular->price) }}</p>
                                    <button type="button" class="flex items-center justify-center w-[32px] h-[32px] rounded-full bg-transparent hover:scale-110 transition-transform relative z-10" data-id="{{ $popular->id }}" onclick="event.preventDefault(); addToCart(this.dataset.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-[#FF801A]">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="Recomendations" class="relative flex flex-col px-5 mt-[20px] mb-32">
        <div class="flex items-end justify-between ">
            <h1 class="text-[#353535] font-[500] text-lg">Chef's Recommendations</h1>
            <a href="{{ route('product.find.results', $store->username) }}" class="text-[#FF801A] text-sm font-medium">See All</a>
        </div>
        <div class="flex flex-col gap-4 mt-[10px]">
            @foreach ($products as $product)
                <a href="{{ route('product.show', ['username' => $store->username, 'id' => $product->id]) }}" class="card">
                    <div class="flex rounded-[8px] border border-[#F1F2F6] p-[12px] gap-4 bg-white hover:bg-[#FFF7F0] hover:border-[1px] hover:border-[#F3AF00] transition-all duration-300 shadow-sm">
                        <img src="{{ Storage::url($product->image) }}" class="w-[100px] h-[100px] shrink-0 object-cover rounded-[8px]" alt="thumbnail">
                        
                        <div class="flex flex-col gap-1 w-full justify-center">
                            <p class="text-[#F3AF00] font-[400] text-[12px]">{{ $product->productCategory->name }}</p>
                            <h3 class="text-[#353535] font-[500] text-[14px] line-clamp-1">{{ $product->name }}</h3>
                            <p class="text-[#606060] font-[400] text-[10px] line-clamp-2">{{ $product->description }}</p>

                            <div class="flex items-center justify-between mt-auto pt-2">
                                <p class="text-[#FF001A] font-[600] text-[14px]">Rp {{ number_format($product->price) }}</p>
                                <button type="button" class="flex items-center justify-center w-[32px] h-[32px] rounded-full bg-transparent hover:scale-110 transition-transform relative z-10" data-id="{{ $product->id }}" onclick="event.preventDefault(); addToCart(this.dataset.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-[#FF801A]">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    @include('includes.navigation')
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Mengecek apakah ada parameter '?table=' di URL
            const urlParams = new URLSearchParams(window.location.search);
            const tableNumber = urlParams.get('table');

            // Jika ada, simpan ke memori HP pelanggan (localStorage)
            if (tableNumber) {
                localStorage.setItem('scanned_table_number', tableNumber);
                console.log("Nomor meja tersimpan:", tableNumber);
            }
        });
    </script>
@endsection