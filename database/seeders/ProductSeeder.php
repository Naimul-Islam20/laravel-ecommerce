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

        $reusableMealTraysId = Category::where('slug', 'reusable-meal-trays')->value('id') ?? $mealTraysId;
        $cornstarchMealTraysId = Category::where('slug', 'cornstarch-meal-trays')->value('id') ?? $mealTraysId;

        // Parent category products (shown first on collection page).
        $this->seedSection($mealTraysId, 'is_meal_trays', [
            ['name' => 'Xperciainc Meal Tray 1 Compartment 500Ml', 'price' => 195.00],
            ['name' => 'Xperciainc Meal Tray 2 Compartment 750Ml', 'price' => 240.00],
            ['name' => 'Xperciainc Meal Tray 3 Compartment 1000Ml', 'price' => 285.00],
            ['name' => 'Xperciainc 3 Compartment Meal Box Tray Mini', 'price' => 212.50],
            ['name' => 'Xperciainc 4 Compartment Meal Box Tray', 'price' => 255.00],
            ['name' => 'Xperciainc Meal Tray Deep 1000Ml', 'price' => 300.00],
        ]);

        // Subcategory products (shown after parent products).
        $this->seedSection($reusableMealTraysId, null, [
            ['name' => 'Xperciainc Reusable Meal Tray 750Ml', 'price' => 320.00],
            ['name' => 'Xperciainc Reusable Meal Tray 1000Ml', 'price' => 345.00],
            ['name' => 'Xperciainc Reusable 2 Comp Meal Tray', 'price' => 360.00],
            ['name' => 'Xperciainc Reusable 3 Comp Meal Tray', 'price' => 385.00],
        ]);

        $this->seedSection($cornstarchMealTraysId, null, [
            ['name' => 'Xperciainc Cornstarch Meal Tray 1000Ml', 'price' => 275.00],
            ['name' => 'Xperciainc Cornstarch Meal Tray Mini', 'price' => 230.00],
            ['name' => 'Xperciainc Cornstarch 3 Comp Meal Tray', 'price' => 290.00],
            ['name' => 'Xperciainc Cornstarch 5 Comp Meal Tray', 'price' => 310.00],
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

        $cornstarchId = Category::where('slug', 'cornstarch-product')->value('id') ?? $foodContainersId;
        $aluminiumId = Category::where('slug', 'aluminium-containers')->value('id') ?? $foodContainersId;

        $this->seedSection($cornstarchId, 'is_cornstarch_product', [
            ['name' => 'Xperciainc Cornstarch Clamshell 500Ml', 'price' => 210.00],
            ['name' => 'Xperciainc Cornstarch Clamshell 750Ml', 'price' => 245.00],
            ['name' => 'Xperciainc Cornstarch Bowl 500Ml', 'price' => 190.00],
            ['name' => 'Xperciainc Cornstarch Plate 9 Inch', 'price' => 155.00],
        ]);

        $this->seedSection($aluminiumId, 'is_aluminium_foil_container', [
            ['name' => 'Xperciainc Aluminium Foil Container Small', 'price' => 145.00],
            ['name' => 'Xperciainc Aluminium Foil Container Medium', 'price' => 175.00],
            ['name' => 'Xperciainc Aluminium Foil Container Large', 'price' => 210.00],
            ['name' => 'Xperciainc Aluminium Foil Container XL', 'price' => 250.00],
        ]);

        $bagasseId = Category::where('slug', 'bagasse-products')->value('id') ?? $foodContainersId;

        $this->seedSection($bagasseId, 'is_bagasse_tableware', [
            ['name' => 'Xperciainc Bagasse Plate 6 Inch', 'price' => 120.00],
            ['name' => 'Xperciainc Bagasse Plate 9 Inch', 'price' => 145.00],
            ['name' => 'Xperciainc Bagasse Bowl 500Ml', 'price' => 165.00],
            ['name' => 'Xperciainc Bagasse Bowl 750Ml', 'price' => 185.00],
            ['name' => 'Xperciainc Bagasse Clamshell 500Ml', 'price' => 195.00],
            ['name' => 'Xperciainc Bagasse Clamshell 750Ml', 'price' => 225.00],
            ['name' => 'Xperciainc Bagasse Takeaway Box 500Ml', 'price' => 200.00],
            ['name' => 'Xperciainc Bagasse Takeaway Box 750Ml', 'price' => 230.00],
            ['name' => 'Xperciainc Bagasse Tray 1 Comp', 'price' => 175.00],
            ['name' => 'Xperciainc Bagasse Tray 2 Comp', 'price' => 210.00],
            ['name' => 'Xperciainc Bagasse Cup 8 Oz', 'price' => 110.00],
            ['name' => 'Xperciainc Bagasse Cup 12 Oz', 'price' => 130.00],
        ]);

        $this->seedSection($foodContainersId, 'is_biodegradable_products', [
            ['name' => 'Xperciainc Biodegradable Cutlery Set', 'price' => 95.00],
            ['name' => 'Xperciainc Biodegradable Spoon Pack', 'price' => 85.00],
            ['name' => 'Xperciainc Biodegradable Fork Pack', 'price' => 85.00],
            ['name' => 'Xperciainc Biodegradable Knife Pack', 'price' => 85.00],
            ['name' => 'Xperciainc Biodegradable Straw Pack', 'price' => 75.00],
            ['name' => 'Xperciainc Biodegradable Food Wrap', 'price' => 140.00],
            ['name' => 'Xperciainc Biodegradable Trash Bag Small', 'price' => 160.00],
            ['name' => 'Xperciainc Biodegradable Trash Bag Large', 'price' => 190.00],
            ['name' => 'Xperciainc Biodegradable Lunch Box', 'price' => 220.00],
            ['name' => 'Xperciainc Biodegradable Salad Bowl', 'price' => 205.00],
            ['name' => 'Xperciainc Biodegradable Soup Cup', 'price' => 155.00],
            ['name' => 'Xperciainc Biodegradable Portion Cup', 'price' => 115.00],
        ]);

        $bagasseTakeawayId = Category::where('slug', 'bagasse-takeaway-container')->value('id') ?? $bagasseId;

        $this->seedSection($bagasseTakeawayId, 'is_bagasse_takeaway_container', [
            ['name' => 'Xperciainc Bagasse Takeaway Container 250Ml', 'price' => 155.00],
            ['name' => 'Xperciainc Bagasse Takeaway Container 500Ml', 'price' => 185.00],
            ['name' => 'Xperciainc Bagasse Takeaway Container 750Ml', 'price' => 215.00],
            ['name' => 'Xperciainc Bagasse Takeaway Container 1000Ml', 'price' => 245.00],
            ['name' => 'Xperciainc Bagasse Takeaway Container 2 Comp', 'price' => 265.00],
            ['name' => 'Xperciainc Bagasse Takeaway Container 3 Comp', 'price' => 295.00],
        ]);

        $paperProductsId = Category::where('slug', 'paper-products')->value('id') ?? $foodContainersId;

        $this->seedSection($paperProductsId, 'is_paper_products', [
            ['name' => 'Xperciainc Paper Cup 4 Oz', 'price' => 95.00],
            ['name' => 'Xperciainc Paper Cup 8 Oz', 'price' => 110.00],
            ['name' => 'Xperciainc Paper Cup 12 Oz', 'price' => 125.00],
            ['name' => 'Xperciainc Paper Cup 16 Oz', 'price' => 140.00],
            ['name' => 'Xperciainc Paper Bowl 500Ml', 'price' => 155.00],
            ['name' => 'Xperciainc Paper Bowl 750Ml', 'price' => 175.00],
            ['name' => 'Xperciainc Paper Plate 7 Inch', 'price' => 90.00],
            ['name' => 'Xperciainc Paper Plate 9 Inch', 'price' => 105.00],
            ['name' => 'Xperciainc Paper Straw Pack', 'price' => 70.00],
            ['name' => 'Xperciainc Butter Paper Sheet Pack', 'price' => 120.00],
            ['name' => 'Xperciainc Takeaway Paper Container Small', 'price' => 145.00],
            ['name' => 'Xperciainc Takeaway Paper Container Medium', 'price' => 170.00],
            ['name' => 'Xperciainc Takeaway Paper Container Large', 'price' => 195.00],
            ['name' => 'Xperciainc Kraft Paper Bag Small', 'price' => 85.00],
            ['name' => 'Xperciainc Kraft Paper Bag Medium', 'price' => 100.00],
            ['name' => 'Xperciainc Kraft Paper Bag Large', 'price' => 120.00],
            ['name' => 'Xperciainc Paper Napkin Pack', 'price' => 80.00],
            ['name' => 'Xperciainc Paper Food Wrap Roll', 'price' => 135.00],
        ]);

        $this->seedSection($foodContainersId, 'is_new_arrivals', [
            ['name' => 'Xperciainc New Arrival Eco Box 500Ml', 'price' => 185.00],
            ['name' => 'Xperciainc New Arrival Eco Box 750Ml', 'price' => 215.00],
            ['name' => 'Xperciainc New Arrival Clear Cup 12 Oz', 'price' => 145.00],
            ['name' => 'Xperciainc New Arrival Clear Cup 16 Oz', 'price' => 165.00],
            ['name' => 'Xperciainc New Arrival Meal Pack Set', 'price' => 275.00],
            ['name' => 'Xperciainc New Arrival Sauce Cup Kit', 'price' => 125.00],
        ]);
    }

    private function seedSection(?int $categoryId, ?string $flag, array $products): void
    {
        $flags = [
            'is_best_seller' => false,
            'is_top_selling' => false,
            'is_hinged_box' => false,
            'is_trending' => false,
            'is_meal_trays' => false,
            'is_round_containers' => false,
            'is_rectangular_container' => false,
            'is_cornstarch_product' => false,
            'is_aluminium_foil_container' => false,
            'is_bagasse_tableware' => false,
            'is_biodegradable_products' => false,
            'is_bagasse_takeaway_container' => false,
            'is_paper_products' => false,
            'is_new_arrivals' => false,
        ];

        if ($flag) {
            $flags[$flag] = true;
        }

        foreach ($products as $index => $item) {
            Product::create([
                'category_id' => $categoryId,
                'name' => $item['name'],
                'brand' => 'XPERCIAINC',
                'slug' => Str::slug($item['name']),
                'image' => null,
                'short_description' => 'This tray contains 3 different compartments to segregate a variety of dry and liquid food. It is microwave & Freezer safe.',
                'description' => '<p><strong>'.$item['name'].'</strong></p><p>Compact. Convenient. Classy.</p><p>Perfect for restaurants, cloud kitchens, catering, and takeaways. Durable build with a secure lid for mess-free packing and delivery.</p>',
                'gallery' => null,
                'pack_options' => [
                    ['pcs' => 25, 'unit_price' => 8.5],
                    ['pcs' => 100, 'unit_price' => 8],
                    ['pcs' => 300, 'unit_price' => 7.6],
                    ['pcs' => 500, 'unit_price' => 7.4],
                ],
                'price_from' => $item['price'],
                'currency' => 'Rs.',
                ...$flags,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
