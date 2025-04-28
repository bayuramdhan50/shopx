<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Product::query();
        
        // Filter by category if provided
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        // Filter by brand if provided
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }
        
        // Filter by price range if provided
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Search by keyword if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }
        
        // Get all categories and brands for filters
        $categories = Product::select('category')->distinct()->pluck('category');
        $brands = Product::select('brand')->distinct()->pluck('brand');
        
        // Sort products
        $sort = $request->sort ?? 'newest';
        
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $products = $query->paginate(12);
        
        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'request' => $request->all(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        // Get related products in the same category
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
            
        // Decrypt the product specifications if they exist
        $specs = null;
        if ($product->encrypted_specs) {
            try {
                $specs = json_decode(Crypt::decrypt($product->encrypted_specs), true);
            } catch (\Exception $e) {
                // If decryption fails, leave specs as null
            }
        }
        
        return view('products.show', [
            'product' => $product,
            'specs' => $specs,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
