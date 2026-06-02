<?php

namespace App\Models;

use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    /** @use HasFactory<CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'otp',
        'otp_expires_at',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'otp_expires_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Generate a random 6-digit OTP.
     */
    public static function generateOtp(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Check if the given OTP is valid and not expired.
     */
    /**
     * @return HasMany<Order, $this>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isValidOtp(string $otp): bool
    {
        if ($this->otp !== $otp) {
            return false;
        }

        if (! $this->otp_expires_at) {
            return false;
        }

        return now()->lessThanOrEqualTo($this->otp_expires_at);
    }
}
