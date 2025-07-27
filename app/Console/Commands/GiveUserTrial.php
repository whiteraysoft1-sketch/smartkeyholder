<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class GiveUserTrial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:give-trial {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give a user a 30-day trial';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }
        
        $user->update([
            'trial_ends_at' => now()->addDays(30),
            'is_subscribed' => false,
        ]);
        
        $this->info("Successfully gave {$user->name} ({$email}) a 30-day trial ending on {$user->trial_ends_at->format('Y-m-d H:i:s')}");
        
        return 0;
    }
}