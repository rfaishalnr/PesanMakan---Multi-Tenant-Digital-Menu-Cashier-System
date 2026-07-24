<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Carbon\Carbon;

class ExpirePendingTransactions extends Command
{
    // Nama perintah yang akan dijalankan oleh sistem
    protected $signature = 'transactions:expire-pending';

    // Deskripsi singkat
    protected $description = 'Membatalkan transaksi otomatis jika status pending lebih dari 5 menit';

    public function handle()
    {
        // Cari semua transaksi yang statusnya 'pending' 
        // DAN waktu dibuatnya sudah lebih dari 5 menit yang lalu dari sekarang
        $expiredTransactions = Transaction::where('status', 'pending')
            ->where('created_at', '<=', Carbon::now()->subMinutes(5))
            ->get();

        $count = 0;

        foreach ($expiredTransactions as $transaction) {
            // Ubah statusnya menjadi failed
            $transaction->update([
                'status' => 'failed'
            ]);
            $count++;
        }

        // Tampilkan pesan di terminal (opsional)
        $this->info("Berhasil membatalkan {$count} transaksi yang kadaluarsa.");
    }
}