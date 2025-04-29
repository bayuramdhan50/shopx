<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use App\Models\Product;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TopProductsWidget extends ChartWidget
{
    // Set a unique ID for this widget for proper registration
    protected static string $widgetId = 'top-products-widget';
    
    protected static ?int $sort = 4;
      public function getType(): string
    {
        return 'pie';
    }
    
    public function getHeading(): string
    {
        return 'Top Selling Products';
    }
      public function getData(): array
    {
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->with('product:id,name')
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed');
            })
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();
            
        $colors = [
            '#6366F1', // Indigo
            '#8B5CF6', // Purple
            '#EC4899', // Pink
            '#3B82F6', // Blue
            '#10B981', // Emerald
        ];
        
        return [
            'datasets' => [
                [
                    'label' => 'Products',
                    'data' => $topProducts->pluck('total_quantity')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $topProducts->count()),
                    'borderColor' => '#FFFFFF',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $topProducts->pluck('product.name')->toArray(),
        ];
    }
    
    public function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                    'align' => 'start',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(context) { return context.label + ': ' + context.parsed + ' units'; }",
                    ],
                ],
            ],
        ];
    }
}
