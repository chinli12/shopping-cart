<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop',
                'description' => 'High-performance laptop for work and gaming',
                'price' => 999.99,
                'stock' => 5,
            ],
            [
                'name' => 'Mouse',
                'description' => 'Wireless ergonomic mouse',
                'price' => 29.99,
                'stock' => 50,
            ],
            [
                'name' => 'Keyboard',
                'description' => 'Mechanical gaming keyboard',
                'price' => 79.99,
                'stock' => 30,
            ],
            [
                'name' => 'Monitor',
                'description' => '27-inch 4K monitor',
                'price' => 299.99,
                'stock' => 10,
            ],
            [
                'name' => 'USB Cable',
                'description' => 'High-speed USB-C cable',
                'price' => 9.99,
                'stock' => 100,
            ],
            [
                'name' => 'Headphones',
                'description' => 'Noise-cancelling headphones',
                'price' => 149.99,
                'stock' => 15,
            ],
            [
                'name' => 'Webcam',
                'description' => '1080p HD webcam',
                'price' => 49.99,
                'stock' => 25,
            ],
            [
                'name' => 'External SSD',
                'description' => '1TB portable SSD',
                'price' => 99.99,
                'stock' => 20,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
