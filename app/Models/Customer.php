<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
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
