<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('site_name');
            $table->string('favicon')->nullable()->after('logo');
        });

        if (Schema::hasColumn('site_settings', 'og_image')) {
            Schema::table('site_settings', function (Blueprint $table) {
                $table->dropColumn('og_image');
            });
        }
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('og_image')->nullable()->after('meta_keywords');
            $table->dropColumn(['logo', 'favicon']);
        });
    }
};
