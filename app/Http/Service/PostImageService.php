<?php

namespace App\Http\Service;

use App\Models\PostImage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PostImageService
{
    public function storeImage($request)
    {
        $data = $request->validated();
        $path = Storage::disk('public')->put('/images', $data['image']);
        $postImage = PostImage::create([
            'path' => $path,
            'user_id'=>auth()->id(),
        ]);
        return $postImage;
    }
    public function deletePostImage($request): Response
    {
        $data = $request->all();
        $postImage = PostImage::find($data['image']);
        $path = $postImage->path;
        Storage::disk('public')->delete($path);
        $postImage->delete();
        return response('post image delete', 200);
    }
}
