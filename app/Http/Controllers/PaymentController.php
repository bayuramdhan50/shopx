<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PaymentController extends Controller
{
    protected MidtransService $midtransService;
    
    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }
    
    /**
     * Process payment for an order
     */
    public function process(Order $order): View|RedirectResponse
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')
                ->with('error', 'You do not have permission to process payment for this order.');
        }
        
        // Check if the order is already paid
        if (in_array($order->status, ['completed', 'processing'])) {
            return redirect()->route('orders.show', $order)
                ->with('info', 'This order has already been paid.');
        }
        
        try {
            // Get payment details from Midtrans
            $paymentDetails = $this->midtransService->createTransaction($order, Auth::user());
            
            if (isset($paymentDetails['error'])) {
                return redirect()->route('orders.show', $order)
                    ->with('error', 'Failed to process payment: ' . $paymentDetails['message']);
            }
            
            return view('payment.process', [
                'order' => $order,
                'paymentDetails' => $paymentDetails,
            ]);
        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage());
            
            return redirect()->route('orders.show', $order)
                ->with('error', 'An error occurred while processing your payment. Please try again.');
        }
    }
    
    /**
     * Handle payment success
     */
    public function success(Request $request, Order $order): RedirectResponse
    {
        // Update order status
        $order->update([
            'status' => 'processing',
            'midtrans_transaction_id' => $request->transaction_id,
            'midtrans_payment_type' => $request->payment_type,
            'midtrans_status' => 'success',
        ]);
        
        return redirect()->route('orders.show', $order)
            ->with('success', 'Your payment was successful. Thank you for your order!');
    }
    
    /**
     * Handle payment failure
     */
    public function failed(Request $request, Order $order): RedirectResponse
    {
        $order->update([
            'status' => 'failed',
            'midtrans_status' => 'failed',
        ]);
        
        return redirect()->route('orders.show', $order)
            ->with('error', 'Your payment failed. Please try again or contact customer support.');
    }
    
    /**
     * Handle Midtrans notification callback
     */
    public function notification(Request $request): JsonResponse
    {
        try {
            $notification = $request->all();
            
            // Process the notification using MidtransService
            $result = $this->midtransService->handleNotification($notification);
            
            if (!$result['success']) {
                Log::error('Midtrans notification error: ' . $result['message']);
                return response()->json(['status' => 'error'], 500);
            }
            
            // Find the order by order number
            $order = Order::where('order_number', $result['order_id'])->first();
            
            if (!$order) {
                Log::error('Order not found for notification: ' . $result['order_id']);
                return response()->json(['status' => 'error'], 404);
            }
            
            // Update order with payment details
            $order->update([
                'status' => $result['status_code'],
                'midtrans_transaction_id' => $notification['transaction_id'] ?? null,
                'midtrans_payment_type' => $notification['payment_type'] ?? null,
                'midtrans_status' => $notification['transaction_status'] ?? null,
                'midtrans_response' => $result['encrypted_response'], // Already encrypted
            ]);
            
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Midtrans notification processing error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
}
