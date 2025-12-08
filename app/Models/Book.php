<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'isbn',
        'publisher',
        'published_year',
        'total_copies',
        'available_copies',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'total_copies' => 'integer',
            'available_copies' => 'integer',
            'published_year' => 'integer',
        ];
    }

    /**
     * Get the category this book belongs to
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all loans for this book
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Check if book is available
     */
    public function isAvailable(): bool
    {
        return $this->available_copies > 0;
    }

    /**
     * Get number of copies on loan
     */
    public function getLoansCount(): int
    {
        return $this->total_copies - $this->available_copies;
    }
}
