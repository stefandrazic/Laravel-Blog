@extends('layout.default')

@section('title')
    {{ $post->title }}
@endsection

@section('content')
    <h1>{{ $post->title }}</h1>
    <h5>Author: {{ $post->user->name }}</h5>
    <p>{{ $post->body }}</p>
    @foreach ($post->tags as $tag)
        <a href="/tags/{{ $tag->title }}"><span class="badge rounded-pill text-bg-info">{{ $tag->title }}</span></a>
    @endforeach
    @if (auth()->user() && auth()->user()->id === $post->user_id)
        <form action="{{ url('posts/' . $post->id) }}" method="POST" class="mb-1">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input class="form-control" type="text" name="title" placeholder="Enter title" value="{{ $post->title }}"
                    required />
            </div>
            <div class="mb-3">
                <textarea class="form-control" type="text" name="body" placeholder="Edit your post" required>{{ $post->body }}</textarea>
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </form>
    @endif
    @if (auth()->check() && (auth()->user()->id === $post->user_id || auth()->user()->isAdmin))
        <form action="{{ url('posts/' . $post->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Delete post</button>
            </div>
        </form>
    @endif
    @foreach ($comments as $comment)
        @include('components.comment')
    @endforeach
    @if (auth()->user())
        @include('components.createcomment')
    @endif
@endsection
