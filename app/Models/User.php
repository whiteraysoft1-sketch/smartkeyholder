<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'trial_ends_at',
        'is_subscribed',
        'subscription_ends_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'trial_ends_at' => 'datetime',
            'subscription_ends_at' => 'datetime',
            'is_admin' => 'boolean',
            'is_subscribed' => 'boolean',
        ];
    }

    // Relationships
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function qrCode()
    {
        return $this->hasOne(QrCode::class);
    }

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class)->orderBy('sort_order');
    }

    public function galleryItems()
    {
        return $this->hasMany(GalleryItem::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active')->latest();
    }

    // Helper methods
    public function hasActiveSubscription()
    {
        return $this->is_subscribed && $this->subscription_ends_at && $this->subscription_ends_at->isFuture();
    }

    public function isOnTrial()
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture() && !$this->is_subscribed;
    }

    public function canAccessDashboard()
    {
        return $this->hasActiveSubscription() || $this->isOnTrial();
    }

    // Store relationships
    public function storeCategories()
    {
        return $this->hasMany(StoreCategory::class)->ordered();
    }

    public function storeProducts()
    {
        return $this->hasMany(StoreProduct::class);
    }

    public function storeOrders()
    {
        return $this->hasMany(StoreOrder::class)->recent();
    }

    public function availableProducts()
    {
        return $this->hasMany(StoreProduct::class)->available()->inStock()->ordered();
    }

    public function featuredProducts()
    {
        return $this->hasMany(StoreProduct::class)->featured()->available()->inStock()->ordered();
    }

    /**
     * Check if user can access WhatsApp store
     */
    public function canAccessWhatsAppStore()
    {
        // If user is on trial, they can access WhatsApp store
        if ($this->isOnTrial()) {
            return true;
        }

        // If user has active subscription, check if their plan allows WhatsApp store
        if ($this->hasActiveSubscription() && $this->activeSubscription) {
            // You would need to add plan_slug or plan_id to subscriptions table
            // For now, we'll assume Premium plans allow WhatsApp store
            return in_array(strtolower($this->activeSubscription->plan_name), ['premium', 'free trial']);
        }

        return false;
    }

    /**
     * Get user's current pricing plan
     */
    public function getCurrentPlan()
    {
        if ($this->isOnTrial()) {
            return \App\Models\PricingPlan::freeTrial();
        }

        if ($this->hasActiveSubscription() && $this->activeSubscription) {
            // Try to get plan by ID from metadata first
            if (isset($this->activeSubscription->metadata['plan_id'])) {
                $plan = \App\Models\PricingPlan::find($this->activeSubscription->metadata['plan_id']);
                if ($plan) {
                    return $plan;
                }
            }
            
            // Fallback to plan name
            return \App\Models\PricingPlan::where('name', $this->activeSubscription->plan_name)->first();
        }

        return null;
    }

    /**
     * Get user's subscription status for display
     */
    public function getSubscriptionStatusAttribute()
    {
        if ($this->isOnTrial()) {
            $daysLeft = now()->diffInDays($this->trial_ends_at, false);
            return [
                'type' => 'trial',
                'status' => 'active',
                'plan_name' => 'Free Trial',
                'days_left' => $daysLeft,
                'expires_at' => $this->trial_ends_at,
                'message' => $daysLeft > 0 ? "{$daysLeft} days left" : 'Expires today'
            ];
        }

        if ($this->hasActiveSubscription()) {
            $daysLeft = now()->diffInDays($this->subscription_ends_at, false);
            return [
                'type' => 'subscription',
                'status' => 'active',
                'plan_name' => $this->activeSubscription->plan_name,
                'days_left' => $daysLeft,
                'expires_at' => $this->subscription_ends_at,
                'message' => $daysLeft > 0 ? "{$daysLeft} days left" : 'Expires today'
            ];
        }

        return [
            'type' => 'none',
            'status' => 'expired',
            'plan_name' => null,
            'days_left' => 0,
            'expires_at' => null,
            'message' => 'No active subscription'
        ];
    }
}