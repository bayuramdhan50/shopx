<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LatestOrdersWidget;
use App\Filament\Widgets\MonthlySalesComparisonWidget;
use App\Filament\Widgets\SalesByCategoryWidget;
use App\Filament\Widgets\SalesChartWidget;
use App\Filament\Widgets\SalesOverviewWidget;
use App\Filament\Widgets\TopProductsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static string $view = 'filament.pages.dashboard';
      public function getHeaderWidgets(): array
    {
        return [];
    }
    
    public function getFooterWidgets(): array
    {
        return [];
    }
    
    public function getWidgetData(): array
    {
        return [];
    }
    
    public function getColumns(): int | array
    {
        return [
            'default' => 1,
            'sm' => 2,
            'md' => 3,
            'lg' => 3,
            'xl' => 3,
            '2xl' => 3,
        ];
    }    public function getWidgets(): array
    {
        // We're rendering all widgets manually in the view
        return [];
    }
}
