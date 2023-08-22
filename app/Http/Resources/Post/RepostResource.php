<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $url = isset($this->postImage) ? $this->postImage->url : null;
        return [
            'id'=> $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'url' => $url,
        ];
    }
}
