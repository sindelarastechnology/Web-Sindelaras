<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Post categories
            ['name' => 'Teknologi', 'type' => 'post', 'slug' => 'teknologi', 'description' => 'Artikel seputar teknologi terbaru', 'sort_order' => 1],
            ['name' => 'Bisnis', 'type' => 'post', 'slug' => 'bisnis', 'description' => 'Tips dan strategi bisnis digital', 'sort_order' => 2],
            ['name' => 'Tutorial', 'type' => 'post', 'slug' => 'tutorial', 'description' => 'Panduan dan tutorial teknis', 'sort_order' => 3],

            // Service categories
            ['name' => 'Web Development', 'type' => 'service', 'slug' => 'web-development', 'description' => 'Layanan pembuatan website', 'icon' => 'code-bracket', 'sort_order' => 1],
            ['name' => 'Mobile Development', 'type' => 'service', 'slug' => 'mobile-development', 'description' => 'Layanan pembuatan aplikasi mobile', 'icon' => 'device-phone-mobile', 'sort_order' => 2],
            ['name' => 'UI/UX Design', 'type' => 'service', 'slug' => 'ui-ux-design', 'description' => 'Layanan desain antarmuka', 'icon' => 'pencil-square', 'sort_order' => 3],

            // Portfolio categories
            ['name' => 'Website', 'type' => 'portfolio', 'slug' => 'website', 'description' => 'Project website', 'sort_order' => 1],
            ['name' => 'Aplikasi Mobile', 'type' => 'portfolio', 'slug' => 'aplikasi-mobile', 'description' => 'Project aplikasi mobile', 'sort_order' => 2],
            ['name' => 'Desktop App', 'type' => 'portfolio', 'slug' => 'desktop-app', 'description' => 'Project aplikasi desktop', 'sort_order' => 3],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
