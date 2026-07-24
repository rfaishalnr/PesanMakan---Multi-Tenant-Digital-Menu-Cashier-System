@extends('layouts.app')

@section('content')

    <div id="TopNavAbsolute"
        class="absolute top-0 left-0 right-0 flex items-center justify-between w-full px-5 py-3 z-10 bg-gradient-to-b from-black/80 to-transparent">
        <a href="{{ route('index', $store->username) }}"
            class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white/10">
            <img src="{{ asset('assets/images/icons/Arrow - Left.svg') }}" class="w-8 h-8" alt="icon">
        </a>
        <p class="font-semibold text-white">Details</p>
        <button class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white/10">
            <img src="{{ asset('assets/images/icons/Thumbs Up.svg') }}" class="w-[26px] h-[26px]" alt="">
        </button>
    </div>

    <div id="Image" class="relative w-full overflow-x-hidden -mb-[38px]">
        <img src="{{ Storage::url($products->image) }}" alt="product image" class="w-full h-[500px] object-cover">

        <div class="absolute bottom-20 right-5 flex items-center gap-1  bg-white/10 px-[8px] py-[4px] rounded-full">
            <img src="{{ asset('assets/images/icons/ic_check.svg') }}" alt="rating" class="w-4 h-4">
            <p class="text-white text-sm">{{ $products->rating }}</p>
        </div>
    </div>

    <div class="flex flex-col w-full px-5 py-5 gap-5 bg-white rounded-t-[20px] shadow-sm mt-[-20px] z-10">
        <div id="Title">
            <p class="text-[#F3AF00] font-[400] text-[12px]">
                {{ $products->productCategory->name }}
            </p>
            <h1 class="text-[26px] font-semibold">{{ $products->name }}</h1>
            <p class="text-[#606060] font-[400] text-[14px]">
                {{ $products->description }}
            </p>
        </div>

        @if ($products->ingredients && $products->ingredients->count() > 0)
            <div id="Ingredients">
                <h2 class="font-[500] mb-3">Ingredients used</h2>
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($products->ingredients as $ingredient)
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/images/icons/ic_check.svg') }}" alt="icon" class="w-5 h-5">
                            <span class="text-sm text-gray-600">{{ $ingredient->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div id="Reviews" class="pb-28">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-[500]">Customer Reviews</h2>
                <span class="text-xs text-gray-500">{{ $products->reviews()->count() }} Ulasan</span>
            </div>

            <div class="swiper-slide !w-fit mr-4">
                <div class="swiper-wrapper">
                    @forelse ($products->reviews()->latest()->get() as $review)
                        <div class="swiper-slide !w-fit">
                            <div
                                class="flex flex-col gap-3 w-[320px] border border-gray-200 hover:border-[#F3AF00] hover:bg-[#FFF7F0] hover:cursor-pointer rounded-[8px] p-4 transition-colors">
                                <div class="flex items-center justify-between gap-3">
                                    <h3 class="text-[#353535] font-[500] text-[14px] line-clamp-1">
                                        {{ $review->customer_name }}
                                    </h3>

                                    <div class="flex items-center gap-1 shrink-0">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-[#F3AF00]' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-[#606060] font-[400] text-[14px] line-clamp-3">
                                    "{{ $review->comment }}"
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="w-full p-4 text-center border border-dashed border-gray-300 rounded-lg">
                            <p class="text-sm text-gray-500">Belum ada ulasan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <button type="button" onclick="document.getElementById('formReviewCard').classList.toggle('hidden')"
                class="w-full flex items-center justify-center gap-2 py-3 rounded-full border border-[#FF801A] text-[#FF801A] font-semibold text-sm hover:bg-[#FF801A] hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Tulis Ulasan Anda
            </button>

            <div id="formReviewCard" class="hidden mt-4 bg-gray-50 p-5 rounded-xl border border-gray-100 shadow-inner">
                <h3 class="font-[600] text-[14px] mb-4">Bagaimana rasa menu ini?</h3>
                <form action="{{ route('product.review.store', $products->id) }}" method="POST"
                    class="flex flex-col gap-3">
                    @csrf

                    <div>
                        <input type="text" name="customer_name" placeholder="Nama Anda" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-[#FF801A] focus:ring-1 focus:ring-[#FF801A]">
                    </div>

                    <div>
                        <select name="rating" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-[#FF801A] focus:ring-1 focus:ring-[#FF801A] bg-white">
                            <option value="" disabled selected>Beri Rating (Bintang)</option>
                            <option value="5">⭐⭐⭐⭐⭐ (5/5) - Sangat Enak!</option>
                            <option value="4">⭐⭐⭐⭐ (4/5) - Enak</option>
                            <option value="3">⭐⭐⭐ (3/5) - Lumayan</option>
                            <option value="2">⭐⭐ (2/5) - Kurang</option>
                            <option value="1">⭐ (1/5) - Kecewa</option>
                        </select>
                    </div>

                    <div>
                        <textarea name="comment" rows="3" placeholder="Ceritakan pengalaman Anda menyantap menu ini..."
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-[#FF801A] focus:ring-1 focus:ring-[#FF801A]"></textarea>
                    </div>

                    <button type="submit" 
                    style="background-color: #FF801A; color: white; display: flex; width: 100%; justify-content: center; padding: 14px; border-radius: 12px; font-weight: bold;"
                    class="hover:bg-[#E67317] shadow-md hover:shadow-xl transition-all duration-300 gap-2 items-center group">
                    <span>Kirim Ulasan</span>
                    <svg class="w-5 h-5 text-white group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
                </form>
            </div>
        </div>

        <div class="fixed inset-x-0 bottom-0 max-w-[640px] z-50 bg-white shadow-sm mx-auto">
            <div class="flex items-center justify-between p-[20px]">
                <div class="flex flex-col  gap-2">
                    <p class="text-[#606060] font-[400] text-[14px]">
                        Menu Price
                    </p>
                    <p class="font-[600] text-[18px]">
                        Rp {{ number_format($products->price) }}
                    </p>
                </div>

                <button type="button"
                    class="flex justify-center rounded-full p-[14px_28px] bg-[#FF801A] font-normal text-white"
                    data-id="{{ $products->id }}" onclick="addToCart(this.dataset.id)">
                    Add To Cart
                </button>
            </div>
        </div>

    @endsection
