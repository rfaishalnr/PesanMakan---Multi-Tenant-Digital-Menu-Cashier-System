@extends('layouts.app')

@section('content')
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

    <div id="TopNav" class="relative flex items-center justify-between px-5 py-3 bg-white">
        <a href="{{ route('index', $store->username) }}"
            class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-[#F0F1F3]">
            <img src="{{ asset('assets/images/icons/Arrow - Left.svg') }}" class="w-[28px] h-[28px]" alt="icon">
        </a>
        <p class="font-semibold">My Cart</p>
        <div class="dummy-btn w-12"></div>
    </div>

    <div id="Cart" class="flex flex-col gap-4 mt-[10px] px-5">

        @foreach ($store->products as $product)
            <div class="cart-item flex gap-4 flex-col rounded-[8px] border border-[#F1F2F6] p-[12px] bg-white hover:bg-[#FFF7F0] hover:border-[1px] hover:border-[#F3AF00] transition-all duration-300"
                style="display: none;" data-id="{{ $product->id }}">
                <div class="flex gap-4">
                    <div class="w-[128px] h-[88px]">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full object-cover rounded-[8px]"
                            alt="icon">
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <div class="flex items-center justify-between">
                            <p class="text-[#F3AF00] font-[400] text-[12px]">
                                {{ $product->productCategory->name }}
                            </p>

                            <a href="#" class="text-[#FF001A] font-[400] text-[12px] ml-2" data-id="{{ $product->id }}" onclick="deleteItem(this)">
                                Delete
                            </a>
                        </div>
                        <h3 class="text-[#353535] font-[500] text-[14px]">
                            {{ $product->name }}
                        </h3>
                        <p class="text-[#606060] font-[400] text-[10px]">
                            {{ $product->description }}
                        </p>

                        <div class="flex items-center justify-between ">
                            <p class="text-[#FF001A] font-[600] text-[14px]" data-id="{{ $product->id }}" data-price="{{ $product->price }}" id="price-{{ $product->id }}">
                                Rp {{ number_format($product->price) }}
                            </p>
                            
                            <div class="flex items-center gap-1">
                                <button type="button"
                                    class="flex items-center justify-center w-[24px] h-[24px] rounded-full bg-transparent"
                                    data-id="{{ $product->id }}" onclick="decreaseQuantity(this.dataset.id)">
                                    <img src="{{ asset('assets/images/icons/ic_minus.svg') }}" class="w-full h-full"
                                        alt="icon">
                                </button>

                                <input type="number" 
                                    id="qty-{{ $product->id }}" 
                                    class="w-[20px] px-0 text-center text-[#FF001A] font-[600] text-[14px] bg-transparent outline-none"
                                    value="1" 
                                    min="1"
                                    oninput="debounceCalculate()">

                                <button type="button"
                                    class="flex items-center justify-center w-[24px] h-[24px] rounded-full bg-transparent"
                                    data-id="{{ $product->id }}" onclick="increaseQuantity(this.dataset.id)">
                                    <img src="{{ asset('assets/images/icons/ic_plus.svg') }}" class="w-full h-full" alt="icon">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <label
                    class="flex items-center w-full rounded-[8px] p-[8px] gap-3 bg-white ring-1 ring-[#F3AF003D] ring-opacity-5 focus-within:ring-[#F3AF00] focus-within:ring-opacity-100 transition-all duration-300">
                    <img src="{{ asset('assets/images/icons/Edit.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                    <input type="text" name="notes" id="notes-{{ $product->id }}" data-id="{{ $product->id }}"
                        class="appearance-none outline-none w-full font-regular placeholder:text-ngekos-grey placeholder:font-normal"
                        placeholder="Write notes...">
                </label>
            </div>
        @endforeach

    </div>

    <div class="fixed inset-x-0 bottom-0 max-w-[640px] z-50 bg-white shadow-sm mx-auto">
        <div class="flex items-center justify-between p-[20px]">
            <div class="flex flex-col gap-2">
                <p class="text-[#606060] font-[400] text-[14px]">
                    Total Price
                </p>
                <p class="font-[600] text-[18px]" id="totalAmount">
                    Rp 0
                </p>
            </div>

            <a href="{{ route('customer-information', $store->username) }}" type="button" onclick="saveCartState()"
                class="flex justify-center rounded-full p-[14px_28px] bg-[#FF801A] font-normal text-white">
                Checkout
            </a>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let calcTimeout; 

    document.addEventListener("DOMContentLoaded", function () {
        loadCart();
    });

    function increaseQuantity(id) {
        let input = document.getElementById('qty-' + id);
        input.value = parseInt(input.value || 0) + 1;
        debounceCalculate();
    }

    function decreaseQuantity(id) {
        let input = document.getElementById('qty-' + id);
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            debounceCalculate();
        }
    }

    function debounceCalculate() {
        clearTimeout(calcTimeout);
        calcTimeout = setTimeout(() => {
            calculateTotal();
            saveCartState();
        }, 400); 
    }

    function calculateTotal() {
        let total = 0;
        
        document.querySelectorAll('.cart-item').forEach(item => {
            if (item.style.display !== 'none') {
                let id = item.getAttribute('data-id');
                let qty = parseInt(document.getElementById('qty-' + id).value) || 1;
                let priceElement = document.getElementById('price-' + id);
                let price = parseInt(priceElement.getAttribute('data-price')) || 0;

                total += (qty * price);
            }
        });

        document.getElementById('totalAmount').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }

    function loadCart() {
        let cart = JSON.parse(localStorage.getItem('pesanmakan_cart')) || [];
        
        cart.forEach(cartItem => {
            let itemElement = document.querySelector(`.cart-item[data-id="${cartItem.id}"]`);
            if (itemElement) {
                itemElement.style.display = 'flex'; 
                document.getElementById('qty-' + cartItem.id).value = cartItem.qty;
                
                if(cartItem.notes) {
                    document.getElementById('notes-' + cartItem.id).value = cartItem.notes;
                }
            }
        });

        calculateTotal();
    }

    function deleteItem(element) {
        let id = element.getAttribute('data-id');
        let itemElement = document.querySelector(`.cart-item[data-id="${id}"]`);
        
        if (itemElement) {
            itemElement.style.display = 'none'; 
            document.getElementById('qty-' + id).value = 1; 
            document.getElementById('notes-' + id).value = ''; 
        }

        debounceCalculate();
    }

    function saveCartState() {
        let cart = [];
        document.querySelectorAll('.cart-item').forEach(item => {
            if (item.style.display !== 'none') {
                let id = item.getAttribute('data-id');
                let qty = parseInt(document.getElementById('qty-' + id).value) || 1;
                let notes = document.getElementById('notes-' + id).value;

                cart.push({
                    id: id,
                    qty: qty,
                    notes: notes
                });
            }
        });

        localStorage.setItem('pesanmakan_cart', JSON.stringify(cart));
    }
</script>
@endsection