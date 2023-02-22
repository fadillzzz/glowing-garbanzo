<?php

namespace App\DAL\User\Post;

use App\Core\Interfaces\User\Post\PostRepository;
use App\Models\Post;

class DBPost implements PostRepository
{
    public function create(array $post): Post
    {
        return Post::create($post);
    }

    public function getAllByUserId(int $userId): array
    {
        return Post::where('user_id', $userId)->get()->toArray();
    }

    public function update(int $postId, array $post): void
    {
        Post::where('id', $postId)->update($post);
    }

    public function exists(int $userId, int $postId): bool
    {
        return Post::where('user_id', $userId)
            ->where('id', $postId)
            ->count() === 1;
    }
}
