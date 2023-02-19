<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_be_retrieved(): void
    {
        $admin = User::factory()->create(['username' => 'admin']);
        User::factory()->create(['username' => 'user1']);
        User::factory()->create(['username' => 'user2']);
        $token = $admin->createToken('testing')->plainTextToken;

        $response = $this->get('/users', ['Authorization' => "Bearer {$token}"]);

        $response->assertOk();
        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('users', 3, fn (AssertableJson $json) =>
                    $json->whereType('id', 'integer')
                         ->whereType('username', 'string')
                         ->missing('password')
                         ->etc()
                )
            );
    }
}
