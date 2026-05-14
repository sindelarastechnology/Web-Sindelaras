<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Laravel', 'slug' => 'laravel', 'color' => '#ff2d20'],
            ['name' => 'Vue.js', 'slug' => 'vuejs', 'color' => '#4fc08d'],
            ['name' => 'React', 'slug' => 'react', 'color' => '#61dafb'],
            ['name' => 'PHP', 'slug' => 'php', 'color' => '#777bb4'],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'color' => '#f7df1e'],
            ['name' => 'MySQL', 'slug' => 'mysql', 'color' => '#4479a1'],
            ['name' => 'Tailwind CSS', 'slug' => 'tailwind-css', 'color' => '#06b6d4'],
            ['name' => 'Flutter', 'slug' => 'flutter', 'color' => '#02569b'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
