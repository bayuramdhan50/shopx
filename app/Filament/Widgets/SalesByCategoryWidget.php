<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesByCategoryWidget extends ChartWidget
{
    // Set a unique ID for this widget for proper registration
    protected static string $widgetId = 'sales-by-category-widget';
    
    protected static ?int $sort = 5;
      public function getType(): string
    {
        return 'bar';
    }
    
    public function getHeading(): string
    {
        return 'Sales by Category';
    }
      public function getData(): array
    {
        $categorySales = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.status', 'completed')
            ->select('categories.name as category_name', DB::raw('SUM(order_items.subtotal) as total_sales'))
            ->groupBy('categories.name')
            ->orderByDesc('total_sales')
            ->get();
            
        return [
            'datasets' => [
                [
                    'label' => 'Sales Amount',
                    'data' => $categorySales->pluck('total_sales')->toArray(),
                    'backgroundColor' => '#6366F1', // Indigo color
                    'borderColor' => '#4F46E5',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $categorySales->pluck('category_name')->toArray(),
        ];
    }
    
    public function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => "function(value) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(value); }",
                    ],
                ],
            ],
            'plugins' => [
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(context) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y); }",
                    ],
                ],
            ],
        ];
    }
}
