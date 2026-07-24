<?php

use App\Models\User;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Models\Transaction;

// 1. RUTE STATIS (Harus ditaruh paling atas)
Route::get('/', function () {
    return view('pages.landingpage');
})->name('landingpage');

Route::get('/stores', function () {
    $stores = User::where('role', 'store')->get(); 
    return view('pages.stores', compact('stores'));
})->name('stores.list');

// KITA PINDAHKAN SITEMAP KE SINI (Di atas wildcard)
Route::get('/sitemap.xml', function () {
    $stores = User::where('role', 'store')->get(); 
    
    return response()->view('sitemap', [
        'stores' => $stores
    ])->header('Content-Type', 'text/xml');
});


// 2. RUTE TRANSAKSI / SISTEM
Route::get('/transaction/success', [TransactionController::class, 'success'])->name('success');
Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('product.review.store');
Route::get('/payment/upload/{order_id}', [TransactionController::class, 'uploadPayment'])->name('payment.upload');
Route::post('/payment/upload/{order_id}', [TransactionController::class, 'processUpload'])->name('payment.process');

Route::post('/transaksi/{id}/selesai', function($id) {
    $transaction = Transaction::findOrFail($id);
    
    if ($transaction->status === 'ready') {
        $transaction->update(['status' => 'completed']);
    }
    
    return back();
})->name('transaction.complete');


// 3. RUTE WILDCARD / TOKO (WAJIB DITARUH PALING BAWAH)
Route::get('/{username}', [FrontendController::class, 'index'])->name('index');
Route::get('/{username}/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/{username}/find-product', [ProductController::class, 'find'])->name('product.find');
Route::get('/{username}/find-product/results', [ProductController::class, 'findResults'])->name('product.find.results');
Route::get('/{username}/cart', [TransactionController::class, 'cart'])->name('cart');
Route::get('/{username}/customer-information', [TransactionController::class, 'customerInformation'])->name('customer-information');
Route::post('/{username}/checkout', [TransactionController::class, 'checkout'])->name('checkout');