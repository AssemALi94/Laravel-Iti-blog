@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default float-right">Go Back</a>

    <h1>{{ $post->title }}</h1>
    <div>{{ $post->body }}</div>
    <hr>
    <small>Written on {{ $post->created_at }}</small>
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
