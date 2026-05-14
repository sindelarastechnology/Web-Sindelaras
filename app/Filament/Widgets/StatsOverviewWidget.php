<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Postingan', Post::where('status', 'published')->count())
                ->icon('heroicon-o-document-text')
                ->color('primary'),

            Stat::make('Pesan Baru', Contact::where('status', 'new')->count())
                ->icon('heroicon-o-envelope')
                ->color('warning'),

            Stat::make('Total Portfolio', Portfolio::where('is_active', true)->count())
                ->icon('heroicon-o-photo')
                ->color('success'),

            Stat::make('Total Layanan', Service::where('is_active', true)->count())
                ->icon('heroicon-o-briefcase')
                ->color('info'),
        ];
    }
}
