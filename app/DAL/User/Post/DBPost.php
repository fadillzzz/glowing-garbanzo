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
}
