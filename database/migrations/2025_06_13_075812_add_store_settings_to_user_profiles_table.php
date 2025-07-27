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
            $table->boolean('store_enabled')->default(false)->after('pwa_enabled');
            $table->string('store_name')->nullable()->after('store_enabled');
            $table->text('store_description')->nullable()->after('store_name');
            $table->string('store_whatsapp')->nullable()->after('store_description');
            $table->string('store_address')->nullable()->after('store_whatsapp');
            $table->json('store_hours')->nullable()->after('store_address'); // Opening hours
            $table->decimal('delivery_fee', 8, 2)->default(0)->after('store_hours');
            $table->decimal('minimum_order', 8, 2)->default(0)->after('delivery_fee');
            $table->boolean('delivery_available')->default(true)->after('minimum_order');
            $table->boolean('pickup_available')->default(true)->after('delivery_available');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'store_enabled',
                'store_name',
                'store_description',
                'store_whatsapp',
                'store_address',
                'store_hours',
                'delivery_fee',
                'minimum_order',
                'delivery_available',
                'pickup_available'
            ]);
        });
    }
};