@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if (count($posts) > 0)
        @foreach ($posts as $post)
            <div class="card p-3 m-3">
                <h3 class="card-title"><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></h3>
                <p class="card-title"><a href="/posts/{{ $post->id }}">{{ $post->body }}</a></p>
                <small>{{ $post->slug }}</small>
                <small>written on {{ Carbon\Carbon::parse($post->created_at)->format('l jS \\of F Y h:i:s A') }}</small>
                <small>posted by by {{ $post->user ? $post->user->name : 'user not found' }}</small>
            </div>
        @endforeach
        {{ $posts->links() }}
    @else
        <p>No posts found</p>
    @endif
@endsection
