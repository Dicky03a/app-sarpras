<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportDamage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'asset_id',
        'deskripsi_kerusakan',
        'tanggal_lapor',
        'foto_kerusakan',
        'status',
        'kondisi_setelah_verifikasi',
        'pesan_tindak_lanjut',
        'admin_id',
        'tanggal_verifikasi',
    ];

    protected $table = 'report_damages';

    protected $casts = [
        'tanggal_lapor' => 'datetime',
        'tanggal_verifikasi' => 'datetime',
        'updated_at' => 'datetime',
    ];


    /**
     * Get the user who reported the damage.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the asset that was reported as damaged.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    /**
     * Get the admin who verified the damage report.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
