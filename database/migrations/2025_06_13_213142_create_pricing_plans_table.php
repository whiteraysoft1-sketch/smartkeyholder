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
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 8, 2)->default(0);
            $table->string('billing_cycle')->default('month'); // month, year
            $table->text('description')->nullable();
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_free_trial')->default(false);
            $table->integer('trial_days')->nullable();
            $table->integer('sort_order')->default(0);
            $table->string('button_text')->default('Get Started');
            $table->string('button_color')->default('blue');
            $table->string('badge_text')->nullable();
            $table->string('badge_color')->nullable();
            
            // Feature limits
            $table->integer('max_social_links')->nullable();
            $table->integer('max_gallery_images')->nullable();
            $table->boolean('has_analytics')->default(false);
            $table->boolean('has_custom_themes')->default(false);
            $table->boolean('has_priority_support')->default(false);
            $table->boolean('has_qr_customization')->default(false);
            $table->boolean('has_whatsapp_store')->default(false);
            
            $table->timestamps();
            
            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
