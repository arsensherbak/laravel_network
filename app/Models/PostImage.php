<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostImage extends Model
{

    protected $table = "post_images";
    protected $guarded = false;

    public function getUrlAttribute(): string
    {
        return url('/storage/' . $this->path);
    }
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
