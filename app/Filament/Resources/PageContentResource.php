<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageContentResource\Pages;
use App\Models\PageContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;

class PageContentResource extends Resource
{
    protected static ?string $model = PageContent::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Halaman (About, Privacy)';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Halaman')
                ->schema([
                    Forms\Components\Select::make('page_key')
                        ->label('Jenis Halaman')
                        ->options([
                            'about'   => 'Tentang Kami',
                            'privacy' => 'Kebijakan Privasi',
                        ])
                        ->required()
                        ->unique(PageContent::class, 'page_key', ignoreRecord: true)
                        ->helperText('Setiap jenis halaman hanya bisa dibuat satu kali.'),
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Halaman')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('subtitle')
                        ->label('Subjudul')
                        ->maxLength(255),
                ])->columns(2),

            Forms\Components\Section::make('Konten')
                ->schema([
                    TiptapEditor::make('content')
                        ->label('Konten Halaman')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('banner_image')
                        ->label('Gambar Banner')
                        ->image()
                        ->imageEditor()
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth(1920)
                        ->maxSize(2048)
                        ->directory('pages/banners'),
                ]),

            Forms\Components\Section::make('SEO')
                ->schema([
                    Forms\Components\TextInput::make('meta_title')
                        ->label('Meta Title')
                        ->maxLength(60),
                    Forms\Components\Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->rows(2)
                        ->maxLength(160),
                ])->columns(2),

            Forms\Components\Section::make('Data Tambahan (Opsional)')
                ->schema([
                    Forms\Components\KeyValue::make('extra_data')
                        ->label('Data Tambahan (JSON)'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page_key')
                    ->label('Halaman')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'about'   => 'Tentang Kami',
                        'privacy' => 'Kebijakan Privasi',
                        default   => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'about'   => 'info',
                        'privacy' => 'warning',
                        default   => 'gray',
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('page_key')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPageContents::route('/'),
            'create' => Pages\CreatePageContent::route('/create'),
            'edit'   => Pages\EditPageContent::route('/{record}/edit'),
        ];
    }
}
