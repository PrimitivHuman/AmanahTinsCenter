<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@amanahtins.id',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'admin@amanahtins.id',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'token',
                'user' => ['id', 'name', 'email'],
            ]);
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        User::factory()->create([
            'email' => 'admin@amanahtins.id',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'admin@amanahtins.id',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_login_is_rate_limited_after_five_attempts(): void
    {
        User::factory()->create([
            'email' => 'admin@amanahtins.id',
            'password' => Hash::make('password123'),
        ]);

        // Attempt 1 through 5 fail
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/auth/login', [
                'email' => 'admin@amanahtins.id',
                'password' => 'wrongpassword',
            ]);
        }

        // 6th attempt must be throttled with 429
        $response = $this->postJson('/api/auth/login', [
            'email' => 'admin@amanahtins.id',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(429)
            ->assertJsonFragment([
                'message' => 'Terlalu banyak percobaan masuk yang gagal. Silakan tunggu 1 menit sebelum mencoba lagi demi keamanan akun Anda.',
            ]);
    }

    public function test_authenticated_user_can_get_profile_and_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@amanahtins.id',
            'password' => Hash::make('password123'),
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        // Test GET /api/auth/me
        $meResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/auth/me');

        $meResponse->assertStatus(200)
            ->assertJsonPath('user.email', 'admin@amanahtins.id');

        // Test POST /api/auth/logout
        $logoutResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/auth/logout');

        $logoutResponse->assertStatus(200)
            ->assertJsonFragment(['message' => 'Berhasil logout']);

        // Token should now be deleted
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}
