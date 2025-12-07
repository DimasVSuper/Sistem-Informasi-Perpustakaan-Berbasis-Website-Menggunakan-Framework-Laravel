<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'daily_rate',
        'max_fine',
    ];

    protected function casts(): array
    {
        return [
            'daily_rate' => 'decimal:2',
            'max_fine' => 'decimal:2',
        ];
    }

    /**
     * Get the current fine configuration
     */
    public static function getCurrent(): self
    {
        return self::first() ?? self::create([
            'daily_rate' => 5000,
            'max_fine' => 500000,
        ]);
    }

    /**
     * Calculate fine for overdue days
     */
    public function calculateFine(int $overdueDays): float
    {
        $fine = $this->daily_rate * $overdueDays;
        
        if ($this->max_fine && $fine > $this->max_fine) {
            return $this->max_fine;
        }

        return $fine;
    }
}
