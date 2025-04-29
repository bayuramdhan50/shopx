<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default categories
        $defaultCategories = [
            'Electronics' => 'electronics',
            'Fashion' => 'fashion',
            'Home & Garden' => 'home-garden',
            'Sports' => 'sports',
            'Books' => 'books',
            'Health & Beauty' => 'health-beauty',
            'Toys & Games' => 'toys-games',
            'Automotive' => 'automotive',
        ];
        
        // Create categories
        foreach ($defaultCategories as $name => $slug) {
            Category::create([
                'name' => $name,
                'slug' => $slug,
                'is_active' => true,
                'description' => 'Products in the ' . $name . ' category',
            ]);
        }
        
        // Check if old_category column exists and migrate data if it does
        try {
            if (\Schema::hasColumn('products', 'old_category')) {
                $productsWithOldCategory = Product::whereNotNull('old_category')->get();
                
                foreach ($productsWithOldCategory as $product) {
                    $categoryName = $product->old_category;
                    
                    // Find or create a category
                    $category = Category::firstOrCreate(
                        ['name' => $categoryName],
                        [
                            'slug' => Str::slug($categoryName),
                            'is_active' => true
                        ]
                    );
                    
                    // Update product with category_id
                    $product->update(['category_id' => $category->id]);
                }
            }
        } catch (\Exception $e) {
            // Handle the exception or simply continue
            \Log::info('Error migrating categories: ' . $e->getMessage());
        }
    }
}
