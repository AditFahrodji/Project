<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Filament\Resources\ProdukResource\RelationManagers;
use App\Models\Produk;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Informasi Produk')->schema([
                        TextInput::make('nama')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function(callable $set, $state) {
                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->unique(Produk::class, 'slug', ignoreRecord: true),
                        MarkdownEditor::make('deskripsi')
                            ->required()
                            ->fileAttachmentsDirectory('produks')
                            ->columnSpanFull(),  
                    ])->columns(2),

                    Section::make('Gambar')->schema([
                        FileUpload::make('gambar')
                            ->directory('produks')
                            ->image()
                            ->required(),
                    ])
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Harga')->schema([
                        TextInput::make('harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp. ')
                    ]),

                    Section::make('Kategori')->schema([
                        Select::make('kategori_id')
                            ->label('Kategori')
                            ->relationship('kategori', 'nama')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('brand_id')
                            ->label('Brand')
                            ->relationship('brand', 'nama')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                    Section::make('Status Produk')->schema([
                        Toggle::make('is_active')
                            ->default(true)
                            ->required(),
                        Toggle::make('is_popular')
                            ->default(false)
                            ->required(),
                        Toggle::make('in_stock')
                            ->default(true)
                            ->required(),
                        Toggle::make('on_sale')
                            ->default(true)
                            ->required(),
                    ])
                ])->columnSpan(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('kategori.nama')
                    ->sortable(),
                TextColumn::make('brand.nama')
                    ->sortable(),
                TextColumn::make('harga')
                    ->money('Rp. ')
                    ->sortable(),
                ImageColumn::make('gambar')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
                IconColumn::make('is_popular')
                    ->boolean(),
                IconColumn::make('in_stock')
                    ->boolean(),
                IconColumn::make('on_sale')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('Kategori')
                    ->relationship('kategori', 'nama'),
                SelectFilter::make('Brand')
                    ->relationship('brand', 'nama'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\EditAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
