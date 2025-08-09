<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\EmailService;

class SendExpiryWarnings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-expiry-warnings {--days=7,3,1,0 : Comma-separated list of days before expiry to send warnings}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send expiry warning emails to users whose free trials are about to expire';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emailService = new EmailService();
        
        // Parse the days parameter
        $daysString = $this->option('days');
        $warningDays = array_map('intval', explode(',', $daysString));
        
        $this->info("Sending expiry warnings for days: " . implode(', ', $warningDays));
        
        $totalSent = 0;
        $totalFailed = 0;
        
        foreach ($warningDays as $days) {
            $this->info("Processing users with {$days} day(s) left...");
            
            // Calculate the target date
            if ($days > 0) {
                $targetDate = now()->addDays($days)->startOfDay();
                $endDate = now()->addDays($days)->endOfDay();
            } else {
                // For expired trials (0 days), get users whose trial expired today
                $targetDate = now()->startOfDay();
                $endDate = now()->endOfDay();
            }
            
            // Find users whose trial ends on the target date and are not subscribed
            $query = User::whereNotNull('trial_ends_at')
                ->where('is_subscribed', false);
                
            if ($days > 0) {
                $query->whereBetween('trial_ends_at', [$targetDate, $endDate]);
            } else {
                // For expired trials, get users whose trial ended today or earlier
                $query->where('trial_ends_at', '<=', $endDate);
            }
            
            $users = $query->get();
            
            $this->info("Found {$users->count()} users to notify");
            
            foreach ($users as $user) {
                $daysLeft = $days > 0 ? $days : max(0, now()->diffInDays($user->trial_ends_at, false));
                
                if ($emailService->sendExpiryWarningEmail($user, $daysLeft)) {
                    $totalSent++;
                    $this->line("✓ Sent to {$user->email} ({$daysLeft} days left)");
                } else {
                    $totalFailed++;
                    $this->error("✗ Failed to send to {$user->email}");
                }
            }
        }
        
        $this->info("Expiry warning emails completed!");
        $this->info("Total sent: {$totalSent}");
        $this->info("Total failed: {$totalFailed}");
        
        return Command::SUCCESS;
    }
}