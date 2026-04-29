<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category' => 'Dining Table',
                'name' => 'Nara Dining Table',
                'sku' => 'AKH-DIN-001',
                'short_description' => 'Six-seat dining table in natural teak finish.',
                'description' => 'A clean-lined dining table made for everyday meals and weekend hosting.',
                'price' => 4250000,
                'discount_price' => 3950000,
                'stock' => 12,
                'weight' => 38.50,
                'material' => 'Teak Wood',
                'dimensions' => '180 x 90 x 75 cm',
                'thumbnail' => 'products/nara-dining-table.jpg',
                'is_featured' => true,
            ],
            [
                'category' => 'Coffee Table',
                'name' => 'Mori Coffee Table',
                'sku' => 'AKH-COF-001',
                'short_description' => 'Low-profile coffee table with hidden shelf.',
                'description' => 'A balanced living room centerpiece with extra storage for books and decor.',
                'price' => 1850000,
                'discount_price' => null,
                'stock' => 20,
                'weight' => 16.75,
                'material' => 'Mahogany Wood',
                'dimensions' => '110 x 60 x 42 cm',
                'thumbnail' => 'products/mori-coffee-table.jpg',
                'is_featured' => true,
            ],
            [
                'category' => 'Storage Cabinet',
                'name' => 'Kaya Storage Cabinet',
                'sku' => 'AKH-STO-001',
                'short_description' => 'Slim cabinet for dining and multipurpose storage.',
                'description' => 'Vertical cabinet with adjustable shelving and a handcrafted wood texture.',
                'price' => 3150000,
                'discount_price' => 2890000,
                'stock' => 8,
                'weight' => 42.00,
                'material' => 'Engineered Wood',
                'dimensions' => '90 x 45 x 180 cm',
                'thumbnail' => 'products/kaya-storage-cabinet.jpg',
                'is_featured' => false,
            ],
        ];

        foreach ($products as $item) {
            $category = Category::query()->where('name', $item['category'])->firstOrFail();

            Product::query()->updateOrCreate(
                ['sku' => $item['sku']],
                [
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'short_description' => $item['short_description'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'discount_price' => $item['discount_price'],
                    'stock' => $item['stock'],
                    'weight' => $item['weight'],
                    'material' => $item['material'],
                    'dimensions' => $item['dimensions'],
                    'thumbnail' => $item['thumbnail'],
                    'is_featured' => $item['is_featured'],
                    'is_active' => true,
                ]
            );
        }
    }
}
