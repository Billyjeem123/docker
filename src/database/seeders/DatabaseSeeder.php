<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Users
        $users = collect([
            User::create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
            ]),
            User::create([
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
            ]),
            User::create([
                'name' => 'Alex Ray',
                'email' => 'alex@example.com',
                'password' => Hash::make('password'),
            ])
        ]);

        // Create Posts
        $images = ['a.jpeg', 'b.jpeg', 'c.jpeg', 'd.jpeg'];
        $titles = [
            "Weekend Vibes!",
            "Just wrapped this project 🎉",
            "Nature is healing 🌿"
        ];

        $contents = [
            "Took a walk and snapped this. Needed the peace of mind.",
            "Felt good to finally finish it. A lot of lessons along the way!",
            "Can't get enough of views like this. Where's your happy place?"
        ];

        $posts = collect();

        for ($i = 0; $i < count($images); $i++) {
            $posts->push(Post::create([
                'user_id' => $users->random()->id,
                'title' => $titles[$i],
                'content' => $contents[$i],
                'image' => $images[$i],
            ]));
        }

        // Create Comments
        $commentSnippets = [
            "This is awesome!",
            "Love this!",
            "Wow, inspiring!",
            "Looks peaceful.",
            "Such a vibe 😍",
            "Great shot!",
        ];

        foreach ($posts as $post) {
            $commenters = $users->shuffle();
            foreach ($commenters as $user) {
                Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'content' => $commentSnippets[array_rand($commentSnippets)],
                ]);
            }
        }
    }
}
