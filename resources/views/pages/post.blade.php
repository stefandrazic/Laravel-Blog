@extends('layout.default')

@section('title')
    {{ $post->title }}
@endsection

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->body }}</p>
    @foreach ($comments as $comment)
        @include('components.comment')
    @endforeach
    @if (auth()->user())
        @include('components.createcomment')
    @endif
@endsection
