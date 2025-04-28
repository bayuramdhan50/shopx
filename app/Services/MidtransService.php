<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Create a payment transaction in Midtrans
     *
     * @param Order $order The order
     * @param User $user The user placing the order
     * @return array Payment transaction details from Midtrans
     */
    public function createTransaction(Order $order, User $user)
    {
        $items = [];
        
        foreach ($order->orderItems as $item) {
            $items[] = [
                'id' => $item->product_id,
                'price' => $item->unit_price,
                'quantity' => $item->quantity,
                'name' => $item->product->name,
            ];
        }
        
        $transaction_details = [
            'order_id' => $order->order_number,
            'gross_amount' => $order->total_amount,
        ];
        
        // Customer details
        $customer_details = [
            'first_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
        ];
        
        // Shipping address
        if ($order->shipping_address) {
            try {
                $decrypted_address = Crypt::decrypt($order->shipping_address);
                $customer_details['shipping_address'] = json_decode($decrypted_address, true);
            } catch (\Exception $e) {
                // If decryption fails or address is not in expected format, skip shipping address
            }
        }
        
        $transaction_data = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $items,
        ];
        
        try {
            $snap_token = Snap::getSnapToken($transaction_data);
            $redirect_url = Snap::getSnapUrl($transaction_data);
            
            return [
                'snap_token' => $snap_token,
                'redirect_url' => $redirect_url,
                'transaction_data' => $transaction_data,
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get transaction status from Midtrans
     *
     * @param string $order_id The order_id to check status for
     * @return array Transaction status from Midtrans
     */
    public function getTransactionStatus($order_id)
    {
        try {
            $status = Transaction::status($order_id);
            return [
                'success' => true,
                'data' => $status,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
    
    /**
     * Handle notification from Midtrans
     *
     * @param array $notification_data The notification data from Midtrans
     * @return array Processed notification result
     */
    public function handleNotification($notification_data)
    {
        try {
            $transaction = $notification_data;
            $order_id = $transaction['order_id'];
            $transaction_status = $transaction['transaction_status'];
            $fraud_status = $transaction['fraud_status'] ?? null;
            
            $status_code = null;
            
            if ($transaction_status == 'capture') {
                if ($fraud_status == 'challenge') {
                    $status_code = 'pending';
                } else if ($fraud_status == 'accept') {
                    $status_code = 'completed';
                }
            } else if ($transaction_status == 'settlement') {
                $status_code = 'completed';
            } else if ($transaction_status == 'pending') {
                $status_code = 'pending';
            } else if ($transaction_status == 'deny') {
                $status_code = 'failed';
            } else if ($transaction_status == 'expire') {
                $status_code = 'cancelled';
            } else if ($transaction_status == 'cancel') {
                $status_code = 'cancelled';
            }
            
            // Encrypt the entire response
            $encrypted_response = Crypt::encrypt(json_encode($transaction));
            
            return [
                'success' => true,
                'order_id' => $order_id,
                'status_code' => $status_code,
                'transaction' => $transaction,
                'encrypted_response' => $encrypted_response,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
