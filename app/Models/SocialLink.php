<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'platform',
        'url',
        'display_name',
        'is_active',
        'sort_order',
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
    public function getPlatformIconAttribute()
    {
        $icons = [
            'facebook' => 'fab fa-facebook',
            'twitter' => 'fab fa-twitter',
            'instagram' => 'fab fa-instagram',
            'linkedin' => 'fab fa-linkedin',
            'youtube' => 'fab fa-youtube',
            'tiktok' => 'fab fa-tiktok',
            'whatsapp' => 'fab fa-whatsapp',
            'telegram' => 'fab fa-telegram',
            'website' => 'fas fa-globe',
        ];

        return $icons[$this->platform] ?? 'fas fa-link';
    }

    public function getPlatformColorAttribute()
    {
        $colors = [
            'facebook' => 'bg-blue-600 hover:bg-blue-700',
            'twitter' => 'bg-sky-500 hover:bg-sky-600',
            'instagram' => 'bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600',
            'linkedin' => 'bg-blue-700 hover:bg-blue-800',
            'youtube' => 'bg-red-600 hover:bg-red-700',
            'tiktok' => 'bg-black hover:bg-gray-800',
            'whatsapp' => 'bg-green-500 hover:bg-green-600',
            'telegram' => 'bg-blue-400 hover:bg-blue-500',
            'website' => 'bg-gray-600 hover:bg-gray-700',
        ];

        return $colors[$this->platform] ?? 'bg-gray-500 hover:bg-gray-600';
    }
}
