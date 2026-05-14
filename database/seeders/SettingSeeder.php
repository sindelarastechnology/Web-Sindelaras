<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'site_name'       => 'Sindelaras Technology',
            'site_tagline'    => 'Your IT and Business Solution',
            'site_description' => 'Kami menyediakan solusi teknologi dan bisnis untuk membantu Anda berkembang di era digital.',
            'whatsapp'        => '6281234567890',
            'email'           => 'sindelarastechnology@gmail.com',
            'phone'           => '021-12345678',
            'address'         => 'Jl. Contoh No. 123, Jakarta',
            'city'            => 'Jakarta',
            'country'         => 'Indonesia',
            'instagram'       => 'https://instagram.com/sindelarastechnology',
            'facebook'        => 'https://facebook.com/sindelarastechnology',
            'youtube'         => 'https://youtube.com/@sindelarastechnology',
            'meta_title'       => 'Sindelaras Technology - Your IT and Business Solution',
            'meta_description' => 'Sindelaras Technology menyediakan layanan pembuatan website, aplikasi mobile, dan solusi bisnis digital.',
            'meta_keywords'    => 'sindelaras, technology, it solution, web development, aplikasi',
            'primary_color'    => '#1e40af',
            'accent_color'     => '#f97316',
            'hero_title'       => 'Solusi Teknologi untuk Bisnis Anda',
            'hero_subtitle'    => 'Sindelaras Technology',
            'hero_description' => 'Kami membantu Anda membangun kehadiran digital yang kuat dengan solusi IT yang inovatif dan terpercaya.',
            'hero_cta_text'    => 'Hubungi Kami',
            'hero_cta_link'    => '#contact',
            'email_notification_enabled' => true,
            'cache_ttl'        => 3600,
        ]);
    }
}
