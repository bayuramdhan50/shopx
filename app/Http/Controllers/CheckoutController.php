<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        // Get cart items for the user
        $cartItems = $user->cartItems()->with('product')->get();

        // Check if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add items to your cart before proceeding to checkout.');
        }

        // Calculate subtotal and total
        $subtotal = 0;
        foreach ($cartItems as $cartItem) {
            $subtotal += $cartItem->quantity * $cartItem->product->price;
        }

        // Get user's payment methods
        $paymentMethods = $user->paymentMethods()->get();

        return view('cart.checkout', compact('user', 'cartItems', 'subtotal', 'paymentMethods'));
    }
}
