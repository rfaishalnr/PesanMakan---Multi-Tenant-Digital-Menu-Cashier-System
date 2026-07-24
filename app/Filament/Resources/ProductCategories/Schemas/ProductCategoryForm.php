<?php

namespace App\Filament\Resources\ProductCategories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;



class ProductCategoryForm
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
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required(),
                    FileUpload::make('icon')
                    ->label('Ikon Kategori')
                    ->image()
                    ->disk('public')
                    ->directory('categories')
                    ->visibility('public')
                    ->required(),
            ]);
    }
}
