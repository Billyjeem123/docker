<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GetFood implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // get a new food item from the api
        // create a post based on that food
        $food = Http::get('https://foodish-api.herokuapp.com/api')->json();

        Post::create([
            'user_id' => 1,
            'title' => 'New food from ' . date('M d @ H:i:s'),
            'content' => "lorem ipsum",
            'image' => "a.jpeg",
        ]);
    }
}
