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
            $table->string('business_name')->nullable()->after('profession');
            $table->string('business_phone')->nullable()->after('business_name');
            $table->string('business_email')->nullable()->after('business_phone');
            $table->text('business_address')->nullable()->after('business_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn(['business_name', 'business_phone', 'business_email', 'business_address']);
        });
    }
};
