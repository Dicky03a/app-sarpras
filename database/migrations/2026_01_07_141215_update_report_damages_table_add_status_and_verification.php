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
        Schema::table('report_damages', function (Blueprint $table) {
            // Add photo field for asset damage
            $table->string('foto_kerusakan')->nullable();

            // Add status field (menunggu verifikasi, selesai)
            $table->enum('status', ['menunggu_verifikasi', 'selesai'])->default('menunggu_verifikasi');

            // Add fields for admin verification
            $table->enum('kondisi_setelah_verifikasi', ['baik', 'rusak_ringan', 'rusak_berat'])->nullable();
            $table->text('pesan_tindak_lanjut')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('tanggal_verifikasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_damages', function (Blueprint $table) {
            $table->dropColumn([
                'foto_kerusakan',
                'status',
                'kondisi_setelah_verifikasi',
                'pesan_tindak_lanjut',
                'admin_id',
                'tanggal_verifikasi'
            ]);
        });
    }
};
