<?php

namespace App\Http\Service;

use App\Models\LikedPost;
use App\Models\Post;
use App\Models\SubscriberFollowing;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class UserService
{
    public function getUsers(): Collection
    {
        $users = User::all();
        $followings = SubscriberFollowing::where('subscriber_id', auth()->id())->pluck('following_id')->toArray();
        foreach ($users as $user) {
            if (in_array($user->id, $followings)) {
                $user->is_following = true;
            }
        }
        return $users;
    }

    public function getPostsUser($user): mixed
    {
        return $user->posts->sortByDesc('created_at');
    }

    public function addFollowings($request): Response
    {
        $data = $request->validated();
        $res = auth()->user()->followings()->toggle($data['user_id']);
        return response($res, 200);
    }

    public function getSubscriptions()
    {
        $user = auth()->user();
        $users = $user->followings;
        $users = $users->map(function ($user) {
            $user['is_following'] = true;
            return $user;
        });
        return $users;
    }

    public function getNews()
    {
        $user = auth()->user();
        $userId = $user->followings->pluck('id');
        $postsLike = LikedPost::where('user_id', $user->id)->pluck('post_id');
        return Post::whereIn('user_id', $userId)->whereNotIn('id', $postsLike)->get();
    }

    public function addLiked($request): Response
    {
        $data = $request->validated();
        $user = auth()->user();
        $res = $user->likes()->toggle($data['post_id']);
        $post = Post::find($data['post_id']);
        $postCount = $post->userLikes->count();
        return response($postCount, 200);
    }
}
