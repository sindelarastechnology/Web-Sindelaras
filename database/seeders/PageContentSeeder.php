<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'page_key' => 'about',
                'title' => 'Tentang Kami',
                'subtitle' => 'Mengenal Sindelaras Technology',
                'content' => 'Sindelaras Technology adalah perusahaan yang bergerak di bidang teknologi informasi dan solusi bisnis. Kami berkomitmen untuk memberikan layanan terbaik dalam pengembangan website, aplikasi mobile, dan solusi digital lainnya.',
                'meta_title' => 'Tentang Sindelaras Technology',
                'meta_description' => 'Kenali lebih dekat Sindelaras Technology, mitra solusi IT dan bisnis digital Anda.',
            ],
            [
                'page_key' => 'home',
                'title' => 'Sindelaras Technology',
                'subtitle' => 'Your IT and Business Solution',
                'meta_title' => 'Sindelaras Technology - Solusi IT dan Bisnis Digital',
                'meta_description' => 'Sindelaras Technology menyediakan layanan pembuatan website, aplikasi mobile, dan solusi bisnis digital terpercaya.',
            ],
            [
                'page_key' => 'contact',
                'title' => 'Hubungi Kami',
                'subtitle' => 'Diskusikan kebutuhan Anda',
                'meta_title' => 'Kontak Sindelaras Technology',
                'meta_description' => 'Hubungi Sindelaras Technology untuk konsultasi gratis tentang kebutuhan IT dan bisnis digital Anda.',
            ],
        ];

        foreach ($pages as $page) {
            PageContent::create($page);
        }
    }
}
