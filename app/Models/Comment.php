<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{

    protected $table = "comments";
    protected $guarded = false;
    protected $with = "post";
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    public function answers(): HasMany
    {
        return $this->hasMany(Comment::class, 'comment_id', 'id');
    }
}
