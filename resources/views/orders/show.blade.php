<x-layouts.main>
    <x-slot name="title">Order #{{ $order->order_number }}</x-slot>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Order Header -->
            <div class="border-b border-gray-200 pb-5 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Order #{{ $order->order_number }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500">
                        Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                    </p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($order->status == 'completed') bg-green-100 text-green-800
                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status == 'cancelled') bg-gray-100 text-gray-800
                        @elseif($order->status == 'failed') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            
            <!-- Order Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Order Items -->
                <div class="md:col-span-2">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Order Items</h2>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach ($orderItems as $item)
                                <div class="px-4 py-5 sm:p-6 flex flex-col sm:flex-row">
                                    <div class="flex-shrink-0 w-full sm:w-24 h-24 bg-gray-200 rounded-md overflow-hidden mb-4 sm:mb-0">
                                        @if ($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="sm:ml-6 flex-1">
                                        <div class="flex justify-between mb-2">
                                            <div>
                                                @php
                                                    $productDetails = null;
                                                    if ($item->product_details) {
                                                        try {
                                                            $productDetails = json_decode(\Illuminate\Support\Facades\Crypt::decrypt($item->product_details), true);
                                                        } catch (\Exception $e) {
                                                            // If decryption fails, continue
                                                        }
                                                    }
                                                @endphp
                                                <h3 class="text-lg font-medium text-gray-900">
                                                    @if ($item->product)
                                                        {{ $item->product->name }}
                                                    @elseif ($productDetails && isset($productDetails['name']))
                                                        {{ $productDetails['name'] }}
                                                    @else
                                                        Product #{{ $item->product_id }}
                                                    @endif
                                                </h3>
                                                @if ($productDetails)
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        {{ $productDetails['brand'] ?? '' }}
                                                        @if (isset($productDetails['category']))
                                                            - {{ $productDetails['category'] }}
                                                        @endif
                                                    </p>
                                                    @if (isset($productDetails['sku']))
                                                        <p class="mt-1 text-sm text-gray-500">SKU: {{ $productDetails['sku'] }}</p>
                                                    @endif
                                                @elseif ($item->product)
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        {{ $item->product->brand }}
                                                        @if ($item->product->category)
                                                            - {{ $item->product->category }}
                                                        @endif
                                                    </p>
                                                    @if ($item->product->sku)
                                                        <p class="mt-1 text-sm text-gray-500">SKU: {{ $item->product->sku }}</p>
                                                    @endif
                                                @endif
                                            </div>
                                            <p class="text-lg font-medium text-indigo-600">
                                                Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div class="flex justify-between items-end">
                                            <p class="text-sm text-gray-500">
                                                Qty: {{ $item->quantity }}
                                            </p>
                                            <p class="text-sm font-medium text-gray-900">
                                                Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Payment Details -->
                    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Payment Details</h2>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($order->midtrans_status)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($order->midtrans_status == 'settlement' || $order->midtrans_status == 'capture') bg-green-100 text-green-800
                                                @elseif($order->midtrans_status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($order->midtrans_status == 'deny' || $order->midtrans_status == 'cancel' || $order->midtrans_status == 'expire') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($order->midtrans_status) }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($order->midtrans_payment_type)
                                            {{ ucfirst(str_replace('_', ' ', $order->midtrans_payment_type)) }}
                                        @else
                                            -
                                        @endif
                                    </dd>
                                </div>
                                
                                @if($order->midtrans_transaction_id)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Transaction ID</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->midtrans_transaction_id }}</dd>
                                </div>
                                @endif
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Payment Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($order->paid_at)
                                            {{ $order->paid_at->format('F d, Y \a\t h:i A') }}
                                        @else
                                            -
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                            
                            @if($order->status == 'pending')
                                <div class="mt-6">
                                    <a href="{{ route('payment.process', $order) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Complete Payment
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="md:col-span-1">
                    <!-- Summary Box -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 shadow-sm">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                        
                        <dl class="space-y-4">
                            <div class="flex justify-between items-center">
                                <dt class="text-sm text-gray-600">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between items-center">
                                <dt class="text-sm text-gray-600">Shipping</dt>
                                <dd class="text-sm font-medium text-gray-900">Free</dd>
                            </div>
                            <div class="flex justify-between items-center">
                                <dt class="text-sm text-gray-600">Tax</dt>
                                <dd class="text-sm font-medium text-gray-900">Included</dd>
                            </div>
                            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                <dt class="text-base font-medium text-gray-900">Total</dt>
                                <dd class="text-base font-bold text-indigo-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <!-- Shipping Address -->
                    @if($shippingAddress)
                    <div class="mt-6 bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Shipping Address</h2>
                        <address class="not-italic text-sm text-gray-500 space-y-1">
                            <p class="font-medium text-gray-900">{{ $shippingAddress['name'] }}</p>
                            <p>{{ $shippingAddress['address'] }}</p>
                            <p>
                                {{ $shippingAddress['city'] }}, {{ $shippingAddress['state'] }} {{ $shippingAddress['zip'] }}
                            </p>
                            <p>{{ $shippingAddress['country'] }}</p>
                            <p class="mt-2">{{ $shippingAddress['phone'] }}</p>
                        </address>
                    </div>
                    @endif
                    
                    <!-- Billing Address -->
                    @if($billingAddress && json_encode($billingAddress) !== json_encode($shippingAddress))
                    <div class="mt-6 bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Billing Address</h2>
                        <address class="not-italic text-sm text-gray-500 space-y-1">
                            <p class="font-medium text-gray-900">{{ $billingAddress['name'] }}</p>
                            <p>{{ $billingAddress['address'] }}</p>
                            <p>
                                {{ $billingAddress['city'] }}, {{ $billingAddress['state'] }} {{ $billingAddress['zip'] }}
                            </p>
                            <p>{{ $billingAddress['country'] }}</p>
                            <p class="mt-2">{{ $billingAddress['phone'] }}</p>
                        </address>
                    </div>
                    @endif
                    
                    @if($order->notes)
                    <div class="mt-6 bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Order Notes</h2>
                        <p class="text-sm text-gray-500">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Back to Orders Button -->
            <div class="mt-8">
                <a href="{{ route('orders.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    <span aria-hidden="true">&larr;</span> Back to Orders
                </a>
            </div>
        </div>
    </div>
</x-layouts.main>
