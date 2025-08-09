<?php

namespace App\Services;

use App\Models\User;
use App\Models\QrCode;
use App\Models\Subscription;
use App\Mail\WelcomeEmail;
use App\Mail\ExpiryWarningEmail;
use App\Mail\PaymentReceiptEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Send welcome email to user after QR code claim
     *
     * @param User $user
     * @param QrCode $qrCode
     * @param string|null $password
     * @return bool
     */
    public function sendWelcomeEmail(User $user, QrCode $qrCode, string $password = null): bool
    {
        try {
            Mail::to($user->email)->send(new WelcomeEmail($user, $qrCode, $password));
            
            Log::info('Welcome email sent successfully', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'qr_code' => $qrCode->code
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'qr_code' => $qrCode->code,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Send expiry warning email to user
     *
     * @param User $user
     * @param int $daysLeft
     * @return bool
     */
    public function sendExpiryWarningEmail(User $user, int $daysLeft): bool
    {
        try {
            Mail::to($user->email)->send(new ExpiryWarningEmail($user, $daysLeft));
            
            Log::info('Expiry warning email sent successfully', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'days_left' => $daysLeft
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send expiry warning email', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'days_left' => $daysLeft,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Send payment receipt email to user
     *
     * @param User $user
     * @param Subscription $subscription
     * @param bool $isRenewal
     * @return bool
     */
    public function sendPaymentReceiptEmail(User $user, Subscription $subscription, bool $isRenewal = false): bool
    {
        try {
            Mail::to($user->email)->send(new PaymentReceiptEmail($user, $subscription, $isRenewal));
            
            Log::info('Payment receipt email sent successfully', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'subscription_id' => $subscription->id,
                'is_renewal' => $isRenewal,
                'amount' => $subscription->amount
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send payment receipt email', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'subscription_id' => $subscription->id,
                'is_renewal' => $isRenewal,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Send bulk expiry warning emails to users whose trials are expiring
     *
     * @param array $warningDays Array of days before expiry to send warnings (e.g., [7, 3, 1, 0])
     * @return array
     */
    public function sendBulkExpiryWarnings(array $warningDays = [7, 3, 1, 0]): array
    {
        $results = [
            'sent' => 0,
            'failed' => 0,
            'details' => []
        ];

        foreach ($warningDays as $days) {
            $targetDate = now()->addDays($days)->startOfDay();
            
            $users = User::whereNotNull('trial_ends_at')
                ->whereDate('trial_ends_at', $targetDate)
                ->where('is_subscribed', false)
                ->get();

            foreach ($users as $user) {
                $sent = $this->sendExpiryWarningEmail($user, $days);
                
                if ($sent) {
                    $results['sent']++;
                } else {
                    $results['failed']++;
                }
                
                $results['details'][] = [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'days_left' => $days,
                    'sent' => $sent
                ];
            }
        }

        Log::info('Bulk expiry warning emails processed', $results);
        
        return $results;
    }

    /**
     * Test email configuration by sending a test email
     *
     * @param string $testEmail
     * @return bool
     */
    public function testEmailConfiguration(string $testEmail): bool
    {
        try {
            Mail::raw('This is a test email from ' . config('app.name') . '. If you receive this, your email configuration is working correctly!', function ($message) use ($testEmail) {
                $message->to($testEmail)
                    ->subject('Test Email - ' . config('app.name'));
            });
            
            Log::info('Test email sent successfully', ['email' => $testEmail]);
            return true;
        } catch (\Exception $e) {
            Log::error('Test email failed', [
                'email' => $testEmail,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}