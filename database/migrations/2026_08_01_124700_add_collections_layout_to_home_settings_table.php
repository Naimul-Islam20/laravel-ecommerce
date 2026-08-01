<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->unsignedTinyInteger('collections_columns')->default(4)->after('hero_cta_url');
            $table->unsignedTinyInteger('collections_rows')->default(2)->after('collections_columns');
        });
    }

    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn(['collections_columns', 'collections_rows']);
        });
    }
};
