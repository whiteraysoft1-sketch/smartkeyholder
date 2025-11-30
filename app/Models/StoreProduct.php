<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class StoreProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'price',
        'original_price',
        'image',
        'gallery',
        'is_available',
        'is_featured',
        'sort_order',
        'sku',
        'stock_quantity',
        'track_stock',
        'variants',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'original_price' => 'decimal:2',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'track_stock' => 'boolean',
            'gallery' => 'array',
            'variants' => 'array',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(StoreCategory::class, 'category_id');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            $path = $this->image;
            if (strpos($path, 'store_products/') !== 0) {
                $path = 'store_products/' . ltrim($path, '/');
            }
            return Storage::disk('public')->url($path);
        }
        return asset('images/default-product.png');
    }

    public function getFormattedPriceAttribute()
    {
        $symbol = $this->user->profile->currency_symbol ?? '$';
        return $symbol . number_format($this->price, 2);
    }

    public function getFormattedOriginalPriceAttribute()
    {
        if ($this->original_price) {
            $symbol = $this->user->profile->currency_symbol ?? '$';
            return $symbol . number_format($this->original_price, 2);
        }
        return null;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    public function getStockStatusAttribute()
    {
        if (!$this->track_stock) {
            return 'in_stock';
        }
        
        if ($this->stock_quantity <= 0) {
            return 'out_of_stock';
        } elseif ($this->stock_quantity <= 5) {
            return 'low_stock';
        }
        
        return 'in_stock';
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where(function($q) {
            $q->where('track_stock', false)
              ->orWhere('stock_quantity', '>', 0);
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}