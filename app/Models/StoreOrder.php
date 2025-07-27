<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'items',
        'subtotal',
        'tax_amount',
        'delivery_fee',
        'total_amount',
        'currency',
        'status',
        'notes',
        'whatsapp_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'subtotal' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'delivery_fee' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'whatsapp_sent_at' => 'datetime',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getFormattedTotalAttribute()
    {
        $symbol = $this->getCurrencySymbol();
        return $symbol . number_format($this->total_amount, 2);
    }

    public function getFormattedSubtotalAttribute()
    {
        $symbol = $this->getCurrencySymbol();
        return $symbol . number_format($this->subtotal, 2);
    }

    public function getFormattedDeliveryFeeAttribute()
    {
        $symbol = $this->getCurrencySymbol();
        return $symbol . number_format($this->delivery_fee, 2);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'preparing' => 'orange',
            'ready' => 'purple',
            'delivered' => 'green',
            'cancelled' => 'red',
            default => 'gray'
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'preparing' => 'Preparing',
            'ready' => 'Ready for Pickup/Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            default => 'Unknown'
        };
    }

    public function getTotalItemsAttribute()
    {
        return collect($this->items)->sum('quantity');
    }

    // Helper methods
    private function getCurrencySymbol()
    {
        $currencies = [
            'USD' => '$', 'EUR' => '€', 'GBP' => '£', 'JPY' => '¥',
            'CAD' => 'C$', 'AUD' => 'A$', 'CHF' => 'CHF', 'CNY' => '¥',
            'INR' => '₹', 'NGN' => '₦', 'ZAR' => 'R', 'KES' => 'KSh', 'GHS' => '₵'
        ];
        
        return $currencies[$this->currency] ?? '$';
    }

    public function generateWhatsAppMessage()
    {
        $message = "🛍️ *New Order - #{$this->order_number}*\n\n";
        $message .= "👤 *Customer:* {$this->customer_name}\n";
        $message .= "📱 *Phone:* {$this->customer_phone}\n";
        
        if ($this->customer_email) {
            $message .= "📧 *Email:* {$this->customer_email}\n";
        }
        
        if ($this->customer_address) {
            $message .= "📍 *Address:* {$this->customer_address}\n";
        }
        
        $message .= "\n📦 *Items:*\n";
        
        foreach ($this->items as $item) {
            $message .= "• {$item['name']} x{$item['quantity']} - {$this->getCurrencySymbol()}" . number_format($item['price'], 2) . "\n";
            if (!empty($item['notes'])) {
                $message .= "  _{$item['notes']}_\n";
            }
        }
        
        $message .= "\n💰 *Order Summary:*\n";
        $message .= "Subtotal: {$this->formatted_subtotal}\n";
        
        if ($this->delivery_fee > 0) {
            $message .= "Delivery: {$this->formatted_delivery_fee}\n";
        }
        
        $message .= "*Total: {$this->formatted_total}*\n";
        
        if ($this->notes) {
            $message .= "\n📝 *Notes:* {$this->notes}\n";
        }
        
        $message .= "\n⏰ *Ordered:* " . $this->created_at->format('M d, Y h:i A');
        
        return $message;
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Boot method to generate order number
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'ORD-' . strtoupper(uniqid());
            }
        });
    }
}