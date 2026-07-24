<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Resources\Products\Schemas\ProductForm;
use App\Filament\Resources\Products\Tables\ProductsTable;
use App\Models\Product;
use App\Models\Subscription;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Operasional Toko';
    protected static ?int $navigationSort = 3;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Produk Menu';

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            return parent::getEloquentQuery();
        }

        return parent::getEloquentQuery()
            ->where('user_id' , $user->id);
    }

    public static function canCreate(): bool
    {
        // 1. Jika Admin, selalu izinkan
        if (Auth::user()?->role === 'admin') {
            return true;
        }
    
        $userId = Auth::id();
    

        $hasActiveSubscription = Subscription::where('user_id', $userId)
            ->where('end_Date', '>=', now()) 
            ->where('is_active', true)
            ->exists(); 

        $countProduct = Product::where('user_id', $userId)->count();

        // Ubah limit produk subscription
        return $countProduct < 5 || $hasActiveSubscription;
    }

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
