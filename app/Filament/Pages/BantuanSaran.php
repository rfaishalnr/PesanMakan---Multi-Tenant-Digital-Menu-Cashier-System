<?php

namespace App\Filament\Pages;

use App\Models\Feedback;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section; // Menggunakan namespace Schema sesuai projectmu
use Filament\Schemas\Schema;             // Menggunakan namespace Schema
use Illuminate\Support\Facades\Auth;

class BantuanSaran extends Page implements HasForms
{
    use InteractsWithForms;

    // 1. FIX STRICT TYPING: Penulisan tipe data disamakan dengan standar Filament v4
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationLabel = 'Bantuan & Saran';
    protected static ?string $title = 'Kirim Bantuan / Saran';
    protected static string|\UnitEnum|null $navigationGroup = 'Layanan Pelanggan';
    protected static ?int $navigationSort = 8;

    protected string $view = 'filament.pages.bantuan-saran';

    public ?array $data = [];

    // Fungsi untuk memunculkan form di halaman (Anti-Blank)
    public function mount(): void
    {
        $this->form->fill();
    }

    public static function canAccess(): bool
    {
        return Auth::user()?->role === 'store';
    }

    // 2. FIX FORM BUILDER: Menggunakan format Schema dan components() 
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ada kendala atau ide fitur baru?')
                    ->description('Beri tahu kami agar PesanMakan bisa melayani bisnis Anda lebih baik lagi.')
                    ->schema([
                        TextInput::make('subject')
                            ->label('Subjek / Topik')
                            ->placeholder('Contoh: Laporan Bug, Request Fitur, Kendala Pencairan')
                            ->required(),
                        Textarea::make('message')
                            ->label('Pesan Lengkap')
                            ->placeholder('Tuliskan detail masukan Anda di sini...')
                            ->rows(5)
                            ->required(),
                    ])
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        Feedback::create([
            'user_id' => Auth::id(),
            'subject' => $data['subject'],
            'message' => $data['message'],
        ]);

        $this->form->fill(); // Kosongkan form setelah dikirim

        Notification::make()
            ->title('Pesan Terkirim!')
            ->body('Terima kasih atas masukan Anda. Tim kami akan segera meninjaunya.')
            ->success()
            ->send();
    }
}