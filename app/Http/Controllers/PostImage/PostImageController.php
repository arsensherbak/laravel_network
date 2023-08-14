<?php

namespace App\Http\Controllers\PostImage;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostImage\PostImageRequest;
use App\Http\Resources\PostImage\PostImageResource;
use App\Http\Service\PostImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostImageController extends Controller
{

    private PostImageService $imageService;

    public function __construct(
        PostImageService $imageService
    )
    {
        $this->imageService = $imageService;
    }


    public function store(PostImageRequest $request): PostImageResource
    {
        $postImage = $this->imageService->storeImage($request);
        return new PostImageResource($postImage);
    }

    public function deletePostImage(Request $request): Response
    {
        return $this->imageService->deletePostImage($request);
    }
}
