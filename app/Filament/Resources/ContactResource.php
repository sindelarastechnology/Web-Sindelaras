<?php

namespace App\Filament\Resources;

use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Pesan Masuk';
    protected static ?string $navigationLabel = 'Pesan Masuk';
    protected static ?int $navigationSort = 10;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getNewContactCount() ?: null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getNewContactCount() > 0 ? 'warning' : null;
    }

    private static function getNewContactCount(): int
    {
        return \Illuminate\Support\Facades\Cache::remember('new_contact_count', 60, fn () => Contact::where('status', 'new')->count());
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Detail Pesan')
                ->schema([
                    Forms\Components\TextInput::make('name')->label('Nama')->disabled(),
                    Forms\Components\TextInput::make('email')->label('Email')->disabled(),
                    Forms\Components\TextInput::make('phone')->label('Telepon')->disabled(),
                    Forms\Components\TextInput::make('company')->label('Perusahaan')->disabled(),
                    Forms\Components\TextInput::make('subject')->label('Subjek')->disabled(),
                    Forms\Components\TextInput::make('budget')->label('Estimasi Budget')->disabled(),
                    Forms\Components\TextInput::make('timeline')->label('Target Timeline')->disabled(),
                    Forms\Components\Textarea::make('message')->label('Pesan')->rows(5)->disabled()->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Tindak Lanjut')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'new'         => 'Baru',
                            'read'        => 'Sudah Dibaca',
                            'in_progress' => 'Dalam Proses',
                            'replied'     => 'Sudah Dibalas',
                            'closed'      => 'Ditutup',
                        ]),
                    Forms\Components\Textarea::make('admin_notes')
                        ->label('Catatan Admin')
                        ->rows(3),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Telepon')->toggleable(),
                Tables\Columns\TextColumn::make('subject')->label('Subjek')->limit(40),
                Tables\Columns\TextColumn::make('budget')->label('Budget')->toggleable()->badge()->color('warning'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'warning',
                        'read' => 'info',
                        'in_progress' => 'primary',
                        'replied' => 'success',
                        'closed' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['new' => 'Baru', 'read' => 'Dibaca', 'in_progress' => 'Proses', 'replied' => 'Dibalas', 'closed' => 'Ditutup']),
                Tables\Filters\SelectFilter::make('budget')
                    ->options(['< 5 Juta' => '< Rp 5 Juta', '5-15 Juta' => 'Rp 5-15 Juta', '15-50 Juta' => 'Rp 15-50 Juta', '50-100 Juta' => 'Rp 50-100 Juta', '> 100 Juta' => '> Rp 100 Juta']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('wa_reply')
                    ->label('Balas WA')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn (Contact $record): string => whatsappLink(
                        $record->phone ?: site_whatsapp(),
                        'Halo ' . $record->name . ', terima kasih sudah menghubungi Sindelaras Technology. Kami sudah menerima pesan Anda mengenai "' . $record->subject . '" dan akan segera menghubungi Anda. Ada yang bisa kami bantu lebih lanjut?'
                    ))
                    ->openUrlInNewTab()
                    ->visible(fn (Contact $record): bool => !is_null($record->phone)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ContactResource\Pages\ListContacts::route('/'),
            'view' => \App\Filament\Resources\ContactResource\Pages\ViewContact::route('/{record}'),
            'edit' => \App\Filament\Resources\ContactResource\Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
