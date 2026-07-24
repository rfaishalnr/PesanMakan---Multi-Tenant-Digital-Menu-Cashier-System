<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class QrGenerator extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-qr-code';
    protected static ?string $navigationLabel = 'Cetak QR Meja';
    protected static ?string $title = 'Generator QR Code Meja';
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem & Billing';
    protected static ?int $navigationSort = 7;
    
    protected string $view = 'filament.pages.qr-generator';

    // GANTI INI: Pakai string agar admin bisa ketik '1', '2', atau 'VIP-1'
    public string $tableNumber = '1'; 

    public function getStoreUrlProperty()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return url('/' . $user->username);
    }
}