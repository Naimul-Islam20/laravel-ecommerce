<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_meal_trays')->default(false)->after('is_trending');
            $table->boolean('is_round_containers')->default(false)->after('is_meal_trays');
            $table->boolean('is_rectangular_container')->default(false)->after('is_round_containers');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'is_meal_trays',
                'is_round_containers',
                'is_rectangular_container',
            ]);
        });
    }
};
