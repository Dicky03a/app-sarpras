<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    protected $fillable = ['name'];

    protected $table = 'asset_categories';
}
