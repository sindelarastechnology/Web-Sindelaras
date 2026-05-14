<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            ['icon' => 'briefcase', 'value' => '50+', 'label' => 'Proyek Selesai', 'description' => 'Proyek yang telah kami selesaikan dengan sukses', 'sort_order' => 1],
            ['icon' => 'users', 'value' => '30+', 'label' => 'Klien Puas', 'description' => 'Klien yang percaya pada layanan kami', 'sort_order' => 2],
            ['icon' => 'calendar', 'value' => '3+', 'label' => 'Tahun Pengalaman', 'description' => 'Pengalaman di industri teknologi', 'sort_order' => 3],
            ['icon' => 'star', 'value' => '100%', 'label' => 'Tepat Waktu', 'description' => 'Komitmen kami terhadap deadline proyek', 'sort_order' => 4],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
