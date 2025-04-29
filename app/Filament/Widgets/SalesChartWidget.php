<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesChartWidget extends ChartWidget
{
    // Set a unique ID for this widget for proper registration
    protected static string $widgetId = 'sales-chart-widget';
    
    protected static ?int $sort = 3;
    
    protected int|string|array $columnSpan = 'full';
      public function getType(): string
    {
        return 'line';
    }
    
    public function getHeading(): string
    {
        return 'Sales Trend';
    }
      public function getData(): array
    {
        $data = $this->getSalesData();
        
        return [
            'datasets' => [
                [
                    'label' => 'Sales by Day',
                    'data' => $data['values'],
                    'borderColor' => '#6366F1', // Indigo color
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $data['labels'],
        ];
    }
    
    protected function getSalesData(): array
    {
        // Get sales data for the last 30 days
        $startDate = Carbon::now()->subDays(30)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        
        $salesByDay = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();
            
        // Fill in missing dates with zero values
        $period = new \DatePeriod(
            $startDate,
            new \DateInterval('P1D'),
            $endDate
        );
        
        $labels = [];
        $values = [];
        
        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            $labels[] = $date->format('M d');
            $values[] = $salesByDay[$dateString] ?? 0;
        }
        
        return [
            'labels' => $labels,
            'values' => $values,
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
