<?php

namespace App\Filament\Pages;

use App\Models\Contact;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Service;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = 0;
    protected static string $view = 'filament.pages.dashboard';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverviewWidget::class,
            \App\Filament\Widgets\BlogAnalyticsWidget::class,
            \App\Filament\Widgets\PopularPostsWidget::class,
            \App\Filament\Widgets\LatestContactsWidget::class,
            \App\Filament\Widgets\RecentPostsWidget::class,
        ];
    }

    public function getTitle(): string
    {
        return 'Dashboard Sindelaras';
    }
}
