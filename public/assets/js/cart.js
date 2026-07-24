document.addEventListener("DOMContentLoaded", function () {
    const cartData = JSON.parse(localStorage.getItem("cart")) || [];

    // 1. PENTING: Suntikkan data cart ke form rahasia untuk dikirim ke Laravel saat Checkout
    const cartInputForm = document.getElementById("cart-data");
    if (cartInputForm) {
        cartInputForm.value = JSON.stringify(cartData);
    }

    const cartItems = document.querySelectorAll(".cart-item");
    cartItems.forEach((item) => {
        const productId = item.dataset.id;
        const cartProduct = cartData.find((cart) => cart.id === productId);

        if (!cartProduct) {
            item.remove();
        } else {
            // Munculkan elemennya
            item.style.display = 'flex'; 
            
            const qtyElement = item.querySelector("#qty");
            // PERBAIKAN: Gunakan pemilih name="..." karena id="notes" itu kembar di banyak produk
            const notesInput = item.querySelector("input[name='notes']"); 

            if (qtyElement) qtyElement.textContent = cartProduct.qty;
            
            if (notesInput) {
                // Tampilkan notes yang tersimpan, gunakan string kosong jika undefined
                notesInput.value = cartProduct.notes || "";

                // Simpan otomatis ke localStorage setiap kali user mengetik
                if (!notesInput.readOnly) {
                    notesInput.oninput = function(e) {
                        let currentCart = JSON.parse(localStorage.getItem("cart")) || [];
                        let product = currentCart.find(c => c.id === productId);
                        if (product) {
                            product.notes = e.target.value;
                            localStorage.setItem("cart", JSON.stringify(currentCart));
                            
                            // Update juga form rahasia agar backend Laravel selalu dapat data terbaru
                            if (cartInputForm) {
                                cartInputForm.value = JSON.stringify(currentCart);
                            }
                        }
                    };
                }
            }
        }
    });

    calculateTotal();
});

function calculateTotal() {
    const prices = document.querySelectorAll('p[id="price"]');
    let total = 0;
    prices.forEach(priceElement => {
        const price = parseInt(priceElement.textContent.replace(/[^0-9]/g, ''), 10);
        const qty = parseInt(priceElement.closest('.flex').querySelector('#qty').textContent, 10);
        total += price * qty;
    });
    document.getElementById('totalAmount').textContent = `Rp ${total.toLocaleString('id-ID')}`;
}

// --- TAMBAHKAN FUNGSI INI DI DALAM cart.js ---

// Fungsi untuk memasukkan item ke keranjang
function addToCart(productId) {
    // Ambil data keranjang saat ini, atau buat array kosong jika belum ada
    let cartData = JSON.parse(localStorage.getItem("cart")) || [];

    // Cek apakah produk sudah ada di dalam keranjang
    const existingProduct = cartData.find(cart => cart.id === productId);

    if (existingProduct) {
        // Jika sudah ada, tambahkan quantity-nya
        existingProduct.qty += 1;
    } else {
        // Jika belum ada, masukkan sebagai produk baru
        cartData.push({
            id: String(productId), // Pastikan ID berupa string
            qty: 1,
            notes: ""
        });
    }

    // Simpan kembali ke localStorage
    localStorage.setItem("cart", JSON.stringify(cartData));
    alert("Menu berhasil ditambahkan ke keranjang!");
}

// Fungsi untuk menambah quantity di halaman Cart
function increaseQuantity(productId) {
    let cartData = JSON.parse(localStorage.getItem("cart")) || [];
    const product = cartData.find(cart => cart.id === String(productId));
    
    if (product) {
        product.qty += 1;
        localStorage.setItem("cart", JSON.stringify(cartData));
        window.location.reload(); // Reload untuk memperbarui tampilan
    }
}

// Fungsi untuk mengurangi quantity di halaman Cart
function decreaseQuantity(productId) {
    let cartData = JSON.parse(localStorage.getItem("cart")) || [];
    const product = cartData.find(cart => cart.id === String(productId));
    
    if (product && product.qty > 1) {
        product.qty -= 1;
        localStorage.setItem("cart", JSON.stringify(cartData));
        window.location.reload();
    }
}

// Fungsi untuk menghapus item dari keranjang
function deleteItem(element) {
    const productId = element.dataset.id;
    let cartData = JSON.parse(localStorage.getItem("cart")) || [];
    
    // Filter out / buang produk yang mau dihapus
    cartData = cartData.filter(cart => cart.id !== String(productId));
    
    localStorage.setItem("cart", JSON.stringify(cartData));
    window.location.reload();
}

