<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function cart(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        return view('pages.cart', compact('store'));
    }

    public function customerInformation(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        return view('pages.customer-information', compact('store'));
    }

    public function checkout(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        $carts = json_decode($request->cart, true);

        if (empty($carts) || !is_array($carts)) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong atau tidak valid.');
        }

        return DB::transaction(function () use ($request, $store, $carts) {
            $totalPrice = 0;
            foreach ($carts as $cart) {
                $product = Product::find($cart['id']);
                if (!$product) {
                    abort(404, 'Produk tidak ditemukan.');
                }
                $totalPrice += $product->price * $cart['qty'];
            }

            $transaction = $store->transactions()->create([
                'code' => 'TRX-' . mt_rand(10000, 99999),
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'table_number' => $request->table_number,
                'payment_method' => $request->payment_method, // Akan terisi 'cash' atau 'midtrans'
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($carts as $cart) {
                $product = Product::find($cart['id']);
                $transaction->transactionDetails()->create([
                    'product_id' => $product->id,
                    'quantity' => $cart['qty'],
                    'note' => $cart['notes'],
                ]);
            }

            // JIKA USER MEMILIH MIDTRANS (BAYAR ONLINE)
            if ($request->payment_method == 'midtrans') {
                Config::$serverKey = env('MIDTRANS_SERVER_KEY');
                Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
                Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
                Config::$is3ds = env('MIDTRANS_IS_3DS');
            
                $params = [
                    'transaction_details' => [
                        'order_id' => $transaction->code, 
                        'gross_amount' => (int) $totalPrice,
                    ],
                    'customer_details' => [
                        'first_name' => $transaction->name,
                        'phone' => $transaction->phone_number,
                    ],
                ];
            
                $snapToken = Snap::getSnapToken($params);
                $transaction->update(['snap_token' => $snapToken]);
            
                return view('pages.payment-midtrans', compact('transaction', 'snapToken', 'store'));
            }
            
            // JIKA USER MEMILIH CASH
            if ($request->payment_method == 'cash') {
                $transaction->update(['status' => 'success']);
                return redirect()->route('success', ['order_id' => $transaction->code]);
            }
        });
    }

    public function success(Request $request)
    {
        $transaction = Transaction::where('code', $request->order_id)->first();

        if (!$transaction) {
            abort(404, 'Transaksi tidak ditemukan.');
        }

        $store = User::where('id', $transaction->user_id)->first();

        if (!$store) {
            abort(404, 'Toko tidak ditemukan.');
        }

        return view('pages.success', compact('store', 'transaction'));
    }
}