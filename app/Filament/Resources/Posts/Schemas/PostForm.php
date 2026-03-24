<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // 🔵 KIRI (2/3)
                Section::make("Post Details")
                    ->description("Fill in the details of the post")
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        // 2 kolom field utama
                        Group::make([
                            TextInput::make("title")
                                ->required()
                                ->minLength(5),

                            TextInput::make("slug")
                                ->unique(ignoreRecord: true),

                            Select::make("category_id")
                                ->relationship("category", "name")
                                ->preload()
                                ->searchable(),

                            ColorPicker::make("color"),
                        ])->columns(2),

                        // full width
                        MarkdownEditor::make("body")
                            ->columnSpanFull(),

                    ])
                    ->columnSpan(2),

                // 🔴 KANAN (1/3)
                Group::make([

                    // Image Section
                    Section::make("Image Upload")
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make("image")
                                ->disk("public")
                                ->directory("posts"),
                        ]),

                    // Meta Section
                    Section::make("Meta Information")
                        ->icon('heroicon-o-cog-6-tooth')
                        ->schema([
                            TagsInput::make("tags"),
                            Checkbox::make("published"),
                            DateTimePicker::make("published_at"),
                        ]),

                ])->columnSpan(1),

            ])
            ->columns(3); // grid utama
    }
}