function selectPayment(method) {
    // 1. Reset warna semua tombol kembali ke abu-abu standar
    document.getElementById('btn-cash').classList.remove('bg-[#FF801A]', 'text-white');
    document.getElementById('btn-cash').classList.add('bg-[#F1F2F6]', 'text-[#353535]');

    document.getElementById('btn-midtrans').classList.remove('bg-[#FF801A]', 'text-white');
    document.getElementById('btn-midtrans').classList.add('bg-[#F1F2F6]', 'text-[#353535]');

    // 2. Aktifkan warna oranye pada tombol yang dipilih dan centang input radionya
    if (method === 'cash') {
        document.getElementById('cash').checked = true;
        document.getElementById('btn-cash').classList.remove('bg-[#F1F2F6]', 'text-[#353535]');
        document.getElementById('btn-cash').classList.add('bg-[#FF801A]', 'text-white');
        
    } else if (method === 'midtrans') {
        document.getElementById('midtrans').checked = true;
        document.getElementById('btn-midtrans').classList.remove('bg-[#F1F2F6]', 'text-[#353535]');
        document.getElementById('btn-midtrans').classList.add('bg-[#FF801A]', 'text-white');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    paymentMethods.forEach((element) => {
        element.addEventListener('click', () => {
            selectPayment(element.value);
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    // Ambil data cart dari localStorage
    const cartData = JSON.parse(localStorage.getItem("cart")) || [];

    // Filter produk berdasarkan ID di cartData
    const cartItems = document.querySelectorAll(".cart-item");
    cartItems.forEach((item) => {
        const productId = item.dataset.id;

        // Cari produk di cartData
        const cartProduct = cartData.find((cart) => cart.id === productId);

        if (!cartProduct) {
            // Jika produk tidak ada di cart, hapus
            item.remove();
        } else {
            // Jika ada, update quantity dan notes
            const qtyElement = item.querySelector("#qty");
            const notesInput = item.querySelector("#notes");

            if (qtyElement) qtyElement.textContent = 'x' + cartProduct.qty;
            if (notesInput) notesInput.value = cartProduct.notes;
        }
    });

    // Hitung total setelah elemen yang tidak ada dihapus
    calculateTotal();
});

function calculateTotal() {
    const cartItems = document.querySelectorAll(".cart-item");
    let total = 0;
    cartItems.forEach(cartItem => {
        const priceElement = cartItem.querySelector('p[id="price"]');
        const price = parseInt(priceElement.textContent.replace(/[^0-9]/g, ''), 10);
        const qtyElement = cartItem.querySelector('#qty');
        const qty = parseInt(qtyElement.textContent.replace(/[^0-9]/g, ''), 10);
        total += price * qty;
    });
    document.getElementById('totalAmount').textContent = `Rp ${total.toLocaleString('id-ID')}`;
}

const paymentForm = document.getElementById('Form');
const cartData = document.getElementById('cart-data');

paymentForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    cartData.value = JSON.stringify(cart);

    paymentForm.submit();

    localStorage.removeItem("cart");
});
