<?php

namespace App\Http\Controllers\Users\Posts;

use App\Core\Services\User\Post\PostService;
use App\Core\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostsController extends Controller
{
    private UserService $userService;
    private PostService $postService;

    public function __construct(UserService $userService, PostService $postService)
    {
        $this->userService = $userService;
        $this->postService = $postService;
    }

    public function index(Request $request, string $userId): Response
    {

        $this->assertUserExists((int) $userId);

        $posts = $this->postService->getAllByUserId((int) $userId);

        return response(['posts' => $posts], Response::HTTP_OK);
    }

    public function store(Request $request, string $userId): Response
    {
        $request->validate([
            'title' => 'string|required',
            'body' => 'string|required',
        ]);

        $this->assertUserExists((int) $userId);

        $post = $this->postService->create($userId, [
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response(['post' => $post], Response::HTTP_CREATED);
    }

    private function assertUserExists(int $userId)
    {
        if (! $this->userService->exists($userId)) {
            throw new ItemNotFoundException();
        }
    }
}
