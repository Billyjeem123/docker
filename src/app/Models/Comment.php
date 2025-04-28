<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relationship with Post (Comment belongs to Post)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relationship with User (Comment belongs to User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
