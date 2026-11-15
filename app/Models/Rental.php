<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_code',
        'user_id',
        'dress_id',
        'start_date',
        'end_date',
        'total_days',
        'rental_price',
        'deposit_fee',
        'total_price',
        'status',
        'payment_method',
        'payment_proof',
        'identity_photo',
        'shipping_method',
        'shipping_address',
        'notes',
        'return_tracking_number',
        'paid_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'paid_at' => 'datetime',
        'rental_price' => 'decimal:2',
        'deposit_fee' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dress(): BelongsTo
    {
        return $this->belongsTo(Dress::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function getIdentityPhotoUrlAttribute(): ?string
    {
        if (!empty($this->identity_photo)) {
            return $this->identity_photo;
        }
        if (preg_match('/\[ID_PHOTO:\s*([^\]]+)\]/', $this->notes ?? '', $matches)) {
            return trim($matches[1]);
        }
        return null;
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        if (empty($this->payment_proof)) {
            return null;
        }
        if (str_starts_with($this->payment_proof, 'http://') || str_starts_with($this->payment_proof, 'https://')) {
            return $this->payment_proof;
        }
        if ($this->payment_proof === 'simulated_instant_payment.png') {
            return null;
        }
        return asset('storage/' . $this->payment_proof);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending_payment' => 'Payment Pending',
            'paid' => 'Reserved / Processing',
            'shipping' => 'In Transit / Ready for Pickup',
            'in_use' => 'Active Rental',
            'returned' => 'Returned (Under Inspection)',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending_payment' => 'bg-amber-50 text-amber-800 border-amber-200 whitespace-nowrap inline-block',
            'paid' => 'bg-rose-50 text-rose-800 border-rose-200 whitespace-nowrap inline-block',
            'shipping' => 'bg-purple-50 text-purple-800 border-purple-200 whitespace-nowrap inline-block',
            'in_use' => 'bg-pink-100 text-pink-900 border-pink-300 whitespace-nowrap inline-block',
            'returned' => 'bg-indigo-50 text-indigo-800 border-indigo-200 whitespace-nowrap inline-block',
            'completed' => 'bg-emerald-50 text-emerald-800 border-emerald-200 whitespace-nowrap inline-block',
            'cancelled' => 'bg-slate-100 text-slate-700 border-slate-200 whitespace-nowrap inline-block',
            default => 'bg-gray-50 text-gray-700 border-gray-200 whitespace-nowrap inline-block',
        };
    }
}
