<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('featured_image')
                    ->label('Featured Image')
                    ->image()
                    ->directory('posts')
                    ->maxSize(10240) // 10 MB
                    ->helperText('Max 10 MB. JPG, PNG, WebP recommended.'),
                FileUpload::make('video_path')
                    ->label('Video Upload')
                    ->directory('videos')
                    ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                    ->maxSize(256000) // 250 MB
                    ->helperText('Max 250 MB. MP4 format recommended for best compatibility.')
                    ->default(null),
                TextInput::make('bridge_text')
                    ->default(null),
                TextInput::make('scroll_text')
                    ->default(null),
                Select::make('next_post_id')
                    ->relationship('nextPost', 'title')
                    ->default(null),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('views')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('meta_title')
                    ->default(null),
                Textarea::make('meta_description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('focus_keyword')
                    ->default(null),
                DateTimePicker::make('published_at'),
            ]);
    }
}
