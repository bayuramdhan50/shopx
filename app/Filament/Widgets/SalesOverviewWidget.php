<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class SalesOverviewWidget extends BaseWidget
{
    // Set a unique ID for this widget for proper registration
    protected static string $widgetId = 'sales-overview-widget';
    
    protected static ?int $sort = 1;
    
    // Ensure this widget is only loaded once
    protected static bool $isLazy = false;
    
    // Set column span to make it full width
    protected int | string | array $columnSpan = 'full';
    
    protected function getStats(): array
    {
        // Calculate total sales
        $totalSales = Order::where('status', 'completed')
            ->sum('total_amount');
            
        // Count total orders
        $totalOrders = Order::count();
        
        // Count total customers
        $totalCustomers = User::where('is_admin', false)->count();
        
        // Calculate average order value
        $averageOrderValue = $totalOrders > 0 ? 
            number_format($totalSales / $totalOrders, 2) : 0;
        
        // Monthly sales
        $monthlySales = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
            
        // Increase from last month
        $lastMonthSales = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_amount');
            
        $salesIncrease = $lastMonthSales > 0 ? 
            number_format((($monthlySales - $lastMonthSales) / $lastMonthSales) * 100, 1) : 0;
            
        $salesIncreaseDescription = $lastMonthSales > 0 ?
            "{$salesIncrease}% increase from last month" : "No sales last month";
        
        return [
            Stat::make('Total Sales', 'Rp ' . number_format($totalSales, 0, ',', '.'))
                ->description('Lifetime sales value')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
                
            Stat::make('Monthly Sales', 'Rp ' . number_format($monthlySales, 0, ',', '.'))
                ->description($salesIncreaseDescription)
                ->descriptionIcon($salesIncrease >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($salesIncrease >= 0 ? 'success' : 'danger'),
                
            Stat::make('Average Order Value', 'Rp ' . number_format($averageOrderValue, 0, ',', '.'))
                ->description('Based on ' . $totalOrders . ' orders')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),
        ];
    }
}
