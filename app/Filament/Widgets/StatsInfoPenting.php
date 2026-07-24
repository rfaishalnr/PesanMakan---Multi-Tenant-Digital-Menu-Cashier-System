<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Subscription;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Dom\Attr;

class StatsInfoPenting extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();
        // 1. Hitung sisa hari langganan toko yang sedang login
        $subscription = Subscription::where('user_id', Auth::id())->where('is_active', true)->first();
        $sisaHari = 'Tidak Aktif';
        if ($subscription && $subscription->end_date) {
            // Membulatkan selisih hari
            $sisaHari = round(now()->diffInDays(Carbon::parse($subscription->end_date), false));
            $sisaHari = max(0, $sisaHari); // Cegah minus
        }

        // 2. Hitung transaksi sukses hari ini khusus toko ini
        $transaksiHariIni = Transaction::where('user_id', Auth::id())
            ->where('status', 'success')
            ->whereDate('created_at', now()->today())
            ->count();

        // 2. Hitung Pemasukan Hari Ini
        $pemasukanHariIni = Transaction::where('user_id', $userId)
            ->where('status', 'success')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_price');

        // 3. Hitung Pemasukan Bulan Ini
        $pemasukanBulanIni = Transaction::where('user_id', $userId)
            ->where('status', 'success')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        // 3. Hitung total produk menu toko ini
        $totalProduk = Product::where('user_id', Auth::id())->count();

        return [
            Stat::make('Status Masa Aktif Toko', $sisaHari > 0 ? $sisaHari . ' Hari Lagi' : 'Kedaluwarsa')
            ->description($sisaHari > 0 ? 'Toko aktif melayani pelanggan' : 'Segera perpanjang layanan')
            ->descriptionIcon($sisaHari > 0 ? 'heroicon-m-check-badge' : 'heroicon-m-exclamation-circle')
            ->color($sisaHari > 0 ? 'success' : 'danger'),

            Stat::make('Pesanan Sukses Hari Ini', $transaksiHariIni . ' Pesanan')
                ->description('Pantau dapur Anda')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),

            Stat::make('Total Menu Kuliner', $totalProduk . ' Menu')
                ->description('Jumlah produk aktif di web')
                ->descriptionIcon('heroicon-m-cake')
                ->color('info'),

            Stat::make('Pemasukan Hari Ini', 'Rp ' . number_format($pemasukanHariIni, 0, ',', '.'))
                ->description('Total uang masuk hari ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            // Widget Pemasukan Bulanan
            Stat::make('Pemasukan Bulan Ini', 'Rp ' . number_format($pemasukanBulanIni, 0, ',', '.'))
                ->description('Total bulan ' . Carbon::now()->translatedFormat('F Y'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
        ];
    }
}
