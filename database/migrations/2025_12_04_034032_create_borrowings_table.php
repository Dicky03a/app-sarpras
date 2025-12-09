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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->text('keperluan');
            $table->string('lampiran_bukti');

            $table->enum('status', [
                'pending',
                'disetujui',
                'ditolak',
                'dipinjam',
                'selesai'
            ])->default('pending');

            // admin yang memproses
            $table->foreignId('admin_id')->nullable()
                ->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
