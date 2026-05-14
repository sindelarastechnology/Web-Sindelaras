<?php

namespace App\Filament\Pages\Settings;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class SeoSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Pengaturan SEO';
    protected static ?int $navigationSort = 101;
    protected static string $view = 'filament.pages.settings.seo-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::getInstance()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('SEO Global')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title Global')->maxLength(60)
                            ->helperText('Maks. 60 karakter'),
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description Global')->rows(3)->maxLength(160)
                            ->helperText('Maks. 160 karakter'),
                        Forms\Components\TextInput::make('meta_keywords')
                            ->label('Meta Keywords')->placeholder('laravel, website, kediri'),
                    ])->columns(2),

                Forms\Components\Section::make('Google Tools')
                    ->schema([
                        Forms\Components\TextInput::make('google_analytics_id')
                            ->label('Google Analytics ID')->placeholder('G-XXXXXXXXXX'),
                        Forms\Components\TextInput::make('google_search_console')
                            ->label('Google Search Console Meta Tag'),
                    ])->columns(2),

                Forms\Components\Section::make('Custom Scripts')
                    ->schema([
                        Forms\Components\Textarea::make('custom_head_scripts')
                            ->label('Script di <head>')->rows(5)->columnSpanFull()
                            ->helperText('Untuk Meta Pixel, Google Tag Manager, dll.'),
                        Forms\Components\Textarea::make('custom_footer_scripts')
                            ->label('Script sebelum </body>')->rows(5)->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        Setting::getInstance()->update($this->form->getState());
        Setting::clearCache();
        Notification::make()->title('Pengaturan SEO disimpan!')->success()->send();
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
