<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Asset extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'kode_aset',
        'lokasi',
        'kondisi',
        'deskripsi',
        'status',
        'slug',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $table = 'assets';

    /**
     * Get the category that owns the asset.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }

    /**
     * Generate a unique asset code and slug before saving.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($asset) {
            $asset->kode_aset = static::generateUniqueAssetCode();
            $asset->slug = static::generateUniqueSlug($asset->name);
        });

        static::updating(function ($asset) {
            if ($asset->isDirty('name')) {
                $asset->slug = static::generateUniqueSlug($asset->name);
            }
        });
    }

    /**
     * Generate a unique asset code.
     */
    private static function generateUniqueAssetCode()
    {
        $prefix = 'A';
        $suffix = strtoupper(uniqid());

        // Ensure the generated code is unique
        do {
            $kodeAset = $prefix . $suffix;
            $existing = static::where('kode_aset', $kodeAset)->first();
            $suffix = strtoupper(uniqid());
        } while ($existing);

        return $prefix . $suffix;
    }

    /**
     * Generate a unique slug.
     */
    private static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Ensure the slug is unique
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
