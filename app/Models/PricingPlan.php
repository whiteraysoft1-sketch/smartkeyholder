<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'billing_cycle',
        'description',
        'features',
        'is_active',
        'is_popular',
        'is_free_trial',
        'trial_days',
        'sort_order',
        'button_text',
        'button_color',
        'badge_text',
        'badge_color',
        'max_social_links',
        'max_gallery_images',
        'has_analytics',
        'has_custom_themes',
        'has_priority_support',
        'has_qr_customization',
        'has_whatsapp_store'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
        'is_free_trial' => 'boolean',
        'has_analytics' => 'boolean',
        'has_custom_themes' => 'boolean',
        'has_priority_support' => 'boolean',
        'has_qr_customization' => 'boolean',
        'has_whatsapp_store' => 'boolean',
        'price' => 'decimal:2'
    ];

    /**
     * Get active pricing plans ordered by sort_order
     */
    public static function active()
    {
        return static::where('is_active', true)->orderBy('sort_order')->get();
    }

    /**
     * Get the popular plan
     */
    public static function popular()
    {
        return static::where('is_popular', true)->where('is_active', true)->first();
    }

    /**
     * Get the free trial plan
     */
    public static function freeTrial()
    {
        return static::where('is_free_trial', true)->where('is_active', true)->first();
    }

    /**
     * Check if plan allows WhatsApp store
     */
    public function allowsWhatsAppStore()
    {
        return $this->has_whatsapp_store || $this->is_free_trial;
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        if ($this->is_free_trial || $this->price == 0) {
            $symbol = setting('currency_symbol', '$');
            $position = setting('currency_position', 'before');
            
            if ($position === 'after') {
                return '0' . $symbol;
            } else {
                return $symbol . '0';
            }
        }
        
        return format_currency($this->price);
    }

    /**
     * Get billing cycle text
     */
    public function getBillingCycleTextAttribute()
    {
        if ($this->is_free_trial) {
            return '/' . $this->trial_days . ' days';
        }
        
        return '/' . $this->billing_cycle;
    }
}