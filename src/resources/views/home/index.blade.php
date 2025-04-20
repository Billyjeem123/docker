<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Posts Feed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .post-card {
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            transition: transform 0.2s ease-in-out;
        }
        .post-card:hover {
            transform: translateY(-5px);
        }
        .post-img {
            height: 250px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h1 class="mb-4 text-center">Latest Posts</h1>
    {{$fromCache ? "From Cache": "Not form cache"}}
    <div class="row g-4">

        @foreach($posts as $post)
            <div class="col-md-6 col-lg-4">
                <div class="card post-card h-100">
                    <img src="/{{$post->image }}" class="card-img-top post-img" alt="{{ $post->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text text-muted small">{{ $post->created_at->diffForHumans() }}</p>
                        <p class="card-text">{{ $post->content }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
