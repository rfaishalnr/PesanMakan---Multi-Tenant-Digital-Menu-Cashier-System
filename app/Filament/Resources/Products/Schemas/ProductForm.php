<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\ProductCategory;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\Toggle;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Toko')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->default(fn() => Auth::id())
                    ->hidden(fn() => Auth::user()?->role === 'store') // <-- Gunakan Facade Auth dan ?->
                    ->dehydrated()
                    ->reactive()
                    ->required(),
                Select::make('product_category_id')
                    ->label('Kategori Produk')
                    ->relationship(name: 'productCategory', titleAttribute: 'name')
                    // FIX 1: The parenthesis for $get() needs to close after 'user_id'
                    ->disabled(fn(callable $get) => $get('user_id') == null)
                    ->default(fn() => Auth::id())
                    ->options(function (callable $get) {
                        $userId = $get('user_id');

                        if (!$userId) {
                            return [];
                        }

                        return ProductCategory::where('user_id', $userId)->pluck('name', 'id');
                    })
                    ->dehydrated()
                    ->required(),
                FileUpload::make('image')
                    ->label('Foto Menu')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->visibility('public')
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Menu')
                    ->required(),
                TextArea::make('description')
                    ->label('Deskripsi Menu')
                    ->required(),
                TextInput::make('price')
                    ->label('Harga Menu')
                    ->numeric()
                    ->required(),
                TextInput::make('rating')
                    ->label('Rating Menu')
                    ->disabled() // <-- Kunci inputnya agar tidak bisa diketik
                    ->dehydrated(false) // <-- Pastikan nilainya tidak ikut tersimpan saat diedit manual
                    ->default(0) // Default saat toko pertama kali membuat menu
                    ->numeric()
                    ->required(),
                Toggle::make('is_popular')
                    ->label('Popular Menu')
                    ->required(),

                Repeater::make('productIngredients')
                    ->label('Bahan baku Menu')
                    ->relationship('productIngredients')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Bahan')
                            ->required(),
                    ])->columnSpanFull()
            ]);
    }
}
