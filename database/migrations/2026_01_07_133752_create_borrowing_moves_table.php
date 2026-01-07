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
        Schema::create('borrowing_moves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')->constrained('borrowings')->cascadeOnDelete();
            $table->foreignId('old_asset_id')->constrained('assets')->cascadeOnDelete();
            $table->foreignId('new_asset_id')->constrained('assets')->cascadeOnDelete();
            $table->text('alasan_pemindahan');
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('moved_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing_moves');
    }
};
