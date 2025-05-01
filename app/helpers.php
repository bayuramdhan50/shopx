<?php

if (!function_exists('product_image')) {
    /**
     * Get product image URL with fallback
     *
     * @param string|null $imagePath
     * @return string
     */
    function product_image(?string $imagePath): string
    {
        return \App\Services\ImageService::getProductImageUrl($imagePath);
    }
}

if (!function_exists('category_image')) {
    /**
     * Get category image URL with fallback
     *
     * @param string|null $imagePath
     * @return string
     */
    function category_image(?string $imagePath): string
    {
        return \App\Services\ImageService::getCategoryImageUrl($imagePath);
    }
}
