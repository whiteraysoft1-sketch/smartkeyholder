<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'url',
        'user_id',
        'is_claimed',
        'claimed_at',
        'is_active',
        'scan_count',
        'last_scanned_at',
    ];

    protected function casts(): array
    {
        return [
            'is_claimed' => 'boolean',
            'is_active' => 'boolean',
            'claimed_at' => 'datetime',
            'last_scanned_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($qrCode) {
            if (empty($qrCode->uuid)) {
                $qrCode->uuid = Str::uuid();
            }
            if (empty($qrCode->code)) {
                $qrCode->code = 'WS_' . strtoupper(Str::random(8));
            }
            if (empty($qrCode->url)) {
                $qrCode->url = route('qr.view', $qrCode->uuid);
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function claim(User $user)
    {
        $this->update([
            'user_id' => $user->id,
            'is_claimed' => true,
            'claimed_at' => now(),
        ]);
    }

    public function incrementScanCount()
    {
        $this->increment('scan_count');
        $this->update(['last_scanned_at' => now()]);
    }

    public function getQrCodeImageAttribute()
    {
        return \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($this->url);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    // Scope for finding by UUID
    public function scopeByUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    // Check if QR code is available for claiming
    public function isAvailableForClaim()
    {
        return $this->is_active && !$this->is_claimed;
    }
}
