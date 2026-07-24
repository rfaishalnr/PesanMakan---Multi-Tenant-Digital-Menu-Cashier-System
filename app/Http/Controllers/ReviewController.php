<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // 1. Validasi input dari pembeli
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // 2. Simpan ulasan ke database
        $product->reviews()->create([
            'customer_name' => $request->customer_name,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // 3. LOGIKA OTOMATISASI RATING (TAMBAHAN BARU)
        // Menghitung rata-rata dari kolom 'rating' di tabel product_reviews khusus produk ini
        $averageRating = $product->reviews()->avg('rating');

        // Update nilai rating di tabel products (dibulatkan 1 angka di belakang koma, misal 4.6)
        $product->update([
            'rating' => round($averageRating, 1)
        ]);

        // 4. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}