<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MeTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_me(): void
    {
        $user = User::factory()->create([
            'name' => 'Nihal',
            'email' => 'nihal@example.com',
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/auth/me');

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Authenticated user retrieved successfully.',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => 'Nihal',
                        'email' => 'nihal@example.com',
                    ],
                ],
            ]);
    }

    public function test_unauthenticated_user_cannot_access_me(): void
    {
        $response = $this->getJson('/api/auth/me');

        $response
            ->assertStatus(401);
    }
}
