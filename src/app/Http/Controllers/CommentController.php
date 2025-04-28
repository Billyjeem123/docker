<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Post $post){

        $comment = Comment::where('post_id', $post->id)->get();
        return $post->comments;
    }

    public function show(Comment $comment, Post $post){

         return $comment;
    }
}
