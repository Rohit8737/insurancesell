<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Posts', Post::count())
                ->description('All posts in database')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),
            
            Stat::make('Active Posts', Post::where('is_active', true)->count())
                ->description('Published and visible')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            
            Stat::make('Total Views', number_format(Post::sum('views')))
                ->description('Lifetime page views')
                ->descriptionIcon('heroicon-o-eye')
                ->color('info'),
            
            Stat::make('Unread Messages', ContactMessage::where('is_read', false)->count())
                ->description('Pending contact forms')
                ->descriptionIcon('heroicon-o-envelope')
                ->color('warning'),
        ];
    }
}
