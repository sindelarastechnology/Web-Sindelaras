<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicePackageResource\Pages;
use App\Models\ServicePackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServicePackageResource extends Resource
{
    protected static ?string $model = ServicePackage::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Layanan & Portfolio';
    protected static ?string $navigationLabel = 'Paket Layanan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Paket')
                ->schema([
                    Forms\Components\Select::make('service_id')
                        ->label('Layanan')
                        ->relationship('service', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Paket')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($operation, $state, Forms\Set $set) =>
                            $operation === 'create' ? $set('slug', \Str::slug($state)) : null
                        ),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ServicePackage::class, 'slug', ignoreRecord: true),
                    Forms\Components\Textarea::make('short_description')
                        ->label('Deskripsi Singkat')
                        ->rows(2)
                        ->maxLength(300),
                ])->columns(2),

            Forms\Components\Section::make('Harga')
                ->schema([
                    Forms\Components\TextInput::make('price')
                        ->label('Harga Normal')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),
                    Forms\Components\TextInput::make('price_sale')
                        ->label('Harga Promo')
                        ->numeric()
                        ->prefix('Rp')
                        ->helperText('Kosongi jika tidak ada promo'),
                    Forms\Components\Select::make('price_unit')
                        ->label('Satuan Harga')
                        ->options([
                            '/ project' => '/ project',
                            '/ bulan' => '/ bulan',
                            '/ tahun' => '/ tahun',
                            '/ sekali' => '/ sekali',
                        ])
                        ->default('/ project'),
                    Forms\Components\Toggle::make('is_popular')
                        ->label('Beri label POPULAR')
                        ->helperText('Menampilkan badge popular di card paket'),
                ])->columns(2),

            Forms\Components\Section::make('Fitur & Detail')
                ->schema([
                    Forms\Components\Repeater::make('features')
                        ->label('Fitur Paket')
                        ->schema([
                            Forms\Components\TextInput::make('feature')
                                ->label('Fitur')
                                ->required(),
                            Forms\Components\Select::make('icon')
                                ->label('Icon')
                                ->options([
                                    '✅' => '✅ Centang',
                                    '⭐' => '⭐ Star',
                                    '🎨' => '🎨 Desain',
                                    '⚡' => '⚡ Cepat',
                                    '🔒' => '🔒 Aman',
                                    '📱' => '📱 Mobile',
                                    '📊' => '📊 Laporan',
                                    '🛒' => '🛒 E-commerce',
                                    '🌐' => '🌐 Domain',
                                    '🖥️' => '🖥️ Hosting',
                                    '📧' => '📧 Email',
                                    '🔧' => '🔧 Maintenance',
                                    '📝' => '📝 Revisi',
                                    '🤝' => '🤝 Support',
                                ])
                                ->default('✅')
                                ->searchable(),
                        ])
                        ->defaultItems(3)
                        ->addActionLabel('Tambah Fitur')
                        ->reorderable()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('delivery_time')
                        ->label('Waktu Pengerjaan')
                        ->placeholder('7-14 Hari'),
                    Forms\Components\TextInput::make('maintenance')
                        ->label('Layanan Maintenance')
                        ->placeholder('Free 1 Bulan'),
                    Forms\Components\Repeater::make('bonus')
                        ->label('Bonus')
                        ->schema([
                            Forms\Components\TextInput::make('bonus')->label('Bonus')->required(),
                        ])
                        ->defaultItems(0)
                        ->addActionLabel('Tambah Bonus')
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Pengaturan')
                ->schema([
                    Forms\Components\TextInput::make('cta_text')
                        ->label('Teks Tombol')
                        ->default('Pilih Paket'),
                    Forms\Components\TextInput::make('sort_order')
                        ->label('Urutan')
                        ->numeric()
                        ->default(0),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service.title')
                    ->label('Layanan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Paket')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_popular')
                    ->label('Popular')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('features')
                    ->label('Fitur')
                    ->formatStateUsing(fn ($state) => is_array($state) ? count($state) . ' fitur' : '0'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('service')
                    ->relationship('service', 'title')
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListServicePackages::route('/'),
            'create' => Pages\CreateServicePackage::route('/create'),
            'edit' => Pages\EditServicePackage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withTrashed();
    }
}
