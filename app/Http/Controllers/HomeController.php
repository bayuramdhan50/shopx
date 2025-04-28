<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the landing page
     */
    public function index(): View
    {
        // Get featured products for the showcase
        $featuredProducts = Product::where('featured', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        // Get latest products
        $latestProducts = Product::orderBy('created_at', 'desc')
            ->take(8)
            ->get();
            
        return view('home', [
            'featuredProducts' => $featuredProducts,
            'latestProducts' => $latestProducts,
        ]);
    }
    
    /**
     * Show the about page
     */
    public function about(): View
    {
        return view('about');
    }
    
    /**
     * Show the contact page
     */
    public function contact(): View
    {
        return view('contact');
    }
}
