<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name', 'site_tagline', 'site_description', 'logo', 'favicon', 'og_image',
        'whatsapp', 'email', 'phone', 'address', 'city', 'country', 'google_maps_embed',
        'instagram', 'facebook', 'youtube', 'tiktok', 'linkedin', 'twitter', 'website_url',
        'meta_title', 'meta_description', 'meta_keywords', 'google_analytics_id',
        'google_search_console', 'custom_head_scripts', 'custom_footer_scripts',
        'default_theme', 'primary_color', 'accent_color', 'maintenance_mode',
        'maintenance_message', 'email_notification_enabled', 'cache_ttl',
        'hero_title', 'hero_subtitle', 'hero_description', 'hero_cta_text',
        'hero_cta_link', 'hero_image',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
        'email_notification_enabled' => 'boolean',
        'cache_ttl' => 'integer',
    ];

    public static function getInstance(): self
    {
        try {
            return cache()->remember('site_settings', static::getCacheTtl(), function () {
                return static::firstOrCreate(['id' => 1]);
            });
        } catch (\Exception $e) {
            return new self();
        }
    }

    public static function getCacheTtl(): int
    {
        try {
            return cache()->remember('settings_ttl', 86400, function () {
                $settings = static::first();
                return $settings?->cache_ttl ?? 3600;
            });
        } catch (\Exception $e) {
            return 3600;
        }
    }

    public static function clearCache(): void
    {
        cache()->forget('site_settings');
        cache()->forget('settings_ttl');
    }
}
