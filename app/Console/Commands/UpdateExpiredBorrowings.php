<?php

namespace App\Console\Commands;

use App\Models\Borrowing;
use App\Models\Asset;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateExpiredBorrowings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-expired-borrowings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status of expired borrowings to completed and asset status to available';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired borrowings...');

        // Find all borrowings that have ended (end_datetime is in the past)
        $expiredBorrowings = Borrowing::where('end_datetime', '<', now())
            ->whereIn('status', ['pending', 'disetujui', 'dipinjam'])
            ->get();

        $updatedCount = 0;

        DB::beginTransaction();

        try {
            foreach ($expiredBorrowings as $borrowing) {
                // Only update status if it's not already completed or rejected
                if (in_array($borrowing->status, ['pending', 'disetujui', 'dipinjam'])) {
                    // Update borrowing status to completed
                    $borrowing->update(['status' => 'selesai']);

                    // Update asset status to available
                    $borrowing->asset->update(['status' => 'tersedia']);

                    $updatedCount++;

                    $this->info("Updated borrowing #{$borrowing->id} for asset '{$borrowing->asset->name}' to completed status");
                }
            }

            DB::commit();

            $this->info("Successfully updated {$updatedCount} expired borrowings.");
        } catch (\Exception $e) {
            DB::rollback();
            $this->error("Error updating expired borrowings: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
