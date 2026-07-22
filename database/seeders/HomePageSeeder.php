<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\HomeHeroSlide;
use App\Models\HomeSection;
use App\Models\HomeSetting;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        HomeSetting::current();

        HomeHeroSlide::query()->delete();
        HomeSection::query()->delete();

        HomeHeroSlide::insert([
            [
                'image' => 'images/hero-7.png',
                'alt_text' => 'xperciainc eco-friendly packaging',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'images/hero-7.png',
                'alt_text' => 'xperciainc product collection',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $sections = [
            ['title' => 'Best Seller', 'slug' => 'best-sellers', 'type' => HomeSection::TYPE_FLAG, 'legacy_flag' => 'is_best_seller', 'limit' => 6, 'order' => 1, 'grid' => 3],
            ['title' => 'Top Selling Product', 'slug' => 'top-selling', 'type' => HomeSection::TYPE_FLAG, 'legacy_flag' => 'is_top_selling', 'limit' => 6, 'order' => 2, 'grid' => 3],
            ['title' => 'Hinged Box', 'slug' => 'hinged-box', 'type' => HomeSection::TYPE_FLAG, 'legacy_flag' => 'is_hinged_box', 'limit' => 6, 'order' => 3, 'grid' => 3],
            ['title' => 'Trending Product', 'slug' => 'trending', 'type' => HomeSection::TYPE_FLAG, 'legacy_flag' => 'is_trending', 'limit' => 6, 'order' => 4, 'grid' => 3],
            ['title' => 'Meal Trays', 'slug' => 'home-meal-trays', 'type' => HomeSection::TYPE_CATEGORY, 'category_slug' => 'meal-trays', 'limit' => 6, 'order' => 5, 'grid' => 3],
            ['title' => 'Round Containers', 'slug' => 'home-round-containers', 'type' => HomeSection::TYPE_SUBCATEGORY, 'category_slug' => 'round-containers', 'limit' => 6, 'order' => 6, 'grid' => 3],
            ['title' => 'Rectangular Container', 'slug' => 'home-rectangular-containers', 'type' => HomeSection::TYPE_SUBCATEGORY, 'category_slug' => 'rectangular-containers', 'limit' => 6, 'order' => 7, 'grid' => 3],
            ['title' => 'Cornstarch Product', 'slug' => 'home-cornstarch-product', 'type' => HomeSection::TYPE_CATEGORY, 'category_slug' => 'cornstarch-product', 'limit' => 4, 'order' => 8, 'grid' => 4],
            ['title' => 'Aluminium Foil Container', 'slug' => 'home-aluminium-containers', 'type' => HomeSection::TYPE_CATEGORY, 'category_slug' => 'aluminium-containers', 'limit' => 4, 'order' => 9, 'grid' => 4],
            ['title' => 'Bagasse Tableware', 'slug' => 'home-bagasse-products', 'type' => HomeSection::TYPE_CATEGORY, 'category_slug' => 'bagasse-products', 'limit' => 6, 'order' => 10, 'grid' => 3],
            ['title' => 'Biodegradable Products', 'slug' => 'biodegradable-products', 'type' => HomeSection::TYPE_FLAG, 'legacy_flag' => 'is_biodegradable_products', 'limit' => 6, 'order' => 11, 'grid' => 3],
            ['title' => 'Bagasse Takeaway Container', 'slug' => 'home-bagasse-takeaway', 'type' => HomeSection::TYPE_SUBCATEGORY, 'category_slug' => 'bagasse-takeaway-container', 'limit' => 6, 'order' => 12, 'grid' => 3],
            ['title' => 'Paper Products', 'slug' => 'home-paper-products', 'type' => HomeSection::TYPE_CATEGORY, 'category_slug' => 'paper-products', 'limit' => 6, 'order' => 13, 'grid' => 3],
            ['title' => 'New Arrivals', 'slug' => 'new-arrivals', 'type' => HomeSection::TYPE_FLAG, 'legacy_flag' => 'is_new_arrivals', 'limit' => 6, 'order' => 14, 'grid' => 3],
        ];

        foreach ($sections as $item) {
            $categoryId = null;

            if ($item['type'] === HomeSection::TYPE_CATEGORY || $item['type'] === HomeSection::TYPE_SUBCATEGORY) {
                $categoryId = Category::where('slug', $item['category_slug'])->value('id');
            }

            $section = HomeSection::create([
                'title' => $item['title'],
                'slug' => $item['slug'],
                'type' => $item['type'],
                'category_id' => $categoryId,
                'product_flag' => null,
                'product_limit' => $item['limit'],
                'sort_order' => $item['order'],
                'is_active' => true,
                'show_view_all' => true,
                'grid_columns' => $item['grid'],
            ]);

            if ($item['type'] === HomeSection::TYPE_FLAG && isset($item['legacy_flag'])) {
                $flag = $item['legacy_flag'];

                if (Schema::hasColumn('products', $flag)) {
                    $productIds = Product::query()->where($flag, true)->pluck('id')->all();
                    $section->flaggedProducts()->sync($productIds);
                }
            }
        }
    }
}
