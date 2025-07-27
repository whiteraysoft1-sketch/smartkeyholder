@props(['user'])

@php
    $subscriptionStatus = $user->subscription_status;
    $showAlert = false;
    $alertType = '';
    $alertMessage = '';
    $alertTitle = '';
    $actionText = '';
    $actionUrl = '';

    if ($subscriptionStatus['type'] === 'trial') {
        if ($subscriptionStatus['days_left'] <= 3) {
            $showAlert = true;
            $alertType = $subscriptionStatus['days_left'] <= 0 ? 'danger' : 'warning';
            $alertTitle = $subscriptionStatus['days_left'] <= 0 ? 'Trial Expired!' : 'Trial Expiring Soon!';
            
            if ($subscriptionStatus['days_left'] <= 0) {
                $alertMessage = 'Your free trial has expired. Upgrade to a subscription plan to continue using our service and regain access to all features.';
                $actionText = 'Choose Subscription Plan';
            } else {
                $alertMessage = "Your free trial expires in {$subscriptionStatus['days_left']} day(s). Upgrade now to avoid service interruption.";
                $actionText = 'Upgrade Now';
            }
            $actionUrl = route('billing');
        }
    } elseif ($subscriptionStatus['type'] === 'subscription') {
        if ($subscriptionStatus['days_left'] <= 7) {
            $showAlert = true;
            $alertType = $subscriptionStatus['days_left'] <= 0 ? 'danger' : 'warning';
            $alertTitle = $subscriptionStatus['days_left'] <= 0 ? 'Subscription Expired!' : 'Subscription Expiring Soon!';
            
            if ($subscriptionStatus['days_left'] <= 0) {
                $alertMessage = 'Your subscription has expired. Renew your subscription to continue using our service.';
                $actionText = 'Renew Subscription';
            } else {
                $alertMessage = "Your subscription expires in {$subscriptionStatus['days_left']} day(s). Renew now to avoid service interruption.";
                $actionText = 'Renew Now';
            }
            $actionUrl = route('billing');
        }
    } elseif ($subscriptionStatus['type'] === 'none') {
        $showAlert = true;
        $alertType = 'danger';
        $alertTitle = 'Subscription Required';
        $alertMessage = 'Your trial has expired. Please subscribe to continue using the service and access all features.';
        $actionText = 'Choose Subscription Plan';
        $actionUrl = route('billing');
    }
@endphp

@if($showAlert)
    <div class="mb-4 sm:mb-6 rounded-lg border-l-4 p-3 sm:p-4 {{ $alertType === 'danger' ? 'border-red-400 bg-red-50' : 'border-yellow-400 bg-yellow-50' }}">
        <div class="flex flex-col sm:flex-row sm:items-start space-y-3 sm:space-y-0">
            <div class="flex-shrink-0 self-center sm:self-start">
                @if($alertType === 'danger')
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                @else
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                @endif
            </div>
            <div class="sm:ml-3 flex-1 text-center sm:text-left">
                <h3 class="text-sm font-medium {{ $alertType === 'danger' ? 'text-red-800' : 'text-yellow-800' }}">
                    {{ $alertTitle }}
                </h3>
                <div class="mt-2 text-sm {{ $alertType === 'danger' ? 'text-red-700' : 'text-yellow-700' }}">
                    <p>{{ $alertMessage }}</p>
                </div>
                <div class="mt-3 sm:mt-4">
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 sm:-mx-2 sm:-my-1.5">
                        <a href="{{ $actionUrl }}" 
                           class="rounded-md px-3 py-2 text-sm font-medium transition-colors text-center {{ $alertType === 'danger' ? 'bg-red-100 text-red-800 hover:bg-red-200' : 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' }}">
                            {{ $actionText }}
                        </a>
                        <button type="button" 
                                onclick="this.closest('.mb-4, .mb-6').style.display='none'" 
                                class="rounded-md px-3 py-2 text-sm font-medium {{ $alertType === 'danger' ? 'bg-red-100 text-red-800 hover:bg-red-200' : 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' }}">
                            Dismiss
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif