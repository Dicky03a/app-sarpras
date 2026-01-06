<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Asset;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BorrowingConcurrencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_concurrent_borrowing_requests_allowed_for_pending_status()
    {
        // Create a test asset
        $asset = Asset::factory()->create([
            'status' => 'tersedia' // available
        ]);

        // Create two different users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create first borrowing request (pending)
        $borrowing1 = Borrowing::create([
            'user_id' => $user1->id,
            'asset_id' => $asset->id,
            'tanggal_mulai' => now()->addDays(1),
            'tanggal_selesai' => now()->addDays(3),
            'keperluan' => 'Test keperluan 1',
            'lampiran_bukti' => 'borrowing_documents/test1.pdf',
            'status' => 'pending',
        ]);

        // Verify the first borrowing was created successfully
        $this->assertNotNull($borrowing1);
        $this->assertEquals('pending', $borrowing1->status);

        // Create second borrowing request for the same asset and time period
        $borrowing2 = Borrowing::create([
            'user_id' => $user2->id,
            'asset_id' => $asset->id,
            'tanggal_mulai' => now()->addDays(1),
            'tanggal_selesai' => now()->addDays(3),
            'keperluan' => 'Test keperluan 2',
            'lampiran_bukti' => 'borrowing_documents/test2.pdf',
            'status' => 'pending',
        ]);

        // Both requests should be created successfully since asset status is still 'tersedia'
        // and the first request is only 'pending', not yet 'dipinjam'
        $this->assertNotNull($borrowing2);
        $this->assertEquals('pending', $borrowing2->status);

        // Verify that both borrowings exist for the same asset
        $borrowingsForAsset = Borrowing::where('asset_id', $asset->id)->get();
        $this->assertCount(2, $borrowingsForAsset);

        // Verify that only 'dipinjam' status blocks new requests, not 'pending' or 'disetujui'
        $existingBorrowing = Borrowing::where('asset_id', $asset->id)
                                    ->where('status', 'dipinjam')  // Only check for active borrowings
                                    ->where(function ($query) {
                                        $query->whereBetween('tanggal_mulai', [now()->addDays(1), now()->addDays(3)])
                                              ->orWhereBetween('tanggal_selesai', [now()->addDays(1), now()->addDays(3)]);
                                    })
                                    ->first();

        // Should be null since there are only pending requests, not active borrowings
        $this->assertNull($existingBorrowing);
    }

    public function test_borrowing_request_creation_with_available_asset()
    {
        // Create a test asset
        $asset = Asset::factory()->create([
            'status' => 'tersedia' // available
        ]);

        // Create a user
        $user = User::factory()->create();

        // Test that borrowing request can be created when asset is available
        $borrowing = Borrowing::create([
            'user_id' => $user->id,
            'asset_id' => $asset->id,
            'tanggal_mulai' => now()->addDays(1),
            'tanggal_selesai' => now()->addDays(3),
            'keperluan' => 'Test keperluan',
            'lampiran_bukti' => 'borrowing_documents/test3.pdf',
            'status' => 'pending',
        ]);

        $this->assertNotNull($borrowing);
        $this->assertEquals('pending', $borrowing->status);
        $this->assertEquals($asset->id, $borrowing->asset_id);
    }

    public function test_borrowing_request_blocked_when_asset_actively_borrowed()
    {
        // Create a test asset
        $asset = Asset::factory()->create([
            'status' => 'tersedia' // available initially
        ]);

        // Create a user
        $user = User::factory()->create();

        // Create an existing active borrowing
        $existingActiveBorrowing = Borrowing::create([
            'user_id' => $user->id,
            'asset_id' => $asset->id,
            'tanggal_mulai' => now()->addDays(1),
            'tanggal_selesai' => now()->addDays(3),
            'keperluan' => 'Test keperluan',
            'lampiran_bukti' => 'borrowing_documents/test4.pdf',
            'status' => 'dipinjam', // actively borrowed
        ]);

        // Update asset status to reflect it's borrowed
        $asset->update(['status' => 'dipinjam']);

        // Check if new request would be blocked by looking for active borrowings
        // The existing borrowing is from now+1 to now+3 days, so a request for now+1 to now+2 should conflict
        $conflictingBorrowing = Borrowing::where('asset_id', $asset->id)
                                       ->where('status', 'dipinjam')
                                       ->where(function ($query) {
                                           $query->whereBetween('tanggal_mulai', [now()->addDays(1), now()->addDays(2)])
                                                 ->orWhereBetween('tanggal_selesai', [now()->addDays(1), now()->addDays(2)])
                                                 ->orWhere(function ($q) {
                                                     $q->where('tanggal_mulai', '<=', now()->addDays(1))
                                                       ->where('tanggal_selesai', '>=', now()->addDays(2));
                                                 });
                                       })
                                       ->first();

        // Should find the conflicting active borrowing
        $this->assertNotNull($conflictingBorrowing);
        $this->assertEquals('dipinjam', $conflictingBorrowing->status);
    }
}