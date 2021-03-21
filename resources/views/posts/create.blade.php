@extends('layouts.app')

@section('content')
    <h1>Create Post</h1>
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" aria-describedby="emailHelp">
        </div>
        <div class="form-group mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea class="form-control" name="body"></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="creator" class="form-label">Post Creator</label>
            <input type="text" class="form-control" name="creator" aria-describedby="emailHelp"
                value="{{ Auth::user()->name }}" disabled>
        </div>
        <x-button type="primary">Create</x-button>

    </form>

@endsection
