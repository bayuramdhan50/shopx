<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\MidtransService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class OrderController extends Controller
{
    protected MidtransService $midtransService;
    
    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }
    
    /**
     * Display a listing of the user's orders
     */
    public function index(): View
    {
        $orders = Auth::user()->orders()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('orders.index', [
            'orders' => $orders,
        ]);
    }
    
    /**
     * Display the specified order
     */
    public function show(Order $order): View|RedirectResponse
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')
                ->with('error', 'You do not have permission to view this order.');
        }
        
        $orderItems = $order->orderItems()->with('product')->get();
        
        // Decrypt shipping and billing addresses if available
        $shippingAddress = null;
        $billingAddress = null;
        
        if ($order->shipping_address) {
            try {
                $shippingAddress = json_decode(Crypt::decrypt($order->shipping_address), true);
            } catch (\Exception $e) {
                // If decryption fails, leave as null
            }
        }
        
        if ($order->billing_address) {
            try {
                $billingAddress = json_decode(Crypt::decrypt($order->billing_address), true);
            } catch (\Exception $e) {
                // If decryption fails, leave as null
            }
        }
        
        return view('orders.show', [
            'order' => $order,
            'orderItems' => $orderItems,
            'shippingAddress' => $shippingAddress,
            'billingAddress' => $billingAddress,
        ]);
    }
    
    /**
     * Store a newly created order in storage
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'shipping_zip' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'billing_name' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_zip' => 'required|string|max:20',
            'billing_country' => 'required|string|max:255',
            'billing_phone' => 'required|string|max:20',
            'payment_method_type' => 'required|string|in:saved,new,cod',
        ]);
        
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();
        
        // Check if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Add some products before placing an order.');
        }
        
        // Calculate total amount
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        
        // Create shipping and billing address JSON
        $shippingAddress = json_encode([
            'name' => $request->shipping_name,
            'address' => $request->shipping_address,
            'city' => $request->shipping_city,
            'state' => $request->shipping_state,
            'zip' => $request->shipping_zip,
            'country' => $request->shipping_country,
            'phone' => $request->shipping_phone,
        ]);
        
        $billingAddress = json_encode([
            'name' => $request->billing_name,
            'address' => $request->billing_address,
            'city' => $request->billing_city,
            'state' => $request->billing_state,
            'zip' => $request->billing_zip,
            'country' => $request->billing_country,
            'phone' => $request->billing_phone,
        ]);
        
        // Process payment method
        $paymentMethod = 'Cash on Delivery';
        
        if ($request->payment_method_type === 'saved' && $request->has('payment_method_id')) {
            // Use a saved payment method
            $savedMethod = $user->paymentMethods()->find($request->payment_method_id);
            if ($savedMethod) {
                $paymentMethod = $savedMethod->getFormattedType();
            }
        } 
        elseif ($request->payment_method_type === 'new') {
            $paymentMethod = 'Credit Card';
        }
        
        // Create a new order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => Order::generateOrderNumber(),
            'status' => 'pending',
            'total_amount' => $totalAmount,
            'shipping_address' => $shippingAddress, // Will be encrypted by the model
            'billing_address' => $billingAddress, // Will be encrypted by the model
            'payment_method' => $paymentMethod,
            'notes' => $request->notes,
        ]);

        // Create order items
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            
            // Create a snapshot of product details (to be encrypted)
            $productDetails = json_encode([
                'name' => $product->name,
                'description' => $product->description,
                'brand' => $product->brand,
                'category' => $product->category ? $product->category->name : 'Uncategorized',
                'sku' => $product->sku,
            ]);
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $product->price,
                'subtotal' => $product->price * $cartItem->quantity,
                'product_details' => $productDetails, // Will be encrypted by the model
            ]);
            
            // Update product stock
            $product->stock -= $cartItem->quantity;
            $product->save();
        }
        
        // Clear the cart after creating the order
        $user->cartItems()->delete();
        
        // Mark order as completed directly instead of going through payment gateway
        $order->status = 'processing';
        $order->save();
        
        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully! Your order is now being processed.');
    }
}
