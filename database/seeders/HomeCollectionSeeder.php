<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class HomeCollectionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset home flags
        Category::query()->update([
            'show_on_home' => false,
            'home_sort_order' => 0,
        ]);

        $homeCollections = [
            ['name' => 'Meal Trays', 'slug' => 'meal-trays', 'order' => 1],
            ['name' => 'Food Container', 'slug' => 'food-containers', 'order' => 2, 'label' => 'Food Container'],
            ['name' => 'Bagasse Products', 'slug' => 'bagasse-products', 'order' => 3],
            ['name' => 'Aluminium Containers', 'slug' => 'aluminium-containers', 'order' => 4],
            ['name' => 'Paper Products', 'slug' => 'paper-products', 'order' => 5],
            ['name' => 'Eco Friendly Products', 'slug' => 'eco-friendly-products', 'order' => 6],
            ['name' => 'Shakes & Mocktail', 'slug' => 'shakes-mocktail', 'order' => 7],
            ['name' => 'Print & Customization', 'slug' => 'print-customization', 'order' => 8],
        ];

        foreach ($homeCollections as $item) {
            $category = Category::where('slug', $item['slug'])->first();

            if (! $category) {
                $category = Category::create([
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                    'parent_id' => null,
                    'menu_column' => null,
                    'menu_row' => null,
                    'sort_order' => 0,
                    'is_active' => true,
                    'image' => 'images/category-1.webp',
                    'show_on_home' => true,
                    'home_sort_order' => $item['order'],
                ]);
            } else {
                $category->update([
                    'show_on_home' => true,
                    'home_sort_order' => $item['order'],
                    'image' => $category->image ?: 'images/category-1.webp',
                    // keep existing name for menu; Food Containers stays as is in menu
                ]);
            }
        }
    }
}
