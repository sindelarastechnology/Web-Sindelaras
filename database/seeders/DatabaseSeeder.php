<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            AchievementSeeder::class,
            PageContentSeeder::class,
            ServicePackageSeeder::class,
        ]);
    }
}
