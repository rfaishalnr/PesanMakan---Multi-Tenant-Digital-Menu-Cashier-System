<?php

namespace App\Filament\Resources\Feedback; // Namespace disesuaikan dengan folder

use App\Filament\Resources\Feedback\Pages;
use App\Models\Feedback;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\ViewAction; // INI SOLUSI UNTUK GARIS MERAH TADI
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-inbox-stack';
    protected static ?string $navigationLabel = 'Kotak Masuk Saran';
    protected static ?string $pluralLabel = 'Daftar Masukan Toko';
    protected static string|\UnitEnum|null $navigationGroup = 'Layanan Pelanggan';
    protected static ?int $navigationSort = 9;
    
    protected static ?string $recordTitleAttribute = 'subject';

    public static function canAccess(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user.name')
                    ->label('Dikirim Oleh (Toko)')
                    ->disabled(),
                
                TextInput::make('subject')
                    ->label('Subjek / Topik')
                    ->disabled(),
                
                Textarea::make('message')
                    ->label('Isi Pesan Lengkap')
                    ->rows(6)
                    ->columnSpanFull()
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Dari Toko')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('subject')
                    ->label('Subjek')
                    ->searchable(),
                    
                TextColumn::make('created_at')
                    ->label('Dikirim Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\ViewAction::make()
            ])
            ->bulkActions([
                //
            ]);
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
            'index' => Pages\ListFeedback::route('/'),
        ];
    }
}