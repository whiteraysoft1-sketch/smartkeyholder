<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\PricingPlan;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckExpiredTrials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired trials and subscriptions, and send notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired trials and subscriptions...');

        // Check for trials expiring in 3 days
        $this->checkTrialsExpiringSoon();
        
        // Check for expired trials
        $this->checkExpiredTrials();
        
        // Check for subscriptions expiring in 7 days
        $this->checkSubscriptionsExpiringSoon();
        
        // Check for expired subscriptions
        $this->checkExpiredSubscriptions();

        $this->info('Subscription check completed.');
    }

    /**
     * Check for trials expiring in 3 days
     */
    private function checkTrialsExpiringSoon()
    {
        $threeDaysFromNow = now()->addDays(3);
        
        $users = User::where('trial_ends_at', '<=', $threeDaysFromNow)
                    ->where('trial_ends_at', '>', now())
                    ->where('is_subscribed', false)
                    ->get();

        foreach ($users as $user) {
            $daysLeft = now()->diffInDays($user->trial_ends_at, false);
            
            $this->info("Trial expiring soon for user: {$user->email} ({$daysLeft} days left)");
            
            // Here you could send an email notification
            // Mail::to($user)->send(new TrialExpiringSoonMail($user, $daysLeft));
        }

        $this->info("Found {$users->count()} trials expiring soon.");
    }

    /**
     * Check for expired trials
     */
    private function checkExpiredTrials()
    {
        $users = User::where('trial_ends_at', '<=', now())
                    ->where('is_subscribed', false)
                    ->get();

        foreach ($users as $user) {
            $this->warn("Expired trial for user: {$user->email}");
            
            // Here you could send an email notification
            // Mail::to($user)->send(new TrialExpiredMail($user));
        }

        $this->info("Found {$users->count()} expired trials.");
    }

    /**
     * Check for subscriptions expiring in 7 days
     */
    private function checkSubscriptionsExpiringSoon()
    {
        $sevenDaysFromNow = now()->addDays(7);
        
        $users = User::where('subscription_ends_at', '<=', $sevenDaysFromNow)
                    ->where('subscription_ends_at', '>', now())
                    ->where('is_subscribed', true)
                    ->get();

        foreach ($users as $user) {
            $daysLeft = now()->diffInDays($user->subscription_ends_at, false);
            
            $this->info("Subscription expiring soon for user: {$user->email} ({$daysLeft} days left)");
            
            // Here you could send an email notification
            // Mail::to($user)->send(new SubscriptionExpiringSoonMail($user, $daysLeft));
        }

        $this->info("Found {$users->count()} subscriptions expiring soon.");
    }

    /**
     * Check for expired subscriptions
     */
    private function checkExpiredSubscriptions()
    {
        $users = User::where('subscription_ends_at', '<=', now())
                    ->where('is_subscribed', true)
                    ->get();

        foreach ($users as $user) {
            $this->warn("Expired subscription for user: {$user->email}");
            
            // Update user status
            $user->update(['is_subscribed' => false]);
            
            // Update active subscription status
            if ($user->activeSubscription) {
                $user->activeSubscription->update([
                    'status' => 'expired',
                    'expired_at' => now()
                ]);
            }
            
            // Here you could send an email notification
            // Mail::to($user)->send(new SubscriptionExpiredMail($user));
        }

        $this->info("Found and updated {$users->count()} expired subscriptions.");
    }
}