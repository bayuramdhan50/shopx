<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Premium Smartphone X1',
                'description' => 'The latest flagship smartphone with cutting-edge features and premium design.',
                'encrypted_specs' => json_encode([
                    'processor' => 'Octa-core Snapdragon 8 Gen 2',
                    'ram' => '12GB LPDDR5',
                    'storage' => '256GB UFS 3.1',
                    'display' => '6.7" AMOLED 120Hz',
                    'battery' => '5000mAh',
                    'camera' => 'Triple 50MP + 12MP + 8MP',
                    'water_resistance' => 'IP68',
                ]),
                'price' => 12999000,
                'stock' => 100,
                'image' => 'products/smartphone1.jpg',
                'featured' => true,
                'category' => 'Smartphones',
                'brand' => 'TechX',
                'sku' => 'SMT-X1-' . Str::random(6),
            ],
            [
                'name' => 'Ultra-thin Laptop Pro',
                'description' => 'Professional-grade laptop with stunning display and all-day battery life.',
                'encrypted_specs' => json_encode([
                    'processor' => 'Intel Core i7-12700H',
                    'ram' => '16GB DDR5',
                    'storage' => '512GB NVMe SSD',
                    'display' => '14" 2.8K OLED',
                    'battery' => '70Wh (Up to a1 hours)',
                    'graphics' => 'NVIDIA RTX 3060',
                    'weight' => '1.3kg',
                ]),
                'price' => 15999000,
                'stock' => 50,
                'image' => 'products/laptop1.jpg',
                'featured' => true,
                'category' => 'Laptops',
                'brand' => 'UltraBook',
                'sku' => 'LTP-PRO-' . Str::random(6),
            ],
            [
                'name' => 'Wireless Noise-Cancelling Headphones',
                'description' => 'Premium wireless headphones with active noise cancellation and immersive sound.',
                'encrypted_specs' => json_encode([
                    'driver' => '40mm Dynamic',
                    'battery' => 'Up to 30 hours',
                    'connectivity' => 'Bluetooth 5.2',
                    'noise_cancellation' => 'Active ANC',
                    'microphone' => 'Dual beamforming',
                    'weight' => '250g',
                ]),
                'price' => 2999000,
                'stock' => 200,
                'image' => 'products/headphones1.jpg',
                'featured' => true,
                'category' => 'Audio',
                'brand' => 'SoundPro',
                'sku' => 'SPH-NC-' . Str::random(6),
            ],
            [
                'name' => '4K Smart TV 55"',
                'description' => 'Ultra HD Smart TV with vibrant colors and immersive sound quality.',
                'encrypted_specs' => json_encode([
                    'resolution' => '3840 x 2160 (4K UHD)',
                    'panel' => 'QLED',
                    'processor' => 'AI Quad Core',
                    'hdr' => 'HDR10+',
                    'sound' => '40W 2.1ch',
                    'smart_features' => 'Voice Assistant, Smart Home Integration',
                ]),
                'price' => 8999000,
                'stock' => 30,
                'image' => 'products/tv1.jpg',
                'featured' => true,
                'category' => 'TVs',
                'brand' => 'VisionTech',
                'sku' => 'TV-4K-' . Str::random(6),
            ],
            [
                'name' => 'Wireless Earbuds Pro',
                'description' => 'True wireless earbuds with immersive sound and long battery life.',
                'encrypted_specs' => json_encode([
                    'driver' => '11mm Dynamic',
                    'battery' => '8 hours (28 with case)',
                    'connectivity' => 'Bluetooth 5.2',
                    'noise_cancellation' => 'Hybrid ANC',
                    'water_resistance' => 'IPX4',
                    'weight' => '5.6g per earbud',
                ]),
                'price' => 1899000,
                'stock' => 150,
                'image' => 'products/earbuds1.jpg',
                'featured' => false,
                'category' => 'Audio',
                'brand' => 'SoundPro',
                'sku' => 'SPE-PRO-' . Str::random(6),
            ],
            [
                'name' => 'Gaming Laptop Extreme',
                'description' => 'High-performance gaming laptop with advanced cooling and stunning graphics.',
                'encrypted_specs' => json_encode([
                    'processor' => 'AMD Ryzen 9 7900X',
                    'ram' => '32GB DDR5',
                    'storage' => '1TB NVMe SSD',
                    'display' => '15.6" QHD 165Hz',
                    'graphics' => 'NVIDIA RTX 4080',
                    'cooling' => 'Liquid metal + dual fans',
                    'keyboard' => 'Per-key RGB mechanical',
                ]),
                'price' => 25999000,
                'stock' => 25,
                'image' => 'products/gaminglaptop1.jpg',
                'featured' => true,
                'category' => 'Gaming',
                'brand' => 'GameForce',
                'sku' => 'GFL-EXT-' . Str::random(6),
            ],
            [
                'name' => 'Smartwatch Series 5',
                'description' => 'Advanced smartwatch with health monitoring and sleek design.',
                'encrypted_specs' => json_encode([
                    'display' => '1.4" AMOLED',
                    'battery' => 'Up to 14 days',
                    'sensors' => 'Heart rate, SpO2, accelerometer, gyroscope',
                    'water_resistance' => '5ATM',
                    'connectivity' => 'Bluetooth 5.0, GPS',
                    'compatibility' => 'iOS and Android',
                ]),
                'price' => 2499000,
                'stock' => 75,
                'image' => 'products/smartwatch1.jpg',
                'featured' => false,
                'category' => 'Wearables',
                'brand' => 'FitTech',
                'sku' => 'FTS-5-' . Str::random(6),
            ],
            [
                'name' => 'Portable SSD 1TB',
                'description' => 'Ultra-fast portable SSD with durable design for professionals on the go.',
                'encrypted_specs' => json_encode([
                    'capacity' => '1TB',
                    'interface' => 'USB-C 3.2 Gen 2',
                    'read_speed' => 'Up to 1050 MB/s',
                    'write_speed' => 'Up to 1000 MB/s',
                    'encryption' => 'AES 256-bit hardware encryption',
                    'compatibility' => 'Windows, macOS, Android',
                ]),
                'price' => 1699000,
                'stock' => 100,
                'image' => 'products/ssd1.jpg',
                'featured' => false,
                'category' => 'Storage',
                'brand' => 'DataPro',
                'sku' => 'SSD-1TB-' . Str::random(6),
            ],
            [
                'name' => 'Professional Camera Kit',
                'description' => 'Full-frame mirrorless camera with premium lens kit for professional photographers.',
                'encrypted_specs' => json_encode([
                    'sensor' => '45MP Full-frame CMOS',
                    'processor' => 'DIGIC X',
                    'iso_range' => '100-51200 (expandable to 102400)',
                    'video' => '8K 30p, 4K 120p',
                    'stabilization' => '5-axis IBIS',
                    'lens' => '24-70mm f/2.8',
                    'storage' => 'Dual UHS-II SD cards',
                ]),
                'price' => 35999000,
                'stock' => 15,
                'image' => 'products/camera1.jpg',
                'featured' => true,
                'category' => 'Cameras',
                'brand' => 'OptiPro',
                'sku' => 'CAM-PRO-' . Str::random(6),
            ],
            [
                'name' => 'Wireless Gaming Mouse',
                'description' => 'Ultra-responsive wireless gaming mouse with customizable RGB lighting.',
                'encrypted_specs' => json_encode([
                    'sensor' => '25,000 DPI optical',
                    'switches' => 'Mechanical rated for 70M clicks',
                    'battery' => 'Up to a0 hours',
                    'weight' => '85g',
                    'rgb' => '16.8M colors, 7 zones',
                    'connectivity' => '2.4GHz + Bluetooth',
                ]),
                'price' => 999000,
                'stock' => 120,
                'image' => 'products/mouse1.jpg',
                'featured' => false,
                'category' => 'Gaming',
                'brand' => 'GameForce',
                'sku' => 'GFM-PRO-' . Str::random(6),
            ],
        ];
        
        foreach ($products as $product) {
            // Encrypt the specs before saving
            if (isset($product['encrypted_specs'])) {
                $product['encrypted_specs'] = $product['encrypted_specs'];
            }
            
            Product::create($product);
        }
    }
}
