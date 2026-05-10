<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * Whether this account already has a mobile number (column or OTP placeholder email).
     */
    public function accountHasUsablePhone(): bool
    {
        $this->syncPhoneFromPlaceholderEmailIfMissing();

        return $this->normalizedPhoneDigitCount() >= 10;
    }

    /**
     * OTP sign-ups use {10-digit}@rubista.com — sync that into phone when the column is empty.
     */
    public function syncPhoneFromPlaceholderEmailIfMissing(): void
    {
        if ($this->normalizedPhoneDigitCount() >= 10) {
            return;
        }

        $fromEmail = $this->extractTenDigitPhoneFromRubistaEmail();
        if ($fromEmail !== null) {
            $this->forceFill(['phone' => $fromEmail])->saveQuietly();
        }
    }

    public function normalizedPhoneDigitCount(): int
    {
        return strlen(preg_replace('/\D/', '', (string) ($this->phone ?? '')));
    }

    /**
     * @return non-empty-string|null
     */
    public function extractTenDigitPhoneFromRubistaEmail(): ?string
    {
        $email = strtolower(trim((string) ($this->email ?? '')));
        if ($email === '' || ! str_ends_with($email, '@rubista.com')) {
            return null;
        }

        $local = strstr($email, '@', true);
        if ($local === false || strlen($local) !== 10 || ! ctype_digit($local)) {
            return null;
        }

        return $local;
    }

    /**
     * Relationship with orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relationship with reviews
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
