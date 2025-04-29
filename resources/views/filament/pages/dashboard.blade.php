<x-filament-panels::page>
    <div class="mb-6">
        {{-- Empty header section --}}
    </div>
      {{-- Welcome notification (will be controlled by JS to show/hide) --}}
    <div id="welcome-notification" class="fixed top-4 right-4 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 w-80 transform transition-all duration-300 ease-in-out z-50 opacity-0 invisible">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="rounded-full bg-primary-50 dark:bg-primary-950/50 p-3">
                    <x-filament::icon
                        alias="panels::user-menu.profile"
                        icon="heroicon-o-user-circle"
                        class="h-6 w-6 text-primary-500 dark:text-primary-400"
                    />
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Welcome back
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ auth()->user()->name }}
                    </p>
                </div>
            </div>
            
            <button id="close-notification" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 self-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        
        <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            <p class="mb-2">Today is {{ now()->format('l, d F Y') }}</p>
            <p>Have a productive day!</p>
        </div>
    </div>{{-- Use a simpler approach with static widgets --}}
    <div class="space-y-6">
        {{-- Sales Overview Widget --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 col-span-full">
            <div class="text-xl font-bold mb-4">Sales Overview</div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Sales</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format(App\Models\Order::where('status', 'completed')->sum('total_amount'), 0, ',', '.') }}</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 2H8.828a2 2 0 00-1.414.586L6.293 3.707A1 1 0 015.586 4H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                        Lifetime sales value
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Monthly Sales</div>
                    @php
                        $monthlySales = App\Models\Order::where('status', 'completed')
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->sum('total_amount');
                            
                        $lastMonthSales = App\Models\Order::where('status', 'completed')
                            ->whereMonth('created_at', now()->subMonth()->month)
                            ->whereYear('created_at', now()->subMonth()->year)
                            ->sum('total_amount');
                            
                        $salesIncrease = $lastMonthSales > 0 ? 
                            number_format((($monthlySales - $lastMonthSales) / $lastMonthSales) * 100, 1) : 0;
                            
                        $salesIncreaseDescription = $lastMonthSales > 0 ?
                            "{$salesIncrease}% increase from last month" : "No sales last month";
                    @endphp
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($monthlySales, 0, ',', '.') }}</div>
                    <div class="mt-1 text-xs {{ $salesIncrease >= 0 ? 'text-green-500' : 'text-red-500' }} flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                        </svg>
                        {{ $salesIncreaseDescription }}
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Average Order Value</div>
                    @php
                        $totalOrders = App\Models\Order::count();
                        $totalSales = App\Models\Order::where('status', 'completed')->sum('total_amount');
                        $averageOrderValue = $totalOrders > 0 ? 
                            number_format($totalSales / $totalOrders, 0, ',', '.') : 0;
                    @endphp
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ $averageOrderValue }}</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                        </svg>
                        Based on {{ $totalOrders }} orders
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Latest Orders Widget - Implemented directly in the template --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
            <div class="text-xl font-bold mb-4">Latest Orders</div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Order Number</th>
                            <th scope="col" class="px-6 py-3">Customer</th>
                            <th scope="col" class="px-6 py-3">Amount</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Date</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(App\Models\Order::with('user')->latest()->limit(5)->get() as $order)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $order->order_number }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $order->user->name ?? 'Unknown' }}
                                </td>
                                <td class="px-6 py-4">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($order->status == 'processing' ? 'bg-blue-100 text-blue-800' : 
                                           ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('filament.admin.resources.orders.edit', $order) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No orders found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>    {{-- Analytics charts in a grid --}}    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        {{-- Top Products Chart --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 col-span-1 md:col-span-1">
            <div class="text-xl font-bold mb-4">Top Products</div>
            @php
                $topProducts = App\Models\OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
                    ->with('product:id,name')
                    ->whereHas('order', function ($query) {
                        $query->where('status', 'completed');
                    })
                    ->groupBy('product_id')
                    ->orderByDesc('total_quantity')
                    ->limit(5)
                    ->get();
                
                $hasProductData = $topProducts->isNotEmpty();
            @endphp
            
            @if($hasProductData)
                <div class="h-64">
                    <canvas id="topProductsChart"></canvas>
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-64 text-center text-sm text-gray-500 dark:text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p>Product sales data visualization<br>available after more orders are processed.</p>
                </div>
            @endif
        </div>
        
        {{-- Sales by Category Chart --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 col-span-1 md:col-span-1">
            <div class="text-xl font-bold mb-4">Sales by Category</div>
            @php
                $categorySales = App\Models\OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->join('categories', 'products.category_id', '=', 'categories.id')
                    ->where('orders.status', 'completed')
                    ->select('categories.name as category_name', DB::raw('SUM(order_items.subtotal) as total_sales'))
                    ->groupBy('categories.name')
                    ->orderByDesc('total_sales')
                    ->get();
                
                $hasCategoryData = $categorySales->isNotEmpty();
            @endphp
            
            @if($hasCategoryData)
                <div class="h-64">
                    <canvas id="categoryChart"></canvas>
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-64 text-center text-sm text-gray-500 dark:text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    <p>Category distribution chart<br>available after more sales data is collected.</p>
                </div>
            @endif
        </div>
        
        {{-- Monthly Sales Comparison Chart --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 col-span-1 md:col-span-1">
            <div class="text-xl font-bold mb-4">Monthly Comparison</div>
            @php
                $currentYear = now()->year;
                $previousYear = $currentYear - 1;
                
                $currentYearData = App\Models\Order::where('status', 'completed')
                    ->whereYear('created_at', $currentYear)
                    ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
                    ->groupBy('month')
                    ->pluck('total', 'month')
                    ->toArray();
                    
                $previousYearData = App\Models\Order::where('status', 'completed')
                    ->whereYear('created_at', $previousYear)
                    ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
                    ->groupBy('month')
                    ->pluck('total', 'month')
                    ->toArray();
                
                $hasMonthlyData = !empty($currentYearData) || !empty($previousYearData);
            @endphp
            
            @if($hasMonthlyData)
                <div class="h-64">
                    <canvas id="monthlyComparisonChart"></canvas>
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-64 text-center text-sm text-gray-500 dark:text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p>Monthly sales comparison<br>will be displayed after multiple months of sales data.</p>
                </div>
            @endif
        </div>
    </div>
      {{-- Include Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      {{-- Initialize Charts and Welcome Notification --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Welcome Notification Control
            const welcomeNotification = document.getElementById('welcome-notification');
            const closeNotificationBtn = document.getElementById('close-notification');
            
            // Show notification with animation
            setTimeout(() => {
                welcomeNotification.classList.remove('invisible');
                welcomeNotification.classList.add('opacity-100');
            }, 500);
            
            // Auto-hide after 5 seconds
            const autoHideTimeout = setTimeout(() => {
                hideNotification();
            }, 5000);
            
            // Close button handler
            closeNotificationBtn.addEventListener('click', () => {
                clearTimeout(autoHideTimeout);
                hideNotification();
            });
            
            // Function to hide notification
            function hideNotification() {
                welcomeNotification.classList.remove('opacity-100');
                welcomeNotification.classList.add('opacity-0');
                
                // After animation completes, add invisible class
                setTimeout(() => {
                    welcomeNotification.classList.add('invisible');
                }, 300);
            }
            
            // Top Products Chart
            @if($hasProductData ?? false)
                const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
                new Chart(topProductsCtx, {
                    type: 'pie',
                    data: {
                        labels: [
                            @foreach($topProducts as $product)
                                '{{ $product->product->name }}',
                            @endforeach
                        ],
                        datasets: [{
                            data: [
                                @foreach($topProducts as $product)
                                    {{ $product->total_quantity }},
                                @endforeach
                            ],
                            backgroundColor: [
                                '#6366F1', // Indigo
                                '#8B5CF6', // Purple
                                '#EC4899', // Pink
                                '#3B82F6', // Blue
                                '#10B981', // Emerald
                            ],
                            borderColor: '#FFFFFF',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                align: 'start',
                                labels: {
                                    color: document.documentElement.classList.contains('dark') ? '#FFFFFF' : '#111827'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': ' + context.raw + ' units';
                                    }
                                }
                            }
                        }
                    }
                });
            @endif
            
            // Category Sales Chart
            @if($hasCategoryData ?? false)
                const categoryCtx = document.getElementById('categoryChart').getContext('2d');
                new Chart(categoryCtx, {
                    type: 'bar',
                    data: {
                        labels: [
                            @foreach($categorySales as $category)
                                '{{ $category->category_name }}',
                            @endforeach
                        ],
                        datasets: [{
                            label: 'Sales Amount',
                            data: [
                                @foreach($categorySales as $category)
                                    {{ $category->total_sales }},
                                @endforeach
                            ],
                            backgroundColor: '#6366F1',
                            borderColor: '#4F46E5',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                    },
                                    color: document.documentElement.classList.contains('dark') ? '#E5E7EB' : '#4B5563'
                                },
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                }
                            },
                            x: {
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#E5E7EB' : '#4B5563'
                                },
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                    }
                                }
                            }
                        }
                    }
                });
            @endif
            
            // Monthly Sales Comparison Chart
            @if($hasMonthlyData ?? false)
                const monthlyCtx = document.getElementById('monthlyComparisonChart').getContext('2d');
                  // Prepare data arrays with zero for missing months
                let currentYearValues = [];
                let previousYearValues = [];
                
                for (let i = 1; i <= 12; i++) {
                    currentYearValues.push({{ isset($currentYearData[$i]) ? $currentYearData[$i] : 0 }});
                    previousYearValues.push({{ isset($previousYearData[$i]) ? $previousYearData[$i] : 0 }});
                }
                
                new Chart(monthlyCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [
                            {
                                label: '{{ $currentYear }}',
                                data: currentYearValues,
                                backgroundColor: '#6366F1', // Indigo for current year
                                borderColor: '#4F46E5',
                                borderWidth: 1
                            },
                            {
                                label: '{{ $previousYear }}',
                                data: previousYearValues,
                                backgroundColor: '#C7D2FE', // Light indigo for previous year
                                borderColor: '#A5B4FC',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                    },
                                    color: document.documentElement.classList.contains('dark') ? '#E5E7EB' : '#4B5563'
                                },
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                }
                            },
                            x: {
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#E5E7EB' : '#4B5563'
                                },
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: document.documentElement.classList.contains('dark') ? '#FFFFFF' : '#111827'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                    }
                                }
                            }
                        }
                    }
                });
            @endif
        });
    </script>
</x-filament-panels::page>
