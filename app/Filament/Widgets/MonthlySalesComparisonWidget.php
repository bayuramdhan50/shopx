<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MonthlySalesComparisonWidget extends ChartWidget
{
    // Set a unique ID for this widget for proper registration
    protected static string $widgetId = 'monthly-sales-comparison-widget';
    
    protected static ?int $sort = 6;
      public function getType(): string
    {
        return 'bar';
    }
    
    public function getHeading(): string
    {
        return 'Monthly Sales Comparison';
    }
      public function getData(): array
    {
        // Get current year and previous year data
        $currentYear = now()->year;
        $previousYear = $currentYear - 1;
        
        $currentYearData = $this->getMonthlySales($currentYear);
        $previousYearData = $this->getMonthlySales($previousYear);
        
        $months = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
        
        return [
            'datasets' => [
                [
                    'label' => $currentYear,
                    'data' => array_values($currentYearData),
                    'backgroundColor' => '#6366F1', // Indigo for current year
                    'borderColor' => '#4F46E5',
                    'borderWidth' => 1,
                ],
                [
                    'label' => $previousYear,
                    'data' => array_values($previousYearData),
                    'backgroundColor' => '#C7D2FE', // Light indigo for previous year
                    'borderColor' => '#A5B4FC',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $months,
        ];
    }
    
    protected function getMonthlySales(int $year): array
    {
        $salesByMonth = Order::where('status', 'completed')
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();
            
        // Fill in months with no sales
        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $result[$i] = $salesByMonth[$i] ?? 0;
        }
        
        return $result;
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
                        'label' => "function(context) { return context.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y); }",
                    ],
                ],
            ],
        ];
    }
}
