<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\Contact;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BlogAnalyticsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $totalViews = Post::where('status', 'published')->sum('views');
        $totalPosts = Post::where('status', 'published')->count();
        $totalDrafts = Post::where('status', 'draft')->count();
        $totalContacts = Contact::count();

        return [
            Stat::make('Total Tayangan', number_format($totalViews))
                ->icon('heroicon-o-eye')
                ->description('Dari ' . $totalPosts . ' artikel')
                ->color('primary'),

            Stat::make('Rata-rata Per Artikel', $totalPosts > 0 ? number_format(round($totalViews / $totalPosts)) : '0')
                ->icon('heroicon-o-chart-bar')
                ->color('info'),

            Stat::make('Draft Tersimpan', $totalDrafts)
                ->icon('heroicon-o-pencil-square')
                ->color('warning'),

            Stat::make('Total Leads (Contact)', number_format($totalContacts))
                ->icon('heroicon-o-users')
                ->color('success'),
        ];
    }
}
