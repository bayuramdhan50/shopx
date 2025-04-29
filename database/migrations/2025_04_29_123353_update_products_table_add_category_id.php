<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add category_id column
            $table->unsignedBigInteger('category_id')->nullable()->after('featured');
            
            // Add foreign key constraint
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null');
                
            // Add index for better performance
            $table->index('category_id');
            
            // Copy existing category string values to a temporary column for migration
            if (Schema::hasColumn('products', 'category')) {
                $table->string('old_category')->nullable()->after('category_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove foreign key constraint
            $table->dropForeign(['category_id']);
            
            // Remove index
            $table->dropIndex(['category_id']);
            
            // Remove column
            $table->dropColumn('category_id');
            
            // Remove temporary column if it exists
            if (Schema::hasColumn('products', 'old_category')) {
                $table->dropColumn('old_category');
            }
        });
    }
};
