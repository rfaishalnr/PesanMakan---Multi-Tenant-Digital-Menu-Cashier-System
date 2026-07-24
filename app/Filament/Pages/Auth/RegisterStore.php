<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action; 

class RegisterStore extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // 1. Input Nama Toko
                TextInput::make('name')
                    ->label('Nama Toko')
                    ->placeholder('Isi nama toko...')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),

                // 2. Input Email
                TextInput::make('email')
                    ->label('Alamat Email')
                    ->placeholder('Isi email...')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'users', column: 'email'),

                // 3. Input Nomor HP
                TextInput::make('phone_number')
                    ->label('Nomor HP / WhatsApp Toko')
                    ->placeholder('Isi Nomor HP/WA')
                    ->tel()
                    ->required()
                    ->maxLength(20),
                
                // 4. Input Alamat Lengkap
                Textarea::make('address')
                    ->label('Alamat Lengkap Toko')
                    ->placeholder('Isi alamat toko...')
                    ->required()
                    ->rows(3),

                // 5. Input Password
                TextInput::make('password')
                    ->label('Kata Sandi')
                    ->password()
                    ->required()
                    ->rule(\Illuminate\Validation\Rules\Password::default())
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->same('passwordConfirmation')
                    ->validationAttribute('Kata Sandi'),

                // 6. Input Konfirmasi Password
                TextInput::make('passwordConfirmation')
                    ->label('Konfirmasi Kata Sandi')
                    ->password()
                    ->required()
                    ->dehydrated(false),
            ])
            ->statePath('data');
    }

    protected function getRegisteredNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Toko Berhasil Dibuat! 🎉')
            ->body('Langkah terakhir: Silakan lengkapi profil dengan mengunggah **Logo Toko** dan **Gambar QRIS** agar pelanggan bisa mulai melakukan pembayaran.')
            ->persistent() // Agar notifikasi tidak hilang otomatis sebelum di-close user
            ->actions([
                Action::make('atur_toko')
                    ->label('Upload Sekarang')
                    ->button()
                    // GANTI URL DI BAWAH INI DENGAN URL HALAMAN PENGATURAN TOKOMU
                    ->url('/admin/store-settings'), 
            ]);
    }

    protected function getRedirectUrl(): string
    {
        // GANTI URL DI BAWAH INI DENGAN URL HALAMAN PENGATURAN TOKOMU
        return url('/admin/store-settings'); 
    }
}