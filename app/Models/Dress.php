<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dress extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'rental_price_per_day',
        'deposit_fee',
        'size',
        'color',
        'chest_size',
        'waist_size',
        'length',
        'fabric',
        'image',
        'gallery',
        'stock',
        'is_featured',
        'rating',
        'status',
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'rental_price_per_day' => 'decimal:2',
        'deposit_fee' => 'decimal:2',
        'rating' => 'float',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp '.number_format((float) $this->rental_price_per_day, 0, ',', '.');
    }

    public function getFormattedDepositAttribute(): string
    {
        return 'Rp '.number_format((float) $this->deposit_fee, 0, ',', '.');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        if ($this->image) {
            return asset('storage/'.$this->image);
        }

        return 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=800&auto=format&fit=crop';
    }
}
