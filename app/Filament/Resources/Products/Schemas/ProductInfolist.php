<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product Tabs')
                    ->tabs([

                        // ✅ TAB 1
                        Tab::make('Product Details')
                            ->icon('heroicon-o-information-circle') // icon
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->color('primary'),

                                TextEntry::make('id')
                                    ->label('Product ID'),

                                TextEntry::make('sku')
                                    ->label('Product SKU')
                                    ->badge()
                                    ->color(fn ($state) => match (true) {
                                        str_contains($state, 'A') => 'success',
                                        str_contains($state, 'B') => 'warning',
                                        default => 'gray',
                                    }),

                                TextEntry::make('description')
                                    ->label('Product Description'),

                                TextEntry::make('created_at')
                                    ->label('Product Creation Date')
                                    ->date('d M Y')
                                    ->color('info'),
                            ]),

                        // ✅ TAB 2
                        Tab::make('Price & Stock')
                            ->icon('heroicon-o-banknotes') // icon
                            ->badge(fn ($record) => $record->stock) // badge jumlah stock
                            ->badgeColor(fn ($record) => match (true) {
                                $record->stock == 0 => 'danger',
                                $record->stock < 5 => 'warning',
                                default => 'success',
                            })
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Product Price')
                                    ->weight('bold')
                                    ->color('primary')
                                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                                TextEntry::make('stock')
                                    ->label('Product Stock')
                                    ->badge() // ✅ badge dinamis
                                    ->color(fn ($state) => match (true) {
                                        $state == 0 => 'danger',
                                        $state < 5 => 'warning',
                                        default => 'success',
                                    })
                                    ->icon('heroicon-o-cube'),
                            ]),

                        // ✅ TAB 3
                        Tab::make('Media & Status')
                            ->icon('heroicon-o-photo') // icon
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Product Image')
                                    ->disk('public'),

                                IconEntry::make('is_active')
                                    ->label('Is Active?')
                                    ->boolean(),

                                IconEntry::make('is_featured')
                                    ->label('Is Featured?')
                                    ->boolean(),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->vertical(), // ✅ vertical tabs
            ]);
    }
}