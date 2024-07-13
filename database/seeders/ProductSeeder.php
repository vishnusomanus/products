<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variants = [
            ['name' => 'size', 'values' => ["XL", "L", "M", "S"]],
            ['name' => 'color', 'values' => ["Red", "Blue", "Orange", "White"]]
        ];

        for ($i = 1; $i <= 6; $i++) {
            Product::create([
                'title' => "Sample Product $i",
                'description' => "This is the description for sample product $i.",
                'main_image' => "/images/dummy.png",
                'variants' => $variants,
            ]);
        }
    }
}