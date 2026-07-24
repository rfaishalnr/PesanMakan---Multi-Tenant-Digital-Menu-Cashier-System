<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User; 

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        
        $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashedKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;
        
        // Cek jika statusnya sudah dibayar lunas
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {

            // 1. JIKA TRANSAKSI MAKANAN (Prefix TRX-)
            if (str_starts_with($orderId, 'TRX-')) {
                $transaction = Transaction::where('code', $orderId)->first();

                // Pastikan transaksi ada dan masih pending (mencegah double hit)
                if ($transaction && $transaction->status === 'pending') {
                    
                    // Ubah status jadi diproses dapur
                    $transaction->update(['status' => 'success']);

                    // TAMBAH SALDO TOKO (Logika Bagi Hasil)
                    $store = User::find($transaction->user_id);
                    if ($store) {
                        // Contoh: Potongan/Komisi Platform adalah Rp 1.500
                        $komisiPlatform = 1500;
                        $uangBersihToko = $transaction->total_price - $komisiPlatform;
                        
                        // Masukkan uang bersih ke saldo toko
                        $store->increment('balance', $uangBersihToko);
                    }
                }
            }
            
            // 2. Nanti logika langganan (SUB-) bisa ditaruh di sini
            
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            if (str_starts_with($orderId, 'TRX-')) {
                $transaction = Transaction::where('code', $orderId)->first();
                if ($transaction) {
                    $transaction->update(['status' => 'failed']);
                }
            }
        }

        return response()->json(['message' => 'Callback processed successfully']);
    }
}