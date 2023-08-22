<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\AnswerRequest;
use App\Http\Requests\Comment\PostCommentsRequest;
use App\Http\Requests\Post\CommentRequest;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\RepostRequest;
use App\Http\Resources\Comment\AnswerResource;
use App\Http\Resources\Comment\CommentRecource;
use App\Http\Resources\Post\PostResource;
use App\Http\Service\PostService;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(
        PostService $postService
    )
    {
        $this->postService = $postService;
    }

    public function store(PostStoreRequest $request): PostResource
    {
        return $this->postService->storePost($request);
    }

    public function index(): AnonymousResourceCollection
    {
        return $posts = $this->postService->getAllPost();
    }

    public function repost(RepostRequest $request): PostResource
    {
        return $this->postService->repostPost($request);
    }

    public function addComment(CommentRequest $request): CommentRecource
    {
        return $this->postService->addComment($request);
    }

    public function getComment(PostCommentsRequest $request): AnonymousResourceCollection
    {
        return $this->postService->getComments($request);
    }

    public function addAnswer(AnswerRequest $request): AnswerResource
    {
        return $this->postService->addAnswer($request);
    }
}
