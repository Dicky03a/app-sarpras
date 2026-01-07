<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BorrowingMove extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrowing_id',
        'old_asset_id',
        'new_asset_id',
        'alasan_pemindahan',
        'admin_id',
        'moved_at',
    ];

    protected $table = 'borrowing_moves';
    protected $casts = [
        'moved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the borrowing that was moved.
     */
    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class, 'borrowing_id');
    }

    /**
     * Get the old asset that was borrowed.
     */
    public function oldAsset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'old_asset_id');
    }

    /**
     * Get the new asset that is now borrowed.
     */
    public function newAsset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'new_asset_id');
    }

    /**
     * Get the admin who performed the move.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
