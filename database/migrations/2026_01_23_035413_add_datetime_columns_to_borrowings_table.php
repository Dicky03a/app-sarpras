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
        Schema::table('borrowings', function (Blueprint $table) {
            // Add datetime columns for start and end times
            $table->dateTime('start_datetime')->nullable();
            $table->dateTime('end_datetime')->nullable();
        });

        // Data migration: populate the new datetime columns from existing date columns
        // This will set the start_datetime to the start date at 00:00:00
        // and end_datetime to the end date at 23:59:59
        \DB::statement('UPDATE borrowings SET start_datetime = CONCAT(tanggal_mulai, " 00:00:00"), end_datetime = CONCAT(tanggal_selesai, " 23:59:59") WHERE tanggal_mulai IS NOT NULL AND tanggal_selesai IS NOT NULL');

        // Make the new columns non-nullable after populating
        \DB::statement('ALTER TABLE borrowings MODIFY start_datetime DATETIME NOT NULL');
        \DB::statement('ALTER TABLE borrowings MODIFY end_datetime DATETIME NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn(['start_datetime', 'end_datetime']);
        });
    }
};
