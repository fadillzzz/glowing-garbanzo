<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_create_token(): void
    {
        $user = User::factory()->create();

        $response = $this->postJSON('/tokens', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertCreated();
        $response->assertJsonStructure(['token']);
    }

    public function test_auth_wrong_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->postJSON('/tokens', [
            'username' => $user->username,
            'password' => 'asdfasd',
        ]);

        $response->assertUnauthorized();
    }
}
