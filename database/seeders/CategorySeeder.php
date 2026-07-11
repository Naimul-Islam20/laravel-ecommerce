<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::query()->delete();

        $columns = [
            1 => [
                [
                    'name' => 'Meal Trays',
                    'children' => [
                        'Reusable Meal Trays',
                        'Cornstarch Meal Trays',
                    ],
                ],
                [
                    'name' => 'Hinged Box',
                    'children' => [],
                ],
            ],
            2 => [
                [
                    'name' => 'Food Containers',
                    'children' => [
                        'Round Containers',
                        'Rectangular Containers',
                        'Tamper Proof Containers',
                        'Tamper Proof Bucket',
                    ],
                ],
                [
                    'name' => 'Cornstarch Product',
                    'children' => [],
                ],
            ],
            3 => [
                [
                    'name' => 'Bagasse Products',
                    'children' => [
                        'Bagasse Clamshell',
                        'Bagasse Takeaway Container',
                    ],
                ],
                [
                    'name' => 'Bakery Products',
                    'children' => [],
                ],
            ],
            4 => [
                [
                    'name' => 'Aluminium Containers',
                    'children' => [],
                ],
                [
                    'name' => 'Wooden Cutlery',
                    'children' => [],
                ],
            ],
            5 => [
                [
                    'name' => 'Eco Friendly Products',
                    'children' => [],
                ],
                [
                    'name' => 'Shakes & Mocktail',
                    'children' => [
                        'Sipper Glass',
                        'Tea Coffee Flask',
                    ],
                ],
            ],
            6 => [
                [
                    'name' => 'Paper Products',
                    'children' => [
                        'PSB Lunch Box',
                        'Doggy Bag',
                        'Paper Straw',
                        'Butter Paper',
                        'Takeaway Paper Container',
                        'Pizza & Sandwich Box',
                    ],
                ],
                [
                    'name' => 'New arrivals',
                    'children' => [],
                ],
            ],
        ];

        foreach ($columns as $column => $rows) {
            foreach ($rows as $rowIndex => $categoryData) {
                $parent = Category::create([
                    'name' => $categoryData['name'],
                    'slug' => $this->uniqueSlug($categoryData['name']),
                    'parent_id' => null,
                    'menu_column' => $column,
                    'menu_row' => $rowIndex + 1,
                    'sort_order' => $rowIndex,
                    'is_active' => true,
                ]);

                foreach ($categoryData['children'] as $childIndex => $childName) {
                    Category::create([
                        'name' => $childName,
                        'slug' => $this->uniqueSlug($childName),
                        'parent_id' => $parent->id,
                        'menu_column' => null,
                        'menu_row' => null,
                        'sort_order' => $childIndex,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
