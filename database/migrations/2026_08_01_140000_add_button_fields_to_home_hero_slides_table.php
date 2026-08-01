<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_hero_slides', function (Blueprint $table) {
            $table->string('button_text')->nullable()->after('alt_text');
            $table->string('button_link')->nullable()->after('button_text');
        });

        $settings = DB::table('home_settings')->first();
        $buttonText = $settings->hero_cta_text ?? 'Shop Now';
        $buttonLink = $settings->hero_cta_url ?? '/shop';

        DB::table('home_hero_slides')->update([
            'button_text' => $buttonText,
            'button_link' => $buttonLink,
        ]);
    }

    public function down(): void
    {
        Schema::table('home_hero_slides', function (Blueprint $table) {
            $table->dropColumn(['button_text', 'button_link']);
        });
    }
};
