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
        User::factory()->create(['username' => 'user1']);
        User::factory()->create(['username' => 'user2']);

        $token = $this->createAdminToken();

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

    public function test_users_can_be_created(): void
    {
        $token = $this->createAdminToken();

        $response = $this->postJSON('/users', [
            'username' => 'new_user',
            'password' => 'wawawawawa',
            'role' => 'manager',
        ], ['Authorization' => "Bearer {$token}"]);

        $response->assertCreated();
        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('user', fn (AssertableJson $json) =>
                    $json->whereType('id', 'integer')
                         ->whereType('username', 'string')
                         ->missing('password')
                         ->etc()
                )
            );
    }

    public function test_users_can_be_updated(): void
    {
        $user = User::factory()->create(['username' => 'user1']);
        $token = $this->createAdminToken();

        $response = $this->putJSON("/users/{$user->id}", [
            'role' => 'manager'
        ], ['Authorization' => "Bearer {$token}"]);

        $response->assertNoContent();

        $user = User::where('id', $user->id)->first();
        $this->assertTrue($user->role === 'manager');
    }
}
