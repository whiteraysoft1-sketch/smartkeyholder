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
        Schema::table('users', function (Blueprint $table) {
            // Only add columns if they do not already exist
            if (!Schema::hasColumn('users', 'is_subscribed')) {
                $table->boolean('is_subscribed')->default(false)->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'subscription_ends_at')) {
                $table->dateTime('subscription_ends_at')->nullable()->after('is_subscribed');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_subscribed')) {
                $table->dropColumn('is_subscribed');
            }
            if (Schema::hasColumn('users', 'subscription_ends_at')) {
                $table->dropColumn('subscription_ends_at');
            }
        });
    }
};
