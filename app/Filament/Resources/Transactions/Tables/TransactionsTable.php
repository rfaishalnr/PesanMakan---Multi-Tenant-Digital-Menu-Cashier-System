<?php

namespace App\Filament\Resources\Transactions\Tables;

use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('user.name')
                    ->label('Nama Toko')
                    ->searchable()
                    ->sortable()
                    ->hidden(fn () => Auth::user()?->role === 'store'),

                TextColumn::make('queue_number')
                    ->label('No. Antrian')
                    ->badge()
                    ->color('warning')
                    ->formatStateUsing(fn($state) => $state ? 'Antrian #' . str_pad($state, 3, '0', STR_PAD_LEFT) : '-')
                    ->sortable(),

                TextColumn::make('code')
                    ->label('Kode Transaksi')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nama Customer')
                    ->searchable(),

                TextColumn::make('phone_number')
                    ->label('Nomor HP Customer')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('table_number')
                    ->label('Nomor Meja')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('payment_method')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'cash' => 'success',
                        'midtrans' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'cash' => 'Cash',
                        'midtrans' => 'Bayar Online',
                        default => $state,
                    }),

                TextColumn::make('total_price')
                    ->label('Total Pembayaran')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                SelectColumn::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending'   => 'Tertunda',
                        'success'   => 'Diproses',
                        'ready'     => 'Siap Diambil',
                        'completed' => 'Selesai', 
                        'failed'    => 'Gagal / Batal',
                    ])
                    ->selectablePlaceholder(false)
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Transaksi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('setProcessing')
                    ->label('Proses Pesanan')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading('Proses Pesanan Ini?')
                    ->modalDescription('Pastikan pembayaran sudah valid. Aksi ini akan mengubah status pesanan menjadi sedang diproses oleh dapur.')
                    ->modalSubmitActionLabel('Ya, Proses')
                    ->action(function (Transaction $record) {
                        if ($record->status === 'pending') {
                            $record->update(['status' => 'success']);
                        }
                    })
                    ->visible(fn(Transaction $record) => $record->status === 'pending'),

                Action::make('setReady')
                    ->label('Siap Diambil')
                    ->icon('heroicon-o-check-badge')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Makanan Sudah Siap?')
                    ->modalDescription('Aksi ini akan memberi tahu pelanggan bahwa pesanan mereka siap diambil di kasir.')
                    ->modalSubmitActionLabel('Ya, Sudah Siap')
                    ->action(function (Transaction $record) {
                        if ($record->status === 'success') {
                            $record->update(['status' => 'ready']);
                        }
                    })
                    ->visible(fn(Transaction $record) => $record->status === 'success'),

                Action::make('setCompleted')
                    ->label('Selesaikan Pesanan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Pesanan Sudah Diterima?')
                    ->modalDescription('Tandai pesanan ini sebagai selesai jika makanan sudah diterima oleh pelanggan.')
                    ->modalSubmitActionLabel('Ya, Selesai')
                    ->action(function (Transaction $record) {
                        if ($record->status === 'ready') {
                            $record->update(['status' => 'completed']);
                        }
                    })
                    ->visible(fn(Transaction $record) => $record->status === 'ready'),

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