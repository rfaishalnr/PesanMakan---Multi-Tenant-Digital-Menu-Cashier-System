<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Models\ProductCategory;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;


class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Toko')
                    ->searchable()
                    ->hidden(fn() => Auth::user()?->role === 'store')
                    ->sortable(),
                
                TextColumn::make('productCategory.name')
                    ->label('Kategori menu')
                    ->searchable()
                    ->sortable(),
                
                ImageColumn::make('image')
                    ->label('Foto Menu')
                    ->disk('public')
                    ->searchable()
                    
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Menu')
                ->searchable()
                ->sortable(),
                
                TextColumn::make('price')
                    ->label('Harga Menu')
                    ->searchable()
                    ->formatStateUsing(fn (string $state) => 'Rp ' . number_format($state))
                    ->sortable(),
                
                TextColumn::make('rating')
                    ->label('Rating Menu')
                    ->searchable(),
                
                ToggleColumn::make('is_popular')
                    ->label('Menu Populer')
                    ->searchable(),
            ])
            ->filters([
                TrashedFilter::make(),
                
                SelectFilter::make('user')
                    ->label('Toko')
                    ->relationship(name: 'user', titleAttribute: 'name'),
                
                // PERBAIKAN: Scoping query yang benar untuk Filter Relasi
                SelectFilter::make('product_category_id')
                    ->label('Kategori Menu')
                    ->relationship(
                        name: 'productCategory', 
                        titleAttribute: 'name',
                        modifyQueryUsing: function (Builder $query) {
                            if (Auth::user()?->role === 'admin') {
                                return $query;
                            }
                            return $query->where('user_id', Auth::id());
                        }
                    )
            ])
            // PERBAIKAN: Ubah recordActions menjadi actions
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}