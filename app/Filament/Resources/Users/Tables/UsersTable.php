<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\TrashedFilter;

// KEMBALI MENGGUNAKAN NAMESPACE UNIFIED ACTIONS TERBARU
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('store_logo')
                    ->label('Logo Toko')
                    ->disk('public')
                    ->circular(),
                
                TextColumn::make('name')
                    ->label('Nama Toko')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('username')
                    ->label('Username')
                    ->searchable(),
                    
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                    
                TextColumn::make('role')
                    ->label('Peran')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            // KEMBALI MENGGUNAKAN recordActions
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            // KEMBALI MENGGUNAKAN toolbarActions
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}