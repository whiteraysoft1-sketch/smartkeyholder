<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('pwa_icon')->nullable()->after('profile_image');
            $table->string('pwa_app_name')->nullable()->after('pwa_icon');
            $table->string('pwa_short_name')->nullable()->after('pwa_app_name');
            $table->string('pwa_theme_color')->default('#000000')->after('pwa_short_name');
            $table->string('pwa_background_color')->default('#ffffff')->after('pwa_theme_color');
            $table->string('currency')->default('USD')->after('pwa_background_color');
            $table->string('currency_symbol')->default('$')->after('currency');
            $table->boolean('pwa_enabled')->default(false)->after('currency_symbol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'pwa_icon',
                'pwa_app_name',
                'pwa_short_name',
                'pwa_theme_color',
                'pwa_background_color',
                'currency',
                'currency_symbol',
                'pwa_enabled'
            ]);
        });
    }
};