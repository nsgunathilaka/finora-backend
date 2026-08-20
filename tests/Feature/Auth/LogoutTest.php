<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/auth/logout');

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logout successful.',
            ]);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_unauthenticated_user_cannot_logout(): void
    {
        $response = $this->postJson('/api/auth/logout');

        $response
            ->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_logout_revokes_current_token(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('finora-api');

        $plainTextToken = $token->plainTextToken;
        $tokenId = $token->accessToken->id;

        $this->withToken($plainTextToken)
            ->postJson('/api/auth/logout')
            ->assertStatus(200);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $tokenId,
        ]);

        \Illuminate\Support\Facades\Auth::forgetGuards();

        $this->withToken($plainTextToken)
            ->getJson('/api/auth/me')
            ->assertStatus(401);
    }
}
