<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Product Info')
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
                            ->label('Product Created At')
                            ->date('d M Y')
                            ->color('info'),
                    ])
                    ->columns(2) // ✅ biar rapi
                    ->columnSpanFull(),

                Section::make('Product Price and Stock')
                    ->schema([
                        TextEntry::make('price')
                            ->label('Product Price')
                            ->weight('bold')
                            ->color('primary')
                            ->icon('heroicon-o-banknotes')
                            ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                        TextEntry::make('stock')
                            ->label('Product Stock')
                            ->icon('heroicon-o-cube')
                            ->color(fn ($state) => $state > 0 ? 'success' : 'danger'),
                    ])
                    ->columns(2) // ✅ biar sejajar
                    ->columnSpanFull(),

                Section::make('Image and Status')
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
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

            ]);
    }
}