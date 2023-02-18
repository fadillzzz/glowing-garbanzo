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

        $response = $this->post('/tokens', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertCreated();
    }
}
