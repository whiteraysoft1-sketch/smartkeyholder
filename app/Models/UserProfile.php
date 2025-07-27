<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'display_name',
        'bio',
        'contact',
        'profile_image',
        'background_image',
        'phone',
        'website',
        'location',
        'profession',
        'is_public',

        'currency',
        'currency_symbol',
        'selected_template',

        'latest_inapp_message',
        'store_enabled',
        'store_name',
        'store_description',
        'store_whatsapp',
        'store_address',
        'store_hours',
        'delivery_fee',
        'minimum_order',
        'delivery_available',
        'pickup_available',
        'push_subscriptions',

        // PWA Configuration Fields
        'pwa_enabled',
        'pwa_app_name',
        'pwa_short_name',
        'pwa_description',
        'pwa_theme_color',
        'pwa_background_color',
        'pwa_icon',
        'pwa_splash_icon',
        'pwa_display_mode',
        'pwa_orientation',
        'pwa_start_url',
        'pwa_scope',
        'pwa_categories',
        'pwa_lang',
        'pwa_dir',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',

            'store_enabled' => 'boolean',
            'store_hours' => 'array',
            'delivery_fee' => 'decimal:2',
            'minimum_order' => 'decimal:2',
            'delivery_available' => 'boolean',
            'pickup_available' => 'boolean',
            'push_subscriptions' => 'array',

            // PWA Casts
            'pwa_enabled' => 'boolean',
            'pwa_categories' => 'array',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return Storage::disk('public')->url($this->profile_image);
        }
        return null;
    }

    public function getFullProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return Storage::disk('public')->url($this->profile_image);
        }
        return asset('images/default-avatar.png');
    }

    public function hasProfileImage()
    {
        return !empty($this->profile_image);
    }

    public function getBackgroundImageUrlAttribute()
    {
        if ($this->background_image) {
            return Storage::disk('public')->url($this->background_image);
        }
        return null;
    }

    public function getFullBackgroundImageUrlAttribute()
    {
        if ($this->background_image) {
            return Storage::disk('public')->url($this->background_image);
        }
        return null;
    }

    public function hasBackgroundImage()
    {
        return !empty($this->background_image);
    }

    // PWA Helper Methods
    public function getPwaIconUrlAttribute()
    {
        if ($this->pwa_icon) {
            return Storage::disk('public')->url($this->pwa_icon);
        }
        return asset('images/default-pwa-icon-192.png');
    }

    public function getPwaSplashIconUrlAttribute()
    {
        if ($this->pwa_splash_icon) {
            return Storage::disk('public')->url($this->pwa_splash_icon);
        }
        return $this->getPwaIconUrlAttribute();
    }

    public function getFullPwaIconUrlAttribute()
    {
        return $this->getPwaIconUrlAttribute();
    }

    public function hasPwaIcon()
    {
        return !empty($this->pwa_icon);
    }

    public function getPwaAppNameAttribute($value)
    {
        return $value ?: ($this->display_name ?: $this->user->name ?: 'Smart Tag');
    }

    public function getPwaShortNameAttribute($value)
    {
        if ($value) return $value;
        
        $name = $this->pwa_app_name;
        if (strlen($name) <= 12) return $name;
        
        // Generate short name from full name
        $words = explode(' ', $name);
        if (count($words) > 1) {
            $initials = '';
            foreach ($words as $word) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
            if (strlen($initials) <= 12) return $initials;
        }
        
        return substr($name, 0, 12);
    }

    public function getPwaDescriptionAttribute($value)
    {
        return $value ?: ($this->bio ?: 'Digital Profile - Smart Tag');
    }

    public static function getCurrencyOptions()
    {
        return [
            'USD' => ['symbol' => '$', 'name' => 'US Dollar'],
            'EUR' => ['symbol' => '€', 'name' => 'Euro'],
            'GBP' => ['symbol' => '£', 'name' => 'British Pound'],
            'JPY' => ['symbol' => '¥', 'name' => 'Japanese Yen'],
            'CAD' => ['symbol' => 'C$', 'name' => 'Canadian Dollar'],
            'AUD' => ['symbol' => 'A$', 'name' => 'Australian Dollar'],
            'CHF' => ['symbol' => 'CHF', 'name' => 'Swiss Franc'],
            'CNY' => ['symbol' => '¥', 'name' => 'Chinese Yuan'],
            'INR' => ['symbol' => '₹', 'name' => 'Indian Rupee'],
            'NGN' => ['symbol' => '₦', 'name' => 'Nigerian Naira'],
            'ZAR' => ['symbol' => 'R', 'name' => 'South African Rand'],
            'KES' => ['symbol' => 'KSh', 'name' => 'Kenyan Shilling'],
            'GHS' => ['symbol' => '₵', 'name' => 'Ghanaian Cedi'],
            'UGX' => ['symbol' => 'USh', 'name' => 'Ugandan Shilling'],
        ];
    }

    public static function getPwaDisplayModeOptions()
    {
        return [
            'standalone' => 'Standalone (Recommended)',
            'fullscreen' => 'Fullscreen',
            'minimal-ui' => 'Minimal UI',
            'browser' => 'Browser',
        ];
    }

    public static function getPwaOrientationOptions()
    {
        return [
            'portrait' => 'Portrait',
            'landscape' => 'Landscape',
            'any' => 'Any',
        ];
    }

    public static function getPwaCategoryOptions()
    {
        return [
            'business' => 'Business',
            'productivity' => 'Productivity',
            'social' => 'Social',
            'lifestyle' => 'Lifestyle',
            'entertainment' => 'Entertainment',
            'education' => 'Education',
            'health' => 'Health & Fitness',
            'food' => 'Food & Drink',
            'travel' => 'Travel',
            'shopping' => 'Shopping',
            'finance' => 'Finance',
            'news' => 'News',
            'photo' => 'Photo & Video',
            'music' => 'Music',
            'games' => 'Games',
            'utilities' => 'Utilities',
        ];
    }
}