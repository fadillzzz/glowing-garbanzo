<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createAdminToken(): string
    {
        $admin = User::factory()->create(['username' => 'admin']);
        return $admin->createToken('testing')->plainTextToken;
    }

    protected function createUserWithToken(): User
    {
        $user = User::factory()->create(['username' => 'user1', 'role' => 'user']);
        $user->withAccessToken($user->createToken('testing'));
        return $user;
    }
}
