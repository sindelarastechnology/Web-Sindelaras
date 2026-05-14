<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Kategori';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Kategori')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($operation, $state, Forms\Set $set) =>
                    $operation === 'create' ? $set('slug', \Str::slug($state)) : null
                ),
            Forms\Components\TextInput::make('slug')->required()->unique(Category::class, 'slug', ignoreRecord: true),
            Forms\Components\Select::make('type')
                ->label('Tipe')
                ->options([
                    'post'      => 'Blog / Post',
                    'service'   => 'Layanan',
                    'portfolio' => 'Portfolio',
                ])->required(),
            Forms\Components\Select::make('parent_id')
                ->label('Kategori Induk')
                ->relationship('parent', 'name')
                ->searchable()->preload()->nullable(),
            Forms\Components\TextInput::make('icon')->label('Icon (emoji)')->placeholder('📁'),
            Forms\Components\TextInput::make('color')->label('Warna')->type('color'),
            Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(2),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Kategori')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')->label('Tipe')->badge(),
                Tables\Columns\TextColumn::make('parent.name')->label('Induk'),
                Tables\Columns\TextColumn::make('posts_count')->label('Posts')->counts('posts'),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('Urutan')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
