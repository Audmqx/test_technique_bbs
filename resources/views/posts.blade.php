<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Instagram's Posts</title>
        <link rel="stylesheet" href="{{ asset('app.css') }}">
    </head>

    <body>
        <div class="posts-wrapper">
                @forelse ($posts['data'] as $post)
                    <div class="post">
                        @if ($post['media_type'] == 'VIDEO')
                            <video src="{{$post['media_url']}}" alt="{{$post['caption']}}" autoplay muted loop></video>
                        @else
                            <img src="{{$post['media_url']}}" alt="{{$post['caption']}}">
                        @endif
                            <p>{{$post['caption'] ?? ''}}</p>

                            <span>{{$post['timestamp']}}</span>
                    </div>
                @empty
                    <p>Empty user data</p>
                @endforelse
        </div>
    </body>
</html>