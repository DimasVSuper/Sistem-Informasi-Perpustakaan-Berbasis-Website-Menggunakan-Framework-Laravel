<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordReset extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'password_resets';

    protected $fillable = [
        'user_id',
        'token',
        'created_at',
        'expires_at',
        'used_at'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'expires_at' => 'datetime',
            'used_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns this password reset token
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if token is still valid (not expired and not used)
     */
    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->isUsed();
    }

    /**
     * Check if token has expired
     */
    public function isExpired(): bool
    {
                return $this->expires_at !== null && now()->isAfter($this->expires_at);
    }

    /**
     * Check if token has been used
     */
    public function isUsed(): bool
    {
        return $this->used_at !== null;
    }

    /**
     * Mark token as used
     */
    public function markAsUsed(): void
    {
                $updated = $this->update(['used_at' => now()]);
        if ($updated === 0) {
            throw new \Exception('Failed to mark password reset token as used.');
        }
    }
}
