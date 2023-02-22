<?php

namespace App\Core\Interfaces\User\Post;

use App\Models\Post;

interface PostRepository
{
    public function create(array $post): Post;

    public function getAllByUserId(int $userId): array;
}
