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
        Product::query()->delete();

        $foodContainersId = Category::where('slug', 'food-containers')->value('id');
        $mealTraysId = Category::where('slug', 'meal-trays')->value('id') ?? $foodContainersId;
        $hingedBoxId = Category::where('slug', 'hinged-box')->value('id') ?? $foodContainersId;
        $roundContainersId = Category::where('slug', 'round-containers')->value('id') ?? $foodContainersId;
        $rectangularContainersId = Category::where('slug', 'rectangular-containers')->value('id') ?? $foodContainersId;

        $this->seedSection($foodContainersId, 'is_best_seller', [
            ['name' => 'Xperciainc Round Food Container With LID 8 Oz Tall 250Ml', 'price' => 175.00],
            ['name' => 'Xperciainc Round Food Container With LID 16 Oz 500Ml', 'price' => 250.00],
            ['name' => 'Xperciainc Round Food Container With LID 24 Oz 750Ml', 'price' => 275.00],
            ['name' => 'Xperciainc Sauce & Dip Transparent Hinge Lid Container 35Ml', 'price' => 120.00],
            ['name' => 'Xperciainc Round Food Container With LID 32 Oz 1000Ml', 'price' => 325.00],
            ['name' => 'Xperciainc Round Food Container With LID 48 Oz 1500Ml', 'price' => 425.00],
            ['name' => 'Xperciainc Rectangular Food Container With LID 250 ml', 'price' => 250.00],
            ['name' => 'Xperciainc Rectangular Food Container With LID 350 ml', 'price' => 275.00],
            ['name' => 'Xperciainc Rectangular Food Container With LID 500 ml', 'price' => 325.00],
            ['name' => 'Xperciainc Rectangular Food Container With LID 750 ml', 'price' => 375.00],
            ['name' => 'Xperciainc Rectangular Food Container With LID 1000 ml', 'price' => 425.00],
            ['name' => 'Xperciainc 2 Compartment Rectangular Food Container With LID 1000 ml', 'price' => 475.00],
            ['name' => 'Xperciainc 3 Compartment Meal Tray With LID 1000 ml', 'price' => 450.00],
            ['name' => 'Xperciainc Round Bowl With LID 750Ml', 'price' => 295.00],
            ['name' => 'Xperciainc Tamper Proof Container 500Ml', 'price' => 310.00],
            ['name' => 'Xperciainc Hinged Lid Takeaway Box 750Ml', 'price' => 340.00],
            ['name' => 'Xperciainc Square Food Container With LID 500Ml', 'price' => 285.00],
            ['name' => 'Xperciainc Deep Round Container With LID 1000Ml', 'price' => 360.00],
        ]);

        $this->seedSection($foodContainersId, 'is_top_selling', [
            ['name' => 'Xperciainc Kraft Paper Food Box 500Ml', 'price' => 180.00],
            ['name' => 'Xperciainc Kraft Paper Food Box 750Ml', 'price' => 210.00],
            ['name' => 'Xperciainc Kraft Paper Food Box 1000Ml', 'price' => 245.00],
            ['name' => 'Xperciainc Soup Cup With Lid 8 Oz', 'price' => 165.00],
            ['name' => 'Xperciainc Soup Cup With Lid 12 Oz', 'price' => 195.00],
            ['name' => 'Xperciainc Soup Cup With Lid 16 Oz', 'price' => 225.00],
            ['name' => 'Xperciainc Salad Bowl Clear 500Ml', 'price' => 260.00],
            ['name' => 'Xperciainc Salad Bowl Clear 750Ml', 'price' => 290.00],
            ['name' => 'Xperciainc Salad Bowl Clear 1000Ml', 'price' => 320.00],
            ['name' => 'Xperciainc Hot Cup Sleeve Kraft', 'price' => 95.00],
            ['name' => 'Xperciainc Hot Cup 8 Oz Double Wall', 'price' => 140.00],
            ['name' => 'Xperciainc Hot Cup 12 Oz Double Wall', 'price' => 160.00],
            ['name' => 'Xperciainc Cold Cup PET 12 Oz', 'price' => 155.00],
            ['name' => 'Xperciainc Cold Cup PET 16 Oz', 'price' => 175.00],
            ['name' => 'Xperciainc Flat Lid For Cold Cup', 'price' => 85.00],
            ['name' => 'Xperciainc Dome Lid For Cold Cup', 'price' => 90.00],
            ['name' => 'Xperciainc Sugarcane Plate 9 Inch', 'price' => 130.00],
            ['name' => 'Xperciainc Sugarcane Bowl 500Ml', 'price' => 150.00],
        ]);

        $this->seedSection($hingedBoxId, 'is_hinged_box', [
            ['name' => 'Xperciainc Hinged Box 250Ml', 'price' => 185.00],
            ['name' => 'Xperciainc Hinged Box 500Ml', 'price' => 220.00],
            ['name' => 'Xperciainc Hinged Box 750Ml', 'price' => 255.00],
            ['name' => 'Xperciainc Hinged Box 1000Ml', 'price' => 295.00],
            ['name' => 'Xperciainc Hinged Box 2 Compartment 750Ml', 'price' => 310.00],
            ['name' => 'Xperciainc Hinged Box 3 Compartment 1000Ml', 'price' => 345.00],
        ]);

        $this->seedSection($foodContainersId, 'is_trending', [
            ['name' => 'Xperciainc Trending Takeaway Box 500Ml', 'price' => 205.00],
            ['name' => 'Xperciainc Trending Takeaway Box 750Ml', 'price' => 235.00],
            ['name' => 'Xperciainc Trending Clamshell 500Ml', 'price' => 215.00],
            ['name' => 'Xperciainc Trending Clamshell 750Ml', 'price' => 250.00],
            ['name' => 'Xperciainc Trending Meal Box 1000Ml', 'price' => 285.00],
            ['name' => 'Xperciainc Trending Portion Cup Set', 'price' => 165.00],
        ]);

        $this->seedSection($mealTraysId, 'is_meal_trays', [
            ['name' => 'Xperciainc Meal Tray 1 Compartment 500Ml', 'price' => 195.00],
            ['name' => 'Xperciainc Meal Tray 2 Compartment 750Ml', 'price' => 240.00],
            ['name' => 'Xperciainc Meal Tray 3 Compartment 1000Ml', 'price' => 285.00],
            ['name' => 'Xperciainc Meal Tray Deep 1000Ml', 'price' => 300.00],
            ['name' => 'Xperciainc Reusable Meal Tray 750Ml', 'price' => 320.00],
            ['name' => 'Xperciainc Cornstarch Meal Tray 1000Ml', 'price' => 275.00],
        ]);

        $this->seedSection($roundContainersId, 'is_round_containers', [
            ['name' => 'Xperciainc Round Container 8 Oz', 'price' => 160.00],
            ['name' => 'Xperciainc Round Container 12 Oz', 'price' => 185.00],
            ['name' => 'Xperciainc Round Container 16 Oz', 'price' => 210.00],
            ['name' => 'Xperciainc Round Container 24 Oz', 'price' => 245.00],
            ['name' => 'Xperciainc Round Container 32 Oz', 'price' => 275.00],
            ['name' => 'Xperciainc Round Container 48 Oz', 'price' => 320.00],
        ]);

        $this->seedSection($rectangularContainersId, 'is_rectangular_container', [
            ['name' => 'Xperciainc Rectangular Container 250Ml', 'price' => 170.00],
            ['name' => 'Xperciainc Rectangular Container 350Ml', 'price' => 195.00],
            ['name' => 'Xperciainc Rectangular Container 500Ml', 'price' => 225.00],
            ['name' => 'Xperciainc Rectangular Container 750Ml', 'price' => 255.00],
            ['name' => 'Xperciainc Rectangular Container 1000Ml', 'price' => 290.00],
            ['name' => 'Xperciainc Rectangular Container 2 Comp 1000Ml', 'price' => 330.00],
        ]);
    }

    private function seedSection(?int $categoryId, string $flag, array $products): void
    {
        $flags = [
            'is_best_seller' => false,
            'is_top_selling' => false,
            'is_hinged_box' => false,
            'is_trending' => false,
            'is_meal_trays' => false,
            'is_round_containers' => false,
            'is_rectangular_container' => false,
        ];
        $flags[$flag] = true;

        foreach ($products as $index => $item) {
            Product::create([
                'category_id' => $categoryId,
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'image' => null,
                'price_from' => $item['price'],
                'currency' => 'Rs.',
                ...$flags,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
