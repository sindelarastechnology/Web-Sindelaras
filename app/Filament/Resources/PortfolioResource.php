<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Models\Portfolio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Layanan & Portfolio';
    protected static ?string $navigationLabel = 'Portfolio';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Proyek')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Proyek')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($operation, $state, Forms\Set $set) =>
                            $operation === 'create' ? $set('slug', \Str::slug($state)) : null
                        ),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(Portfolio::class, 'slug', ignoreRecord: true),
                    Forms\Components\TextInput::make('client_name')
                        ->label('Nama Klien'),
                    Forms\Components\TextInput::make('client_industry')
                        ->label('Industri Klien')
                        ->placeholder('Teknologi, Kesehatan, dll'),
                    Forms\Components\TextInput::make('client_position')
                        ->label('Jabatan Klien'),
                    Forms\Components\FileUpload::make('client_photo')
                        ->label('Foto Klien')
                        ->image()
                        ->imageEditor()
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth(400)
                        ->maxSize(1024)
                        ->directory('portfolio/clients')
                        ->avatar(),
                    Forms\Components\Select::make('category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload(),
                    Forms\Components\Select::make('tags')
                        ->label('Teknologi / Tag')
                        ->relationship('tags', 'name')
                        ->multiple()
                        ->searchable()
                        ->preload(),
                    Forms\Components\TextInput::make('live_url')
                        ->label('URL Proyek')
                        ->url()
                        ->placeholder('https://'),
                    Forms\Components\TextInput::make('github_url')
                        ->label('GitHub URL')
                        ->url()
                        ->placeholder('https://github.com/'),
                    Forms\Components\TextInput::make('demo_url')
                        ->label('Demo URL')
                        ->url()
                        ->placeholder('https://'),
                ])->columns(2),

            Forms\Components\Section::make('Deskripsi')
                ->schema([
                    Forms\Components\Textarea::make('short_description')
                        ->label('Deskripsi Singkat (card)')
                        ->rows(2)
                        ->maxLength(300),
                    TiptapEditor::make('description')
                        ->label('Deskripsi Lengkap')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Media')
                ->schema([
                    Forms\Components\FileUpload::make('thumbnail')
                        ->label('Thumbnail Utama')
                        ->image()
                        ->imageEditor()
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth(1920)
                        ->maxSize(20000)
                        ->directory('portfolio/thumbnails')
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('gallery')
                        ->label('Gallery Foto')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth(1920)
                        ->maxSize(20000)
                        ->directory('portfolio/gallery')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Informasi Tambahan')
                ->schema([
                    Forms\Components\DatePicker::make('project_date')->label('Tanggal Proyek'),
                    Forms\Components\TextInput::make('project_duration')->label('Durasi')->placeholder('2 Minggu'),
                    Forms\Components\Select::make('project_type')
                        ->label('Tipe Proyek')
                        ->options([
                            'website'      => 'Website',
                            'aplikasi_web' => 'Aplikasi Web',
                            'android'      => 'Aplikasi Android',
                            'desktop'      => 'Aplikasi Desktop',
                            'data'         => 'Data & Analisis',
                            'lainnya'      => 'Lainnya',
                        ])
                        ->required(),
                    Forms\Components\Repeater::make('technologies')
                        ->label('Teknologi yang Digunakan')
                        ->schema([
                            Forms\Components\TextInput::make('tech')->label('Teknologi')->required(),
                        ])
                        ->defaultItems(0)
                        ->addActionLabel('Tambah Teknologi'),
                    Forms\Components\TextInput::make('meta_title')->label('Meta Title'),
                    Forms\Components\Textarea::make('meta_description')->label('Meta Description')->rows(2),
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                    Forms\Components\Toggle::make('is_featured')->label('Featured Homepage'),
                    Forms\Components\Textarea::make('client_testimonial')
                        ->label('Testimonial Klien')
                        ->rows(3),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')->label('Foto')->square(),
                Tables\Columns\TextColumn::make('title')->label('Proyek')->searchable()->sortable()->limit(40),
                Tables\Columns\TextColumn::make('client_name')->label('Klien')->searchable(),
                Tables\Columns\TextColumn::make('category.name')->label('Kategori')->badge(),
                Tables\Columns\IconColumn::make('is_featured')->label('Featured')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('Urutan')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')->relationship('category', 'name'),
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
            'index'  => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit'   => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withTrashed();
    }
}
