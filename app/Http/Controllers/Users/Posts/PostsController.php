<?php

namespace App\Http\Controllers\Users\Posts;

use App\Core\Exceptions\Common\ItemNotFoundException;
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
            'title' => 'string|max:255|required',
            'body' => 'string|required',
        ]);

        $this->assertUserExists((int) $userId);

        $post = $this->postService->create($userId, [
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response(['post' => $post], Response::HTTP_CREATED);
    }

    public function update(Request $request, string $userId, string $postId): Response
    {
        $request->validate([
            'title' => 'string|max:255',
            'body' => 'string',
        ]);

        $this->assertUserExists((int) $userId);
        $this->assertPostExists((int) $userId, (int) $postId);

        $this->postService->update((int) $postId, array_filter([
            'title' => $request->title,
            'body' => $request->body,
        ]));

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function destroy(Request $request, string $userId, string $postId): Response
    {
        $this->assertUserExists((int) $userId);
        $this->assertPostExists((int) $userId, (int) $postId);

        $this->postService->delete((int) $postId);

        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function assertUserExists(int $userId)
    {
        if (! $this->userService->exists($userId)) {
            throw new ItemNotFoundException();
        }
    }

    private function assertPostExists(int $userId, int $postId)
    {
        if (! $this->postService->exists($userId, $postId)) {
            throw new ItemNotFoundException();
        }
    }
}
