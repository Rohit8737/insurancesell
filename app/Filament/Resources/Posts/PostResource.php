<?php

namespace App\Filament\Resources\Posts;

use App\Filament\Resources\Posts\Pages as PostPages;
use App\Models\Post;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationLabel = 'Posts';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Content')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        
                        Textarea::make('bridge_text')
                            ->label('Bridge Text')
                            ->rows(2),
                        
                        RichEditor::make('description')
                            ->label('Article Content')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Section::make('Media')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->image()
                            ->disk('public')
                            ->directory('posts/images'),
                        
                        FileUpload::make('video_path')
                            ->label('Video')
                            ->disk('public')
                            ->directory('posts/videos')
                            ->acceptedFileTypes(['video/mp4', 'video/webm'])
                            ->maxSize(102400) // 100MB
                            ->preserveFilenames()
                            ->visibility('public'),
                        
                        TextInput::make('youtube_url')
                            ->url(),
                    ])
                    ->columns(2),
                
                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_title')
                            ->maxLength(60),
                        
                        Textarea::make('meta_description')
                            ->maxLength(160)
                            ->rows(2),
                        
                        TextInput::make('focus_keyword'),
                    ])
                    ->columns(2),
                
                Section::make('Settings')
                    ->schema([
                        Toggle::make('is_active')
                            ->default(true),
                        
                        DateTimePicker::make('published_at')
                            ->default(now()),
                        
                        Select::make('next_post_id')
                            ->label('Next Post')
                            ->relationship('nextPost', 'title')
                            ->searchable()
                            ->preload(),
                        
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->circular()
                    ->size(50),
                
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                
                ToggleColumn::make('is_active'),
                
                TextColumn::make('views')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('published_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->options(['1' => 'Active', '0' => 'Inactive']),
            ])
            ->actions([
                \Filament\Actions\Action::make('view_post')
                    ->label('View')
                    ->icon(Heroicon::OutlinedEye)
                    ->color('info')
                    ->url(fn ($record) => url('/post/' . $record->slug))
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => PostPages\ListPosts::route('/'),
            'create' => PostPages\CreatePost::route('/create'),
            'edit' => PostPages\EditPost::route('/{record}/edit'),
        ];
    }
}
