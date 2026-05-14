<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamMemberResource\Pages;
use App\Models\TeamMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Halaman';
    protected static ?string $navigationLabel = 'Tim Kami';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('photo')
                ->label('Foto')->image()->imageEditor()
                ->imageResizeMode('cover')->imageResizeTargetWidth(400)->maxSize(1024)
                ->directory('team')->avatar()->columnSpanFull(),
            Forms\Components\TextInput::make('name')->label('Nama Lengkap')->required(),
            Forms\Components\TextInput::make('position')->label('Jabatan')->required(),
            Forms\Components\Textarea::make('bio')->label('Bio Singkat')->rows(3)->columnSpanFull(),
            Forms\Components\TextInput::make('instagram')->label('Instagram')->placeholder('@username'),
            Forms\Components\TextInput::make('linkedin')->label('LinkedIn')->url(),
            Forms\Components\TextInput::make('github')->label('GitHub')->url(),
            Forms\Components\TextInput::make('email')->label('Email')->email(),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->label('Tampilkan')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')->label('Foto')->circular(),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('position')->label('Jabatan'),
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
            'index'  => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit'   => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}
