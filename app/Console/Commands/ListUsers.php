<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users with their trial/subscription status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->info('No users found.');
            return 0;
        }
        
        $headers = ['ID', 'Name', 'Email', 'Trial Ends', 'Subscribed', 'Can Access Dashboard'];
        $rows = [];
        
        foreach ($users as $user) {
            $rows[] = [
                $user->id,
                $user->name,
                $user->email,
                $user->trial_ends_at ? $user->trial_ends_at->format('Y-m-d H:i') : 'No trial',
                $user->is_subscribed ? 'Yes' : 'No',
                $user->canAccessDashboard() ? 'Yes' : 'No',
            ];
        }
        
        $this->table($headers, $rows);
        
        return 0;
    }
}