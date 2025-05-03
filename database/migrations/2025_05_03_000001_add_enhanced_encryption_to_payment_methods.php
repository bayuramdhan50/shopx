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
        Schema::table('payment_methods', function (Blueprint $table) {
            // Tambahkan kolom baru untuk menyimpan CVV yang dienkripsi dengan PBKDF2 + AES-256
            $table->text('cvv_enhanced')->nullable()->after('encrypted_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('cvv_enhanced');
        });
    }
};
