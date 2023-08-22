<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use function Symfony\Component\Translation\t;

class Post extends Model
{
    protected $table = "posts";
    protected $guarded = false;
    protected $with = ['postImage', 'repostPost'];
    protected $withCount = ['comments'];
    public function postImage(): HasOne
    {
        return $this->hasOne(PostImage::class);
    }
   public function userInfo():BelongsTo
   {
        return $this->belongsTo(User::class, 'user_id', 'id');
   }
    public function userLikes():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'liked_posts', 'post_id', 'user_id');
    }
    public function repostPost():BelongsTo
    {
        return $this->belongsTo(Post::class, 'reposted_id', 'id');
    }
    public function repostByPosts():HasMany
    {
        return $this->hasMany(Post::class, 'reposted_id', 'id');
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
