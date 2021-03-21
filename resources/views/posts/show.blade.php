@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default float-right">Go Back</a>

    <h1>{{ $post->title ?? 'user not found' }}
    </h1>
    <div>{{ $post->body }}</div>
    <hr>
    <small>Written on {{ Carbon\Carbon::parse($post->created_at)->format('l jS \\of F Y h:i:s A') }}</small>
    <hr>
    @if (!Auth::guest())
        @if (Auth::user()->id == $post->user_id)
            <a href="/posts/{{ $post->id }}/edit" class="btn btn-primary">Edit</a>
            <form class="float-right" method="POST" action="{{ route('posts.destroy', $post->id) }}">
                @method('DELETE')
                @csrf
                <x-button type="danger" onclick="return confirm('Are you sure?')">Delete</x-button>

            </form>
        @endif
    @endif
@endsection
