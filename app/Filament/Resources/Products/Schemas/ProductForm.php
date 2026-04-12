<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Checkbox;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([

                    Step::make('Product Info')
                        ->icon('heroicon-o-information-circle') // ✅ icon
                        ->description('Isi Informasi Produk')
                        ->schema([
                            Group::make([
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('sku')
                                    ->required(),
                            ])->columns(2),
                            MarkdownEditor::make('description')
                        ]),

                    Step::make('Product Price and Stock')
                        ->icon('heroicon-o-currency-dollar') // ✅ icon
                        ->description('Isi Harga Produk')
                        ->schema([
                            Group::make([
                                TextInput::make('price')
                                    ->numeric() // penting
                                    ->minValue(1) // ✅ harga > 0
                                    ->required(),

                                TextInput::make('stock')
                                    ->numeric()
                                    ->required(),
                            ])->columns(2),
                        ]),

                    Step::make('Media and Status')
                        ->icon('heroicon-o-photo') // ✅ icon
                        ->description('Isi Gambar Produk')
                        ->schema([
                            FileUpload::make('image')
                                ->disk('public')
                                ->directory('products'),

                            Checkbox::make('is_active'),
                            Checkbox::make('is_featured'),
                        ]),
                ])
                    ->columnSpanFull()
                    ->submitAction(
                        Action::make('save')
                            ->label('Save Product')
                            ->button()
                            ->color('primary')
                            ->submit('save')
                    )
            ]);
    }
}