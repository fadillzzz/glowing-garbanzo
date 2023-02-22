<?php

namespace App\Core\Services\User\Post;

use App\Core\Interfaces\User\Post\PostRepository;
use App\Models\Post;

class PostService
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function create(int $userId, array $post): Post
    {
        return $this->postRepository->create([
            'user_id' => $userId,
            'title' => $post['title'],
            'body' => $post['body']
        ]);
    }

    public function getAllByUserId(int $userId): array
    {
        return $this->postRepository->getAllByUserId($userId);
    }
}