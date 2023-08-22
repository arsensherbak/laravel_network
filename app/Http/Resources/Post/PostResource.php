<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Comment\CommentRecource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $url = isset($this->postImage) ? $this->postImage->url : null;
        $name = $this->userInfo->name;
        $user = auth()->user();
        $liked = $user->likes()->where('post_id', $this->id)->exists();
        $isLiked = $liked ?? false;
        return [
            'id'=> $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'url' => $url,
            'name' => $name,
            'like' =>$isLiked,
            'like_count' => $this->userLikes->count(),
            'date' => $this->created_at->diffForHumans(),
            'reposted'=> new RepostResource($this->repostPost),
            'comments'=>CommentRecource::collection($this->comments),
            'comments_count'=> $this->comments_count,
            'repost_count'=>$this->repost_by_posts_count
        ];
    }
}
