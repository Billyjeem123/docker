<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relationship with User (Post belongs to User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Comment (Post has many Comments)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
