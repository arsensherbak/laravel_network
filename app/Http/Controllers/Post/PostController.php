<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Service\PostService;
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

    public function store(PostStoreRequest $request):  Response
    {
        $this->postService->storePost($request);
        return response('created post', 200);
    }
}
