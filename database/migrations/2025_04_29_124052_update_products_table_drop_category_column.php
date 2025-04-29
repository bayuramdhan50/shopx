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
        // Before dropping the column, we need to ensure data migration has completed
        // This would typically be done with a data migration script or seeder
        
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category')) {
                $table->dropColumn('category');
            }
            
            if (Schema::hasColumn('products', 'old_category')) {
                $table->dropColumn('old_category');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Re-add the category column if needed
            if (!Schema::hasColumn('products', 'category')) {
                $table->string('category')->nullable()->after('featured');
            }
        });
    }
};
