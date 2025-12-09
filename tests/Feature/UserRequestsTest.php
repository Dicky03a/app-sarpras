<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Borrowing;
use App\Models\Asset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRequestsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_requests_page(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/user/requests');

        $response->assertStatus(200);
        $response->assertViewIs('user.requests');
    }
    
    public function test_user_sees_only_their_requests(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $asset = Asset::factory()->create();
        
        // Create borrowing requests for user1
        $borrowing1 = Borrowing::factory()->create([
            'user_id' => $user1->id,
            'asset_id' => $asset->id
        ]);
        
        // Create borrowing request for user2
        $borrowing2 = Borrowing::factory()->create([
            'user_id' => $user2->id,
            'asset_id' => $asset->id
        ]);
        
        // When user1 accesses their requests page
        $response = $this->actingAs($user1)->get('/user/requests');
        
        // They should only see their own request
        $response->assertStatus(200);
        
        $response->assertViewHas('borrowingRequests', function ($borrowingRequests) use ($borrowing1, $borrowing2) {
            // Should contain the borrowing for user1
            return $borrowingRequests->contains('id', $borrowing1->id) && 
                   !$borrowingRequests->contains('id', $borrowing2->id);
        });
    }
}