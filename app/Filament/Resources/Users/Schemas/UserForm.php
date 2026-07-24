<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema; // <-- KEMBALIKAN KE SCHEMA
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Models\User;
use Illuminate\Validation\Rules\Unique;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([ // <-- KEMBALIKAN KE COMPONENTS()
                FileUpload::make('logo')
                    ->label('Logo Toko')
                    ->image()
                    ->required(),
                    
                TextInput::make('name')
                    ->label('Nama Toko')
                    ->required(),
                    
                TextInput::make('username')
                    ->label('Username')
                    ->hint('Minimal 5 Karakter')
                    ->minLength(5)
                    ->unique(
                        table: User::class, 
                        column: 'username', 
                        modifyRuleUsing: fn (Unique $rule) => $rule->whereNull('deleted_at')
                    )
                    ->required(),
                    
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
                    
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(),
                    
                Select::make('role')
                    ->label('Peran')
                    ->options([
                        'admin' => 'Admin',
                        'store' => 'Store',
                    ])
                    ->required(),
            ]);
    }
}