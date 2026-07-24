<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder; // <-- Cukup import Placeholder
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString; // <-- Jangan lupa import HtmlString

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->options(User::all()->pluck('name', 'id')->toArray())
                    ->required()
                    ->hidden(fn() => Auth::user()->role == 'store'),
                
                Select::make('is_active')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ])
                    ->required()
                    ->hidden(fn() => Auth::user()->role == 'store'),

                // SOLUSI: Menggunakan satu Placeholder dengan kustomisasi HTML/CSS
                Placeholder::make('Instruksi Pembayaran')
                    ->label('')
                    ->content(new HtmlString('
                        <div style="padding: 16px; background-color: #FFF7F0; border: 1px solid #F3AF00; border-radius: 8px; color: #353535;">
                            <h3 style="font-weight: 600; font-size: 16px; margin-bottom: 8px; color: #FF801A;">Panduan Pembayaran Langganan</h3>
                            <p style="margin-bottom: 12px; font-size: 14px;">Silakan lakukan transfer ke salah satu rekening di bawah ini untuk mengaktifkan kembali toko Anda, lalu unggah bukti transfer pada kolom di bawah.</p>
                            <ul style="list-style-type: none; padding: 0; margin: 0; font-size: 14px;">
                                <li style="margin-bottom: 4px;">💳 <strong>Bank Mandiri:</strong> xxxxxxxx a.n Faishal Nizaar Rizq</li>
                                <li>📱 <strong>DANA / GoPay:</strong> 0812-3456-7890</li>
                            </ul>
                        </div>
                    '))
                    ->columnSpanFull()
                    ->hidden(fn() => Auth::user()->role == 'admin'), // Hanya muncul untuk akun toko

                Repeater::make('subscriptionPayments')
                    ->relationship()
                    ->schema([
                        FileUpload::make('proof')
                            ->label('Bukti Pembayaran (Transfer/Screenshot)')
                            ->image()
                            ->required(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'success' => 'Success', 
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->label('Status Pembayaran')
                            ->hidden(fn() => Auth::user()->role == 'store'),
                    ])
                    ->columnSpanFull()
                    ->addable(false),
            ]);
    }
}