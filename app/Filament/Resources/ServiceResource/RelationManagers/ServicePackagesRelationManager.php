<?php

namespace App\Filament\Resources\ServiceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ServicePackagesRelationManager extends RelationManager
{
    protected static string $relationship = 'packages';
    protected static ?string $title = 'Paket Layanan';
    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Paket')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Paket')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($operation, $state, Forms\Set $set) =>
                            $operation === 'create' ? $set('slug', \Str::slug($state)) : null
                        ),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique('service_packages', 'slug', ignoreRecord: true),
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
                        ->prefix('Rp'),
                    Forms\Components\Select::make('price_unit')
                        ->label('Satuan')
                        ->options([
                            '/ project' => '/ project',
                            '/ bulan' => '/ bulan',
                            '/ tahun' => '/ tahun',
                        ])
                        ->default('/ project'),
                    Forms\Components\Toggle::make('is_popular')
                        ->label('Label POPULAR'),
                ])->columns(2),

            Forms\Components\Section::make('Fitur')
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
                                    '✅' => '✅',
                                    '⭐' => '⭐',
                                    '🎨' => '🎨',
                                    '⚡' => '⚡',
                                    '🔒' => '🔒',
                                    '📱' => '📱',
                                    '🌐' => '🌐',
                                    '🖥️' => '🖥️',
                                    '🔧' => '🔧',
                                    '🤝' => '🤝',
                                ])
                                ->default('✅'),
                        ])
                        ->defaultItems(3)
                        ->addActionLabel('Tambah Fitur')
                        ->reorderable()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('delivery_time')
                        ->label('Waktu Pengerjaan')
                        ->placeholder('7-14 Hari'),
                    Forms\Components\TextInput::make('maintenance')
                        ->label('Maintenance')
                        ->placeholder('Free 1 Bulan'),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
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
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
