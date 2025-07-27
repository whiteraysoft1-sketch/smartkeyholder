<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@example.com')->first();
        if (!$user) {
            $user = new User();
            $user->name = 'Admin';
            $user->email = 'admin@example.com';
        }
        $user->password = bcrypt('password123');
        $user->is_admin = 1;
        $user->email_verified_at = now();
        $user->trial_ends_at = now()->addMonth();
        $user->subscription_ends_at = now()->addMonth();
        $user->is_subscribed = false;
        $user->save();
    }
}
