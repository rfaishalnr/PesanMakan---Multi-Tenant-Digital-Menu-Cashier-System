<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('user_id')
                    ->label('Toko')
                    ->relationship('user', 'name')
                    ->default(fn () => Auth::id())
                    ->required()
                    ->hidden(fn () => Auth::user()?->role === 'store')
                    ->dehydrated(),

                TextInput::make('code')
                    ->label('Kode Transaksi')
                    ->default(fn () => 'TRX-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)))
                    ->readOnly()
                    ->required(),

                TextInput::make('name')
                    ->label('Nama Pembeli')
                    ->required(),

                TextInput::make('phone_number')
                    ->label('Nomor HP Customer')
                    ->required(),

                TextInput::make('table_number')
                    ->label('Nomor Meja')
                    ->required(),

                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'cash' => 'Tunai',
                        'midtrans' => 'Bayar Online',
                    ])
                    ->required()
                    ->live(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Tertunda',
                        'success' => 'Diproses',
                        'ready'   => 'Siap Diambil',
                        'failed'  => 'Gagal / Batal',
                        'completed' => 'Selesai',
                    ])
                    ->default('pending')
                    ->required(),

                Repeater::make('transactionDetails')
                    ->relationship()
                    ->schema([
                        Select::make('product_id')
                            ->label('Produk')
                            ->options(function () {
                                if (Auth::user()?->role === 'admin') {
                                    return Product::all()->mapWithKeys(fn ($product) => [
                                        $product->id => $product->name . ' (Rp ' . number_format($product->price) . ')'
                                    ]);
                                }
                                return Product::where('user_id', Auth::id())->get()->mapWithKeys(fn ($product) => [
                                    $product->id => $product->name . ' (Rp ' . number_format($product->price) . ')'
                                ]);
                            })
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotals($get, $set)),

                        TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotals($get, $set)),

                        TextInput::make('note')
                            ->label('Catatan')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->live()
                    ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotals($get, $set))
                    ->reorderable(),

                TextInput::make('total_price')
                    ->label('Total Harga')
                    ->numeric()
                    ->readOnly()
                    ->default(0),

            ]);
    }

    public static function updateTotals(Get $get, Set $set): void
    {
        $details = $get('transactionDetails') ?? [];
        $selectedProducts = collect($details)->filter(fn ($item) => ! empty($item['product_id']) && ! empty($item['quantity']));

        if ($selectedProducts->isEmpty()) {
            $set('total_price', 0);
            return;
        }

        $prices = Product::whereIn('id', $selectedProducts->pluck('product_id'))->pluck('price', 'id');
        $total = $selectedProducts->reduce(fn ($carry, $item) => $carry + ($prices->get($item['product_id'], 0) * $item['quantity']), 0);
        $set('total_price', $total);
    }
}