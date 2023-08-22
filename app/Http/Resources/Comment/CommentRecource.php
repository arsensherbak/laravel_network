<?php

namespace App\Http\Resources\Comment;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentRecource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::find($this->user_id);
        return [
            'id'=>$this->id,
            'body'=>$this->body,
            'name'=>$user->name,
        ];
    }
}
