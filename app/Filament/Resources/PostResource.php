<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Blog / Artikel';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Dasar')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Artikel')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) =>
                            $operation === 'create' ? $set('slug', \Str::slug($state)) : null
                        ),
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug URL')
                        ->required()
                        ->unique(Post::class, 'slug', ignoreRecord: true),
                    Forms\Components\Select::make('category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload(),
                    Forms\Components\Select::make('tags')
                        ->label('Tag')
                        ->relationship('tags', 'name')
                        ->multiple()
                        ->searchable()
                        ->preload(),
                ])->columns(2),

            Forms\Components\Section::make('Konten')
                ->schema([
                    Forms\Components\Textarea::make('excerpt')
                        ->label('Ringkasan / Excerpt')
                        ->rows(3)
                        ->maxLength(500),
                    TiptapEditor::make('content')
                        ->label('Konten Lengkap')
                        ->required()
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Media & SEO')
                ->schema([
                    Forms\Components\FileUpload::make('featured_image')
                        ->label('Featured Image')
                        ->image()
                        ->imageEditor()
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth(1920)
                        ->maxSize(20000)
                        ->directory('posts/thumbnails')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('featured_image_alt')
                        ->label('Alt Text Gambar'),
                    Forms\Components\TextInput::make('meta_title')
                        ->label('Meta Title (SEO)')
                        ->maxLength(60)
                        ->helperText('Biarkan kosong untuk pakai judul artikel'),
                    Forms\Components\Textarea::make('meta_description')
                        ->label('Meta Description (SEO)')
                        ->rows(2)
                        ->maxLength(160),
                    Forms\Components\TextInput::make('meta_keywords')
                        ->label('Meta Keywords')
                        ->helperText('Pisahkan dengan koma'),
                    Forms\Components\TextInput::make('canonical_url')
                        ->label('Canonical URL')
                        ->url()
                        ->placeholder('https://'),
                    Forms\Components\Repeater::make('schema_markup')
                        ->label('Schema Markup (JSON-LD)')
                        ->schema([
                            Forms\Components\KeyValue::make('schema')->label('Key-Value'),
                        ])
                        ->defaultItems(0)
                        ->addActionLabel('Tambah Schema'),
                ])->columns(2),

            Forms\Components\Section::make('Pengaturan Publikasi')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'draft'     => 'Draft',
                            'published' => 'Published',
                            'archived'  => 'Archived',
                        ])
                        ->default('draft')
                        ->required(),
                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Tanggal Publikasi'),
                    Forms\Components\Toggle::make('is_featured')
                        ->label('Tampilkan di Homepage'),
                    Forms\Components\Toggle::make('allow_comments')
                        ->label('Izinkan Komentar'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'archived' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('views')
                    ->label('Dilihat')
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publikasi')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived']),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withTrashed();
    }
}
