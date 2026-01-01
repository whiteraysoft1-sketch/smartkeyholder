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
            $table->string('store_logo')->nullable()->after('store_description');
            $table->string('store_theme')->default('default')->after('store_logo'); // default, modern, minimal, vibrant, dark
            $table->string('store_primary_color')->default('#3B82F6')->after('store_theme'); // Primary brand color
            $table->string('store_secondary_color')->default('#10B981')->after('store_primary_color'); // Secondary/accent color
            $table->string('store_text_color')->default('#1F2937')->after('store_secondary_color'); // Text color
            $table->string('store_background_color')->default('#FFFFFF')->after('store_text_color'); // Background color
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'store_logo',
                'store_theme',
                'store_primary_color',
                'store_secondary_color',
                'store_text_color',
                'store_background_color'
            ]);
        });
    }
};
