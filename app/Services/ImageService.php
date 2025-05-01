<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Get product image URL with fallback
     *
     * @param string|null $imagePath
     * @return string
     */
    public static function getProductImageUrl(?string $imagePath): string
    {
        if (!empty($imagePath) && Storage::disk('public')->exists($imagePath)) {
            return asset('storage/' . $imagePath);
        }
        
        // Return fallback image
        return asset('images/product-placeholder.jpg');
    }
    
    /**
     * Get category image URL with fallback
     *
     * @param string|null $imagePath
     * @return string
     */
    public static function getCategoryImageUrl(?string $imagePath): string
    {
        if (!empty($imagePath) && Storage::disk('public')->exists($imagePath)) {
            return asset('storage/' . $imagePath);
        }
        
        // Return fallback image
        return asset('images/category-placeholder.jpg');
    }
}
