<x-layouts.main>
    <x-slot name="title">My Orders</x-slot>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h1>
            
            @if ($orders->isEmpty())
                <div class="bg-gray-50 rounded-lg p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h2 class="text-xl font-medium text-gray-900 mb-2">No orders yet</h2>
                    <p class="text-gray-500 mb-6">You haven't placed any orders yet.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Browse Products
                    </a>
                </div>
            @else
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order Number
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Payment
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Details</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $order->order_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($order->status == 'completed') bg-green-100 text-green-800
                                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status == 'cancelled') bg-gray-100 text-gray-800
                                            @elseif($order->status == 'failed') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($order->midtrans_payment_type)
                                            {{ ucfirst(str_replace('_', ' ', $order->midtrans_payment_type)) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Mobile-friendly version -->
                <div class="sm:hidden mt-6 space-y-4">
                    @foreach ($orders as $order)
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        #{{ $order->order_number }}
                                    </h3>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($order->status == 'completed') bg-green-100 text-green-800
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'cancelled') bg-gray-100 text-gray-800
                                        @elseif($order->status == 'failed') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="mt-3 text-sm text-gray-500">
                                    <p>{{ $order->created_at->format('M d, Y') }}</p>
                                    <p class="mt-1 font-medium text-gray-900">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </p>
                                    @if($order->midtrans_payment_type)
                                        <p class="mt-1">
                                            Payment: {{ ucfirst(str_replace('_', ' ', $order->midtrans_payment_type)) }}
                                        </p>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">
                                        View Details <span aria-hidden="true">&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination Links -->
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.main>
