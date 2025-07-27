<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user can access dashboard (has active subscription or trial)
        if (!$user->canAccessDashboard()) {
            // Determine the appropriate message based on user status
            $message = 'Your trial has expired. Please subscribe to continue using the service.';
            
            if ($user->trial_ends_at && $user->trial_ends_at->isPast()) {
                $message = 'Your free trial has expired. Choose a subscription plan below to continue using our service and regain access to your dashboard.';
            } elseif (!$user->trial_ends_at && !$user->hasActiveSubscription()) {
                $message = 'A subscription is required to access this feature. Please choose a plan below to get started.';
            } elseif ($user->hasActiveSubscription() && $user->subscription_ends_at && $user->subscription_ends_at->isPast()) {
                $message = 'Your subscription has expired. Please renew your subscription to continue using the service.';
            }
            
            return redirect()->route('billing')->with('error', $message);
        }

        return $next($request);
    }
}
