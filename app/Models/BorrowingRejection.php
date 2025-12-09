<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BorrowingRejection extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrowing_id',
        'alasan',
    ];

    protected $table = 'borrowing_rejections';

    /**
     * Get the borrowing that was rejected.
     */
    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class, 'borrowing_id');
    }
}