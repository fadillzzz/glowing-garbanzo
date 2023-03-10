<?php

namespace App\Core\Interfaces\User\Post;

use App\Models\Post;

interface PostRepository
{
    public function create(array $post): Post;

    public function getAllByUserId(int $userId): array;

    public function update(int $postId, array $post): void;

    public function delete(int $postId): void;

    public function exists(int $userId, int $postId): bool;
}
