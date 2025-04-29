<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;

class UpdateProductCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-product-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update products to have valid category IDs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating product categories...');
        
        // Get default category
        $defaultCategory = Category::firstOrCreate(
            ['name' => 'Uncategorized'],
            [
                'slug' => 'uncategorized',
                'is_active' => true,
                'description' => 'Default category for products without a specific category',
            ]
        );
        
        // Find products without a category
        $productsWithoutCategory = Product::whereNull('category_id')->get();
        
        if ($productsWithoutCategory->count() > 0) {
            $this->info("Found {$productsWithoutCategory->count()} products without a category.");
            
            // Update all products without a category to use the default category
            foreach ($productsWithoutCategory as $product) {
                $product->update(['category_id' => $defaultCategory->id]);
                $this->line("Updated product: {$product->name}");
            }
            
            $this->info('All products now have a category assigned.');
        } else {
            $this->info('All products already have categories assigned.');
        }
        
        return Command::SUCCESS;
    }
}
