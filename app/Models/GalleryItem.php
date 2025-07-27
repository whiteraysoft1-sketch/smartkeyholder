<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image_path',
        'image_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function getFullImageUrlAttribute()
    {
        // First try the stored image_url
        if ($this->image_url) {
            return $this->image_url;
        }
        
        // Then try to generate from image_path
        if ($this->image_path) {
            return Storage::disk('public')->url($this->image_path);
        }
        
        // Return a default placeholder if nothing is available
        return asset('images/placeholder.jpg');
    }

    public function getImageUrlAttribute($value)
    {
        // If image_url is not set, generate it from image_path
        if (!$value && $this->image_path) {
            return Storage::disk('public')->url($this->image_path);
        }
        
        return $value;
    }
}
