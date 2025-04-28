<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    public $content  = "";
    public function indexHome(){

        return Post::all();
    }


    public function index()
    {

        $fromCache = false;

        if (Cache::store('redis')->has('posts')) {
            $fromCache = true;

            $posts = Cache::store('redis')->get('posts');
        } else {
            $posts = Post::all();
            Cache::store('redis')->put('posts', $posts, 3600);
        }
        return view('home.index', [
            'posts' => $posts,
            'fromCache' => $fromCache
        ]);

    }

    public function create(){

        return view('home.create');
    }


    public function show(Post $post){

        return $post;
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');

        // Create the new post
        $newPost = Post::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        // Check if the posts cache exists
        if (Cache::store('redis')->has('posts')) {
            $posts = Cache::store('redis')->get('posts');

            // Ensure the collection is mutable
            $posts = collect($posts);
            $posts->push($newPost);
            // Update the cache with the new post list
            Cache::store('redis')->put('posts', $posts, 3600);
        }

        return redirect()->back()->with('success', 'Post created successfully.');
    }

}
