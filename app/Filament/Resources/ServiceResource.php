<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers\ServicePackagesRelationManager;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Layanan & Portfolio';
    protected static ?string $navigationLabel = 'Layanan';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Layanan')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Nama Layanan')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($operation, $state, Forms\Set $set) =>
                            $operation === 'create' ? $set('slug', \Str::slug($state)) : null
                        ),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(Service::class, 'slug', ignoreRecord: true),
                    Forms\Components\Select::make('category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload(),
                    Forms\Components\TextInput::make('icon')
                        ->label('Icon (emoji)')
                        ->placeholder('🌐'),
                ])->columns(2),

            Forms\Components\Section::make('Deskripsi')
                ->schema([
                    Forms\Components\Textarea::make('short_description')
                        ->label('Deskripsi Singkat (untuk card)')
                        ->rows(3)
                        ->maxLength(300),
                    TiptapEditor::make('description')
                        ->label('Deskripsi Lengkap')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Media')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar Thumbnail')
                        ->image()
                        ->imageEditor()
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth(1920)
                        ->maxSize(2048)
                        ->directory('services/thumbnails'),
                    Forms\Components\FileUpload::make('banner_image')
                        ->label('Banner Halaman Detail')
                        ->image()
                        ->imageEditor()
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth(1920)
                        ->maxSize(2048)
                        ->directory('services/banners'),
                ])->columns(2),

            Forms\Components\Section::make('Harga (Opsional)')
                ->schema([
                    Forms\Components\Toggle::make('show_price')
                        ->label('Tampilkan Harga'),
                    Forms\Components\TextInput::make('price_from')
                        ->label('Harga Mulai Dari')
                        ->numeric()
                        ->prefix('Rp'),
                    Forms\Components\TextInput::make('price_to')
                        ->label('Harga Sampai')
                        ->numeric()
                        ->prefix('Rp'),
                    Forms\Components\TextInput::make('price_unit')
                        ->label('Satuan Harga')
                        ->placeholder('/ project, / bulan'),
                ])->columns(2),

            Forms\Components\Section::make('Fitur & Proses')
                ->schema([
                    Forms\Components\Repeater::make('features')
                        ->label('Fitur / Yang Didapat')
                        ->schema([
                            Forms\Components\TextInput::make('feature')->label('Fitur')->required(),
                        ])
                        ->defaultItems(0)
                        ->addActionLabel('Tambah Fitur'),
                    Forms\Components\Repeater::make('process_steps')
                        ->label('Langkah Proses')
                        ->schema([
                            Forms\Components\TextInput::make('step')->label('Langkah')->required(),
                        ])
                        ->defaultItems(0)
                        ->addActionLabel('Tambah Langkah'),
                ])->columns(2),

            Forms\Components\Section::make('CTA & Tombol')
                ->schema([
                    Forms\Components\TextInput::make('cta_text')
                        ->label('Teks Tombol CTA')
                        ->placeholder('Konsultasi Sekarang'),
                    Forms\Components\TextInput::make('cta_link')
                        ->label('Link Tombol CTA')
                        ->placeholder('https:// atau #kontak'),
                    Forms\Components\Textarea::make('whatsapp_template')
                        ->label('Template Pesan WhatsApp')
                        ->rows(2)
                        ->helperText('Pesan default saat klik tombol WhatsApp'),
                ])->columns(2),

            Forms\Components\Section::make('SEO & Pengaturan')
                ->schema([
                    Forms\Components\TextInput::make('meta_title')->label('Meta Title (SEO)'),
                    Forms\Components\Textarea::make('meta_description')->label('Meta Description (SEO)')->rows(2),
                    Forms\Components\TextInput::make('meta_keywords')->label('Meta Keywords'),
                    Forms\Components\TextInput::make('sort_order')->label('Urutan Tampil')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                    Forms\Components\Toggle::make('is_featured')->label('Tampilkan di Homepage'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Foto'),
                Tables\Columns\TextColumn::make('icon')->label('Icon'),
                Tables\Columns\TextColumn::make('title')->label('Layanan')->searchable()->sortable(),
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
        return [
            ServicePackagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit'   => Pages\EditService::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withTrashed();
    }
}
