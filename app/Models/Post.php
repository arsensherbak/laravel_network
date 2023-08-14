<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    protected $table = "posts";
    protected $guarded = false;

    public function postImage(): HasOne
    {
        return $this->hasOne(PostImage::class);
    }
}
