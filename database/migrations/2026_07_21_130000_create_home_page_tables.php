<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_cta_text')->default('Shop Now');
            $table->string('hero_cta_url')->default('/shop');
            $table->timestamps();
        });

        Schema::create('home_hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('alt_text')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('type'); // category | flag
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_flag')->nullable();
            $table->unsignedSmallInteger('product_limit')->default(6);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('show_view_all')->default(true);
            $table->unsignedTinyInteger('grid_columns')->default(3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_sections');
        Schema::dropIfExists('home_hero_slides');
        Schema::dropIfExists('home_settings');
    }
};
