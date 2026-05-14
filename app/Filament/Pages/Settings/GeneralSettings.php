<?php

namespace App\Filament\Pages\Settings;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class GeneralSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Pengaturan Umum';
    protected static ?int $navigationSort = 100;
    protected static string $view = 'filament.pages.settings.general-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $setting = Setting::getInstance();
        $this->form->fill($setting->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Perusahaan')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')->label('Nama Website')->required(),
                        Forms\Components\TextInput::make('site_tagline')->label('Tagline'),
                        Forms\Components\Textarea::make('site_description')->label('Deskripsi Singkat')->rows(3)->columnSpanFull(),
                        Forms\Components\FileUpload::make('logo')->label('Logo')->image()->imageResizeMode('cover')->imageResizeTargetWidth(400)->maxSize(1024)->directory('settings'),
                        Forms\Components\FileUpload::make('favicon')->label('Favicon')->image()->imageResizeMode('cover')->imageResizeTargetWidth(256)->maxSize(512)->directory('settings'),
                        Forms\Components\FileUpload::make('og_image')->label('OG Image (Social Share)')->image()->imageResizeMode('cover')->imageResizeTargetWidth(1200)->maxSize(20000)->directory('settings')->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('whatsapp')->label('No. WhatsApp')->placeholder('085804217886'),
                        Forms\Components\TextInput::make('email')->label('Email')->email(),
                        Forms\Components\TextInput::make('phone')->label('Telepon'),
                        Forms\Components\TextInput::make('city')->label('Kota'),
                        Forms\Components\TextInput::make('country')->label('Negara'),
                        Forms\Components\Textarea::make('address')->label('Alamat')->rows(2),
                        Forms\Components\Textarea::make('google_maps_embed')->label('Google Maps Embed Code')->rows(3)->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Sosial Media')
                    ->schema([
                        Forms\Components\TextInput::make('instagram')->label('Instagram')->placeholder('@sindelarastechnology'),
                        Forms\Components\TextInput::make('facebook')->label('Facebook'),
                        Forms\Components\TextInput::make('youtube')->label('YouTube'),
                        Forms\Components\TextInput::make('tiktok')->label('TikTok'),
                        Forms\Components\TextInput::make('linkedin')->label('LinkedIn'),
                        Forms\Components\TextInput::make('twitter')->label('Twitter / X'),
                        Forms\Components\TextInput::make('website_url')->label('Website URL')->url(),
                    ])->columns(2),

                Forms\Components\Section::make('Hero Section')
                    ->schema([
                        Forms\Components\TextInput::make('hero_title')->label('Judul Hero')->columnSpanFull(),
                        Forms\Components\TextInput::make('hero_subtitle')->label('Subjudul Hero')->columnSpanFull(),
                        Forms\Components\Textarea::make('hero_description')->label('Deskripsi Hero')->rows(3)->columnSpanFull(),
                        Forms\Components\TextInput::make('hero_cta_text')->label('Teks Tombol CTA'),
                        Forms\Components\TextInput::make('hero_cta_link')->label('Link Tombol CTA'),
                        Forms\Components\FileUpload::make('hero_image')->label('Gambar Hero')->image()->imageResizeMode('cover')->imageResizeTargetWidth(1920)->maxSize(20000)->directory('settings')->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Pengaturan Lainnya')
                    ->schema([
                        Forms\Components\Toggle::make('email_notification_enabled')
                            ->label('Aktifkan Notifikasi Email')
                            ->helperText('Kirim email notifikasi saat ada kontak baru'),
                        Forms\Components\TextInput::make('cache_ttl')
                            ->label('Cache Duration (detik)')
                            ->numeric()
                            ->default(3600)
                            ->helperText('Lama cache settings disimpan'),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $setting = Setting::getInstance();
        $setting->update($data);
        Setting::clearCache();

        Notification::make()->title('Pengaturan berhasil disimpan!')->success()->send();
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
