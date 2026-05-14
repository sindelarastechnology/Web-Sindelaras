<?php

namespace App\Filament\Pages\Settings;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class AppearanceSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Tampilan';
    protected static ?int $navigationSort = 102;
    protected static string $view = 'filament.pages.settings.appearance-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::getInstance()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tema & Warna')
                    ->schema([
                        Forms\Components\Select::make('default_theme')
                            ->label('Tema Default')
                            ->options(['light' => '☀️ Light Mode', 'dark' => '🌙 Dark Mode'])
                            ->default('light'),
                        Forms\Components\ColorPicker::make('primary_color')
                            ->label('Warna Utama')->default('#1e40af'),
                        Forms\Components\ColorPicker::make('accent_color')
                            ->label('Warna Aksen (CTA)')->default('#f97316'),
                    ])->columns(3),

                Forms\Components\Section::make('Maintenance Mode')
                    ->schema([
                        Forms\Components\Toggle::make('maintenance_mode')
                            ->label('Aktifkan Maintenance Mode'),
                        Forms\Components\Textarea::make('maintenance_message')
                            ->label('Pesan Maintenance')->rows(2)->columnSpanFull()
                            ->placeholder('Website sedang dalam pemeliharaan. Kami segera kembali!'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        Setting::getInstance()->update($this->form->getState());
        Setting::clearCache();
        Notification::make()->title('Pengaturan tampilan disimpan!')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Simpan Pengaturan')
                ->submit('save'),
        ];
    }
}
