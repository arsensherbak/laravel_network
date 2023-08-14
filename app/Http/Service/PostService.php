<?php

namespace App\Http\Service;

use App\Models\Post;
use App\Models\PostImage;

class PostService
{

    public function storePost($request): void
    {
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
    }
}
