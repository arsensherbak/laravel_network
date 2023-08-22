<?php

namespace App\Http\Service;

use App\Http\Resources\Comment\AnswerResource;
use App\Http\Resources\Comment\CommentRecource;
use App\Http\Resources\Post\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostService
{

    public function storePost($request): PostResource
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();
            $imageId = $data['postImageId'];
            unset($data['postImageId']);
            $post = Post::create($data);

            if (!is_null($imageId)) {
                $postImage = PostImage::find($imageId);
                $postImage->update([
                    'post_id' => $post->id
                ]);
            }
            return new PostResource($post);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

    }

    public function getAllPost(): AnonymousResourceCollection
    {
        $posts = Post::where('user_id', auth()->id())->withCount('repostByPosts')->latest()->get();
        return PostResource::collection($posts);
    }

    public function repostPost($request): PostResource
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $post = Post::create($data);
        return new PostResource($post);
    }

    public function addComment($request): CommentRecource
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $comment = Comment::create($data);
        return new CommentRecource($comment);
    }

    public function getComments($request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $comments = Comment::where('post_id', $data['post_id'])->withCount('answers')->get();
        return CommentRecource::collection($comments);
    }
    public function addAnswer($request): AnswerResource
    {
        $data = $request->validated();
        $userId = auth()->id();
        $comment = Comment::create([
            'body' => $data['answer'],
            'user_id'=> $userId,
            'post_id'=>$data['post_id'],
            'comment_id'=>$data['comment_id']
        ]);

        return new AnswerResource($comment);
    }
}
