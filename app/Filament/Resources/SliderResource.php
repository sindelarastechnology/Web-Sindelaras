<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Halaman';
    protected static ?string $navigationLabel = 'Slider Hero';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Konten Slider')
                ->schema([
                    Forms\Components\TextInput::make('title')->label('Judul'),
                    Forms\Components\TextInput::make('subtitle')->label('Subjudul'),
                    Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(3)->columnSpanFull(),
                    Forms\Components\TextInput::make('button_text')->label('Teks Tombol 1'),
                    Forms\Components\TextInput::make('button_link')->label('Link Tombol 1'),
                    Forms\Components\TextInput::make('button_text_2')->label('Teks Tombol 2'),
                    Forms\Components\TextInput::make('button_link_2')->label('Link Tombol 2'),
                ])->columns(2),

            Forms\Components\Section::make('Media')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar Background (Desktop)')
                        ->image()->imageEditor()
                        ->imageResizeMode('cover')->imageResizeTargetWidth(1920)->maxSize(2048)
                        ->directory('sliders')->nullable()->columnSpanFull(),
                    Forms\Components\FileUpload::make('mobile_image')
                        ->label('Gambar Background (Mobile)')
                        ->image()->imageEditor()
                        ->imageResizeMode('cover')->imageResizeTargetWidth(1080)->maxSize(2048)
                        ->directory('sliders')->columnSpanFull(),
                    Forms\Components\ColorPicker::make('text_color')
                        ->label('Warna Teks')->default('#ffffff'),
                ]),

            Forms\Components\Section::make('Pengaturan')
                ->schema([
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Gambar'),
                Tables\Columns\TextColumn::make('title')->label('Judul')->limit(40),
                Tables\Columns\TextColumn::make('button_text')->label('CTA'),
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
            'index'  => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit'   => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
