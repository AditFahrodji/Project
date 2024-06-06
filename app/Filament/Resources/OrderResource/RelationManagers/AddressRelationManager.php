<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('nomor_telepon')
                    ->tel()
                    ->required(),
                TextInput::make('provinsi')
                    ->required(),
                TextInput::make('kota')
                    ->required(),
                TextInput::make('kecamatan')
                    ->required(),
                TextInput::make('kelurahan')
                    ->required(),
                TextInput::make('kode_pos')
                    ->numeric()
                    ->required(),
                Textarea::make('alamat_lengkap')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('alamat_lengkap')
            ->columns([
                TextColumn::make('nama')
                    ->label('Pembeli')
                    ->searchable(),
                TextColumn::make('nomor_telepon'),
                TextColumn::make('provinsi'),
                TextColumn::make('kota'),
                TextColumn::make('kecamatan'),
                TextColumn::make('kelurahan'),
                TextColumn::make('kode_pos'),
                TextColumn::make('alamat_lengkap'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),      
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
