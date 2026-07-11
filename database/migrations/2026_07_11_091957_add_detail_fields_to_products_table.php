<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->default('XPERCIAINC')->after('name');
            $table->text('short_description')->nullable()->after('image');
            $table->longText('description')->nullable()->after('short_description');
            $table->json('gallery')->nullable()->after('description');
            $table->json('pack_options')->nullable()->after('gallery');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'brand',
                'short_description',
                'description',
                'gallery',
                'pack_options',
            ]);
        });
    }
};
