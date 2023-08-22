<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Like\LikeRequest;
use App\Http\Requests\User\FollowingRequest;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Http\Service\UserService;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{

    private UserService $userService;

    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function index(): AnonymousResourceCollection
    {
        $users = $this->userService->getUsers();
        return UserResource::collection($users);
    }

    public function getPosts(User $user): AnonymousResourceCollection
    {
        $posts = $this->userService->getPostsUser($user);
        return PostResource::collection($posts);
    }

    public function addFollowings(FollowingRequest $request): Response
    {
        return $this->userService->addFollowings($request);
    }

    public function getSubscriptions(): AnonymousResourceCollection
    {
        $users = $this->userService->getSubscriptions();
        return UserResource::collection($users);
    }

    public function getNews(): AnonymousResourceCollection
    {
        $posts = $this->userService->getNews();
        return PostResource::collection($posts);
    }

    public function addLiked(LikeRequest $request): Response
    {
        return $this->userService->addLiked($request);
    }
}
