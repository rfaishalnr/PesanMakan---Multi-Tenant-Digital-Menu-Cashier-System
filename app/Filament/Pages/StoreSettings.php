<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section; 
use Filament\Schemas\Schema; 
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;

class StoreSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Toko';
    protected static ?string $title = 'Pengaturan Toko & Rekening';
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem & Billing';
    protected static ?int $navigationSort = 6;
    
    protected string $view = 'filament.pages.store-settings';

    public ?array $data = [];

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->form->fill(
            $user->attributesToArray()
        );
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dasar Toko')
                    ->schema([
                        FileUpload::make('store_logo')
                            ->label('Gambar / Logo Toko Utama')
                            ->disk('public')
                            ->directory('store-logos')
                            ->visibility('public')
                            ->image()
                            ->columnSpanFull(), 
                        
                        TextInput::make('name')
                            ->label('Nama Toko')
                            ->required(),
                        TextInput::make('phone_number')
                            ->label('Nomor WhatsApp')
                            ->tel()
                            ->required(),
                        Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Informasi Rekening (Untuk Penarikan Saldo)')
                    ->description('Pastikan data rekening benar agar pencairan dana otomatis tidak gagal.')
                    ->schema([
                        Select::make('bank_name')
                        ->label('Bank')
                        ->options([
                            'bca'      => 'Bank Central Asia (BCA)',
                            'bni'      => 'Bank Negara Indonesia (BNI)',
                            'bri'      => 'Bank Rakyat Indonesia (BRI)',
                            'mandiri'  => 'Bank Mandiri',
                            'bsi'      => 'Bank Syariah Indonesia (BSI)',
                            'cimb'     => 'CIMB Niaga',
                            'permata'  => 'Permata Bank',
                            'danamon'  => 'Bank Danamon',
                            'btn'      => 'Bank BTN',
                            'maybank'  => 'Maybank Indonesia',
                            'ocbc'     => 'OCBC Indonesia',
                            'panin'    => 'Panin Bank',
                            'mega'     => 'Bank Mega',
                            'sinarmas' => 'Bank Sinarmas',
                        ])
                        ->searchable()
                        ->preload()
                        ->required(),
                        TextInput::make('bank_account')
                            ->label('Nomor Rekening')
                            ->numeric()
                            ->required(),
                        TextInput::make('bank_account_name')
                            ->label('Nama Pemilik Rekening')
                            ->placeholder('Sesuai dengan nama di buku tabungan')
                            ->required(),
                    ])->columns(3),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update($this->form->getState());

        Notification::make()
            ->title('Berhasil disimpan!')
            ->body('Data toko dan informasi rekening Anda telah diperbarui.')
            ->success()
            ->send();
    }
}