<?php

namespace App\Models;

use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'avatar',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasVerifiedEmail(): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return ! is_null($this->email_verified_at);
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function generateEmailOtp(): string
    {
        $seed = $this->id.'|'.$this->email.'|'.config('app.key').'|'.date('YmdH');

        return str_pad((string) (abs(crc32($seed)) % 1000000), 6, '0', STR_PAD_LEFT);
    }

    public function isValidEmailOtp(string $code): bool
    {
        $code = trim($code);
        if (strlen($code) !== 6 || ! ctype_digit($code)) {
            return false;
        }

        // Cek toleransi kode untuk jam sekarang, 1 jam lalu, dan 2 jam lalu (toleransi 2 jam)
        for ($i = 0; $i <= 2; $i++) {
            $timestamp = strtotime("-{$i} hour");
            $seed = $this->id.'|'.$this->email.'|'.config('app.key').'|'.date('YmdH', $timestamp);
            $expected = str_pad((string) (abs(crc32($seed)) % 1000000), 6, '0', STR_PAD_LEFT);
            if (hash_equals($expected, $code)) {
                return true;
            }
        }

        return false;
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
