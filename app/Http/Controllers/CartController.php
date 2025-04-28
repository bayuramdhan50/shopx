<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the user's shopping cart
     */
    public function index(): View
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        
        // Calculate cart total
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('cart.index', [
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }
    
    /**
     * Add a product to the cart
     */
    public function add(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);
        
        $userId = Auth::id();
        $quantity = $request->quantity;
        
        // Check if product already in cart
        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();
            
        if ($cartItem) {
            // Update quantity if product already in cart
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Add new item to cart
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }
        
        return redirect()->route('cart.index')
            ->with('success', $product->name . ' has been added to your cart.');
    }
    
    /**
     * Update the quantity of a cart item
     */
    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->user_id !== Auth::id()) {
            return redirect()->route('cart.index')
                ->with('error', 'You do not have permission to update this cart item.');
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        return redirect()->route('cart.index')
            ->with('success', 'Cart has been updated.');
    }
    
    /**
     * Remove an item from the cart
     */
    public function remove(CartItem $cartItem): RedirectResponse
    {
        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->user_id !== Auth::id()) {
            return redirect()->route('cart.index')
                ->with('error', 'You do not have permission to remove this cart item.');
        }
        
        $cartItem->delete();
        
        return redirect()->route('cart.index')
            ->with('success', 'Item has been removed from your cart.');
    }
    
    /**
     * Clear the entire cart
     */
    public function clear(): RedirectResponse
    {
        Auth::user()->cartItems()->delete();
        
        return redirect()->route('cart.index')
            ->with('success', 'Your cart has been cleared.');
    }
    
    /**
     * Proceed to checkout
     */
    public function checkout(): View|RedirectResponse
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Add some products before checking out.');
        }
        
        // Calculate cart total
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('cart.checkout', [
            'cartItems' => $cartItems,
            'total' => $total,
            'user' => Auth::user(),
        ]);
    }
}
