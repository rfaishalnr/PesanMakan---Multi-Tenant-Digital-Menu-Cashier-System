<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use App\Models\Subscription;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {

        // 1. Jika role adalah admin, langsung tampilkan tombol Create seperti biasa
        if (Auth::user()?->role === 'admin') {
            return [
                CreateAction::make(),
            ];
        }

        $userId = Auth::id();

        // 2. Cek apakah user memiliki langganan (subscription) yang masih aktif
        $subscription = Subscription::where('user_id', $userId)
            ->where('end_Date', '>', now()) // Catatan: Gunakan 'end_Date' (D besar) mengikuti file Model Anda sebelumnya
            ->where('is_active', true)
            ->latest()
            ->first();

        // 3. Hitung jumlah produk yang sudah dibuat oleh user tersebut
        // Catatan: Di gambar batasnya adalah 5, jadi saya ikuti 5 (di kode Anda sebelumnya batasnya 2).
        $countProduct = Product::where('user_id', $userId)->count();

        // Cek kondisi apakah user kena limit (tidak ada subscription aktif DAN produk sudah >= 5)
        $isLimitReached = !$subscription && $countProduct >= 2;

        return [
            // Tombol Alert (Peringatan Merah)
            Action::make('alert')
                ->label('Produk Kamu Melebihi Batas Penggunaan Gratis, Silakan Berlangganan')
                ->color('danger')
                ->icon('heroicon-s-exclamation-triangle')
                ->visible($isLimitReached), // Hanya muncul jika limit tercapai

            // Tombol Create Product
            CreateAction::make()
                ->hidden($isLimitReached), // [PERBAIKAN] Sembunyikan tombol Create jika limit tercapai agar user benar-benar tidak bisa menambah data
        ];
    }
}