<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'asset_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'keperluan',
        'lampiran_bukti',
        'status',
        'admin_id',
    ];

    protected $table = 'borrowings';
    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that made the borrowing request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the asset that is being borrowed.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    /**
     * Get the admin who processed the borrowing request.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the rejection record for this borrowing (if any).
     */
    public function rejection(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(BorrowingRejection::class, 'borrowing_id');
    }

    /**
     * Get the move records for this borrowing (if any).
     */
    public function moves(): HasMany
    {
        return $this->hasMany(BorrowingMove::class, 'borrowing_id');
    }
}