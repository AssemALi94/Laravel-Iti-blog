@extends('layouts.app')

@section('content')
    <h1>Edit Post</h1>
    <form method="POST" action="{{ route('posts.update', $post->id) }}">
        @method('PUT')
        @csrf
        <div class="form-group mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" aria-describedby="emailHelp"
                value="{{ $post['title'] }}">
        </div>
        <div class="form-group mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea class="form-control" name="body">{{ $post['body'] }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>

@endsection
