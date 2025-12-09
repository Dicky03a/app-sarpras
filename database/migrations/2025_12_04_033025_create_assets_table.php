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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('asset_categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('kode_aset')->unique();
            $table->string('lokasi');
            $table->enum('kondisi', ['baik', 'rusak ringan', 'rusak berat'])->default('baik');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['tersedia', 'dipinjam', 'rusak'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
