<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable();
        });

        // Generate slugs for existing assets
        $assets = \App\Models\Asset::all();
        foreach ($assets as $asset) {
            $asset->slug = \Illuminate\Support\Str::slug($asset->name);
            $asset->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
