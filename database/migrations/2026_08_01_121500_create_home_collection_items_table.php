<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_collection_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->unique()->constrained()->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        if (! Schema::hasTable('categories')) {
            return;
        }

        $rows = Category::query()
            ->active()
            ->where('show_on_home', true)
            ->orderBy('home_sort_order')
            ->orderBy('name')
            ->get(['id', 'home_sort_order']);

        foreach ($rows as $index => $category) {
            \DB::table('home_collection_items')->insert([
                'category_id' => $category->id,
                'sort_order' => (int) ($category->home_sort_order ?: $index),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('home_collection_items');
    }
};
