<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Layanan & Portfolio';
    protected static ?string $navigationLabel = 'Testimonial';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Klien')
                ->schema([
                    Forms\Components\TextInput::make('client_name')
                        ->label('Nama Klien')->required(),
                    Forms\Components\TextInput::make('client_position')
                        ->label('Jabatan / Posisi'),
                    Forms\Components\TextInput::make('client_company')
                        ->label('Nama Perusahaan'),
                    Forms\Components\FileUpload::make('client_photo')
                        ->label('Foto Klien')
                        ->image()
                        ->imageEditor()
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth(400)
                        ->maxSize(1024)
                        ->directory('testimonials')
                        ->avatar(),
                ])->columns(2),

            Forms\Components\Section::make('Konten')
                ->schema([
                    Forms\Components\Textarea::make('content')
                        ->label('Isi Testimonial')->required()->rows(4)->columnSpanFull(),
                    Forms\Components\Select::make('rating')
                        ->label('Rating Bintang')
                        ->options([1 => '⭐', 2 => '⭐⭐', 3 => '⭐⭐⭐', 4 => '⭐⭐⭐⭐', 5 => '⭐⭐⭐⭐⭐'])
                        ->default(5)->required(),
                    Forms\Components\Select::make('portfolio_id')
                        ->label('Terkait Portfolio')
                        ->relationship('portfolio', 'title')
                        ->searchable()->preload()->nullable(),
                    Forms\Components\Select::make('service_id')
                        ->label('Terkait Layanan')
                        ->relationship('service', 'title')
                        ->searchable()->preload()->nullable(),
                    Forms\Components\TextInput::make('client_location')
                        ->label('Lokasi Klien')
                        ->placeholder('Jakarta, Indonesia'),
                    Forms\Components\TextInput::make('service_used')
                        ->label('Layanan yang Digunakan')
                        ->placeholder('Pembuatan Website, Aplikasi, dll'),
                    Forms\Components\TextInput::make('source')
                        ->label('Sumber Testimonial')
                        ->placeholder('Google Reviews, Website, dll'),
                    Forms\Components\TextInput::make('video_url')
                        ->label('URL Video Testimonial')
                        ->placeholder('https://www.youtube.com/watch?v=...')
                        ->url(),
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->label('Tampilkan')->default(true),
                    Forms\Components\Toggle::make('is_featured')->label('Featured'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('client_photo')->label('Foto')->circular(),
                Tables\Columns\TextColumn::make('client_name')->label('Klien')->searchable(),
                Tables\Columns\TextColumn::make('client_company')->label('Perusahaan'),
                Tables\Columns\TextColumn::make('content')->label('Testimonial')->limit(60),
                Tables\Columns\TextColumn::make('rating')->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', min($state, 5))),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('video_url')->label('Video')->formatStateUsing(fn ($state) => $state ? '▶️ Ada' : '—'),
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
            'index'  => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit'   => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
