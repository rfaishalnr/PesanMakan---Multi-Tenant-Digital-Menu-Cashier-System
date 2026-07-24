<?php

namespace App\Filament\Resources\Subscriptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class SubscriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Toko')
                    ->searchable()
                    ->hidden(fn() => Auth::user()->role == 'store'),
                TextColumn::make('created_at')
                    ->label('Tanggal Pembayaran')
                    ->dateTime(),
                TextColumn::make('end_date')
                    ->label('Tanggal Berakhir')
                    ->dateTime(),
                ImageColumn::make('subscriptionPayments.proof')
                    ->label('Bukti Pembayaran')
                    ->disk('public')
                    ->searchable(),
                TextColumn::make('subscriptionPayments.status')
                    ->label('Status Pembayaran')
                    ->searchable(),

            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
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
