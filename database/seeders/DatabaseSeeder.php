<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@shopx.com',
            'password' => bcrypt('password123'),
        ]);
        
        // Create a regular customer
        User::factory()->create([
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('password123'),
            'phone' => '+6281234567890',
            'address' => 'Jl. Customer No. 123, Jakarta',
            'city' => 'Jakarta',
            'state' => 'DKI Jakarta',
            'postal_code' => '12345',
            'country' => 'Indonesia',
        ]);
        
        // Create sample products
        $this->call(ProductSeeder::class);
    }
}
