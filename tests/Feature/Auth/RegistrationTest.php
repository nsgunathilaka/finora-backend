<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Nihal',
            'email' => 'test@example.com',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Registration successful.',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Nihal',
            'email' => 'test@example.com',
        ]);
    }

    public function test_email_is_required(): void
{
    $response = $this->postJson('/api/auth/register', [
        'name' => 'Nihal',
        'password' => 'Password@123',
        'password_confirmation' => 'Password@123',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
}

public function test_email_must_be_valid(): void
{
    $response = $this->postJson('/api/auth/register', [
        'name' => 'Nihal',
        'email' => 'invalid-email',
        'password' => 'Password@123',
        'password_confirmation' => 'Password@123',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
}

public function test_email_must_be_unique(): void
{
    $this->postJson('/api/auth/register', [
        'name' => 'Nihal',
        'email' => 'test@example.com',
        'password' => 'Password@123',
        'password_confirmation' => 'Password@123',
    ]);

    $response = $this->postJson('/api/auth/register', [
        'name' => 'Another User',
        'email' => 'test@example.com',
        'password' => 'Password@123',
        'password_confirmation' => 'Password@123',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
}

public function test_password_confirmation_must_match(): void
{
    $response = $this->postJson('/api/auth/register', [
        'name' => 'Nihal',
        'email' => 'test@example.com',
        'password' => 'Password@123',
        'password_confirmation' => 'DifferentPassword@123',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['password']);
}

public function test_password_is_hashed(): void
{
    $this->postJson('/api/auth/register', [
        'name' => 'Nihal',
        'email' => 'test@example.com',
        'password' => 'Password@123',
        'password_confirmation' => 'Password@123',
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);

    $user = \App\Models\User::where(
        'email',
        'test@example.com'
    )->first();

    $this->assertNotEquals(
        'Password@123',
        $user->password
    );

    $this->assertTrue(
        \Illuminate\Support\Facades\Hash::check(
            'Password@123',
            $user->password
        )
    );
}
}