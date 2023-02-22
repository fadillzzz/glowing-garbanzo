<?php

namespace Tests\Feature\User;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_create_posts(): void
    {
        $user = $this->createUserWithToken();
        $response = $this->postJSON("/users/{$user->id}/posts", [
            'title' => 'Blog Title',
            'body' => 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum',
        ], ['Authorization' => "Bearer {$user->currentAccessToken()->plainTextToken}"]);

        $response->assertCreated();
        $response->assertJson(['post' => [
            'title' => 'Blog Title',
            'body' => 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum',
            'user_id' => $user->id
        ]]);
    }

    public function test_users_can_retrieve_posts(): void
    {
        $user = $this->createUserWithToken();

        Post::create([
            'title' => 'Test Post',
            'body' => 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA',
            'user_id' => $user->id
        ]);

        $response = $this->getJSON("/users/{$user->id}/posts");

        $response->assertOk();

        $response->assertJson(['posts' => [
            [
                'title' => 'Test Post',
                'body' => 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA',
                'user_id' => $user->id
            ],
        ]]);
    }

    public function test_users_can_update_posts(): void
    {
        $user = $this->createUserWithToken();

        $post = Post::create([
            'title' => 'Test Post',
            'body' => 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA',
            'user_id' => $user->id
        ]);

        $response = $this->patchJSON("/users/{$user->id}/posts/{$post->id}", [
            'title' => 'New blog post',
            'body' => 'BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBb'
        ], ['Authorization' => "Bearer {$user->currentAccessToken()->plainTextToken}"]);

        $response->assertNoContent();

        $post = Post::find($post->id);

        $this->assertTrue($post->title === 'New blog post');
        $this->assertTrue($post->body === 'BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBb');
    }

    public function test_users_can_delete_posts(): void
    {
        $user = $this->createUserWithToken();

        $post = Post::create([
            'title' => 'Test Post',
            'body' => 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA',
            'user_id' => $user->id
        ]);

        $response = $this->deleteJSON("/users/{$user->id}/posts/{$post->id}", [], [
            'Authorization' => "Bearer {$user->currentAccessToken()->plainTextToken}"
        ]);

        $response->assertNoContent();

        $post = Post::find($post->id);
        $this->assertTrue($post === null);
    }
}
