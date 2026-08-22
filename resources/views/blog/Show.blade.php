@extends('layouts.app')

@section('title', $post->title . ' - Barbershop')

@section('content')

    <a href="{{ route('blog.index') }}">&larr; Quay lại Blog</a>

    <h1>{{ $post->title }}</h1>
    <p><small>{{ $post->publish_at?->format('d/m/Y') }} &middot; {{ $post->category }}</small></p>

    @if ($post->thumbnail)
        <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" width="500">
    @endif

    <div>{!! nl2br(e($post->content)) !!}</div>

    <hr>

    <h2>Bài viết liên quan</h2>
    <ul>
        @foreach ($related as $item)
            <li><a href="{{ route('blog.show', $item->slug) }}">{{ $item->title }}</a></li>
        @endforeach
    </ul>

@endsection