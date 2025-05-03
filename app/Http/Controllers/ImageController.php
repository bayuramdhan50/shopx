<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    /**
     * Display an image from storage.
     *
     * @param  string  $path
     * @return \Illuminate\Http\Response
     */
    public function show($path)
    {
        // Check if file exists in storage
        if (Storage::disk('public')->exists($path)) {
            $file = Storage::disk('public')->get($path);
            $type = Storage::disk('public')->mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }

        // Fallback to public directory
        $publicPath = public_path($path);
        if (File::exists($publicPath)) {
            $file = File::get($publicPath);
            $type = File::mimeType($publicPath);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }

        // If we get here, the image doesn't exist - return a default placeholder
        // Determine which placeholder to use based on the path
        if (str_contains($path, 'products')) {
            $placeholderPath = public_path('images/product-placeholder.jpg');
        } elseif (str_contains($path, 'categories')) {
            $placeholderPath = public_path('images/category-placeholder.jpg');
        } elseif (str_contains($path, 'users')) {
            $placeholderPath = public_path('images/user-placeholder.jpg');
        } else {
            $placeholderPath = public_path('images/placeholder.jpg');
        }

        // Return placeholder if it exists
        if (File::exists($placeholderPath)) {
            $file = File::get($placeholderPath);
            $type = File::mimeType($placeholderPath);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }

        // Last resort - return 404
        abort(404);
    }
}