<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_cornstarch_product')->default(false)->after('is_rectangular_container');
            $table->boolean('is_aluminium_foil_container')->default(false)->after('is_cornstarch_product');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'is_cornstarch_product',
                'is_aluminium_foil_container',
            ]);
        });
    }
};
