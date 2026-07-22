<?php

use App\Models\HomeSection;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_section_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['home_section_id', 'product_id']);
        });

        // Migrate existing boolean flag assignments into the pivot.
        HomeSection::query()
            ->where('type', HomeSection::TYPE_FLAG)
            ->whereNotNull('product_flag')
            ->get()
            ->each(function (HomeSection $section) {
                $flag = $section->product_flag;

                if (! $flag || ! Schema::hasColumn('products', $flag)) {
                    return;
                }

                $productIds = Product::query()
                    ->where($flag, true)
                    ->pluck('id')
                    ->all();

                if ($productIds !== []) {
                    $section->flaggedProducts()->syncWithoutDetaching($productIds);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_section_product');
    }
};
