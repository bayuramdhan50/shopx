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
        if (!empty($imagePath)) {
            // Direct URL untuk gambar di storage publik
            return asset('storage/' . $imagePath);
        }
        
        // Return fallback image hanya jika benar-benar tidak ada gambar
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
        if (!empty($imagePath)) {
            // Direct URL untuk gambar di storage publik
            return asset('storage/' . $imagePath);
        }
        
        // Return fallback image hanya jika benar-benar tidak ada gambar
        return asset('images/category-placeholder.jpg');
    }
    
    /**
     * Get user avatar URL with fallback
     *
     * @param string|null $imagePath
     * @return string
     */
    public static function getUserAvatarUrl(?string $imagePath): string
    {
        if (!empty($imagePath)) {
            // Direct URL untuk gambar di storage publik
            return asset('storage/' . $imagePath);
        }
        
        // Return fallback image hanya jika benar-benar tidak ada gambar
        return asset('images/user-placeholder.jpg');
    }
}
