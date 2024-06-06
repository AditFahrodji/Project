<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;
use App\Models\Order;
use App\Models\Produk;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Number as SupportNumber;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Informasi Order')->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Pembeli')
                            ->searchable()
                            ->preload()
                            ->required(),
                        
                        Select::make('metode_pembayaran')
                            ->required()
                            ->options([
                                'cod' => 'Cod',
                                'transfer' => 'Transfer',
                            ]),
                        
                        Select::make('status_pembayaran')
                            ->default('menunggu')
                            ->required()
                            ->options([
                                'menunggu' => 'Menunggu',
                                'lunas' => 'Lunas',
                                'batal' => 'Batal',
                            ]),
                        
                        ToggleButtons::make('status')
                            ->label('Status Pesanan')
                            ->inline()
                            ->default('baru')
                            ->required()
                            ->options([
                                'baru' => 'Baru',
                                'sedang diproses' => 'Sedang Diproses',
                                'dikirim' => 'Dikirim',
                                'terkirim' => 'Terkirim',
                                'dibatalkan' => 'Dibatalkan',
                            ])
                            ->colors([
                                'baru' => 'info',
                                'sedang diproses' => 'warning',
                                'dikirim' => 'success',
                                'terkirim' => 'success',
                                'dibatalkan' => 'danger',
                            ])
                            ->icons([
                                'baru' => 'heroicon-m-shopping-bag',
                                'sedang diproses' => 'heroicon-m-arrow-path',
                                'dikirim' => 'heroicon-o-truck',
                                'terkirim' => 'heroicon-m-check-badge',
                                'dibatalkan' => 'heroicon-m-x-circle',
                            ]),
                        
                        Select::make('metode_pengiriman')
                            ->required()
                            ->options([
                                'jne' => 'JNE',
                                'jnt' => 'JNT',
                                'sicepat' => 'Sicepat',
                                'ninja' => 'Ninja',
                            ]),
                        
                        Textarea::make('catatan')
                            ->nullable()
                            ->columnSpanFull(),
                    ])->columns(2),
 
                    Section::make('Pesanan')->schema([
                        Repeater::make('items')
                            ->label('Item')
                            ->relationship()
                            ->schema([
                                Select::make('produk_id')
                                    ->relationship('produk', 'nama')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    
                                    ->columnSpan(4)
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, Set $set) => $set('jumlah_unit', Produk::find($state)->harga ?? 0))
                                    ->afterStateUpdated(fn ($state, Set $set) => $set('jumlah_total', Produk::find($state)->harga ?? 0)),
                                
                                TextInput::make('kuantitas')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->default(1)
                                    ->columnSpan(2)
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, Set $set, Get $get) => $set('jumlah_total', $state*$get('jumlah_unit'))),
                                
                                TextInput::make('jumlah_unit')
                                    ->numeric()
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(2),
                                
                                TextInput::make('jumlah_total')
                                    ->numeric()
                                    ->required()
                                    ->dehydrated()
                                    ->columnSpan(2),
                            ])->columns(10),

                            Placeholder::make('total_placeholder')
                                ->label('Total')
                                ->content(function (Get $get, Set $set) {
                                    $total = 0;
                                    if(!$repeaters = $get('items')) {
                                        return $total;
                                    }

                                    foreach($repeaters as $key => $repeater) {
                                        $total += $get("items.{$key}.jumlah_total");
                                    }
                                    
                                    $set('total', $total);

                                    return SupportNumber::currency($total, 'IDR');
                                }),
                                Hidden::make('total'),
                    ])
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('user.name')
                ->label('Pembeli')
                ->searchable()
                ->sortable(),
            TextColumn::make('metode_pembayaran')
                    ->label('Metode Pembayaran')
                    ->sortable()
                    ->searchable(),
            TextColumn::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->sortable()
                    ->searchable(),
            TextColumn::make('metode_pengiriman')
                ->label('Metode Pengiriman')
                ->sortable()
                ->searchable(),
            SelectColumn::make('status')
                ->options([
                    'baru' => 'Baru',
                    'sedang diproses' => 'Sedang Diproses',
                    'dikirim' => 'Dikirim',
                    'terkirim' => 'Terkirim',
                    'dibatalkan' => 'Dibatalkan',
                ])
                ->label('Status Pesanan')
                ->searchable()
                ->sortable(),
            TextColumn::make('total')
                ->label('Total')
                ->money('Rp. ')
                ->numeric()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            AddressRelationManager::class,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
