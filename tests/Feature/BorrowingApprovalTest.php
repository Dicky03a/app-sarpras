<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Borrowing;
use App\Models\Asset;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BorrowingApprovalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the admin role that's required by the middleware
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'superadmin']);
    }

    public function test_asset_status_changes_to_dipinjam_when_borrowing_approved(): void
    {
        // Create an admin user
        $admin = User::factory()->create();
        $admin->assignRole('admin'); // Assign admin role

        // Create a regular user
        $user = User::factory()->create();

        // Create an asset with initial status 'tersedia'
        $asset = Asset::factory()->create(['status' => 'tersedia']);

        // Create a borrowing request
        $borrowing = Borrowing::factory()->create([
            'user_id' => $user->id,
            'asset_id' => $asset->id,
            'status' => 'pending' // Initially pending
        ]);

        // Verify initial asset status
        $this->assertEquals('tersedia', $asset->fresh()->status);

        // Approve the borrowing request
        $response = $this->actingAs($admin)->put("/borrowings/{$borrowing->id}/approve", [
            'admin_id' => $admin->id
        ]);

        // Assert the response redirects
        $response->assertRedirect();

        // Refresh the borrowing and asset to get updated data
        $borrowing->refresh();
        $asset->refresh();

        // Check that borrowing status is now 'disetujui'
        $this->assertEquals('disetujui', $borrowing->status);

        // Check that asset status is now 'dipinjam' as required
        $this->assertEquals('dipinjam', $asset->status);
    }

    public function test_asset_status_returns_to_tersedia_when_borrowing_marked_as_returned(): void
    {
        // Create an admin user
        $admin = User::factory()->create();
        $admin->assignRole('admin'); // Assign admin role

        // Create a regular user
        $user = User::factory()->create();

        // Create an asset
        $asset = Asset::factory()->create(['status' => 'tersedia']);

        // Create a borrowing request that is already approved
        $borrowing = Borrowing::factory()->create([
            'user_id' => $user->id,
            'asset_id' => $asset->id,
            'status' => 'disetujui' // Already approved
        ]);

        // The asset status should now be 'dipinjam' due to our change in approve method
        $this->assertEquals('dipinjam', $asset->fresh()->status);

        // Mark the borrowing as returned
        $response = $this->actingAs($admin)->put("/borrowings/{$borrowing->id}/mark-as-returned", [
            'admin_id' => $admin->id
        ]);

        // Assert the response redirects
        $response->assertRedirect();

        // Refresh the asset to get updated data
        $asset->refresh();

        // Check that asset status is now 'tersedia' again
        $this->assertEquals('tersedia', $asset->status);
    }
}