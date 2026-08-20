<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'nihal@example.com',
            'password' => 'Password@123',
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'nihal@example.com',
            'password' => 'Password@123',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Login successful.',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user',
                    'token',
                ],
            ]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
            'name' => 'finora-api',
        ]);
    }

    public function test_login_fails_with_invalid_password(): void
    {
        User::factory()->create([
            'email' => 'nihal@example.com',
            'password' => 'Password@123',
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'nihal@example.com',
            'password' => 'WrongPassword@123',
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid credentials.',
            ]);
    }

    public function test_login_fails_with_unknown_email(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'unknown@example.com',
            'password' => 'Password@123',
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid credentials.',
            ]);
    }

    public function test_email_is_required(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'password' => 'Password@123',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_password_is_required(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'nihal@example.com',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_email_must_be_valid(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'invalid-email',
            'password' => 'Password@123',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
