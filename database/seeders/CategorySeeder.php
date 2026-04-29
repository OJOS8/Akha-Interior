<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Dining Table', 'description' => 'Solid wood dining tables for family spaces.'],
            ['name' => 'Coffee Table', 'description' => 'Compact statement tables for living rooms.'],
            ['name' => 'Storage Cabinet', 'description' => 'Functional storage pieces with a warm finish.'],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
