@extends('layouts.app')

@section('title', $post->title . ' - Barbershop')

@section('content')

    <p><a href="{{ route('blog.index') }}">&larr; Quay lại Blog</a></p>

    <span class="section-eyebrow">{{ $post->category }}</span>
    <h1>{{ $post->title }}</h1>
    <p class="muted">{{ $post->publish_at?->format('d/m/Y') }}</p>

    @if ($post->thumbnail)
        <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" style="border-radius:4px; margin-bottom:1.5rem;">
    @endif

    <div style="max-width:70ch;">{!! nl2br(e($post->content)) !!}</div>

    <div class="pole-divider" style="margin-top:2.5rem;"></div>

    <section>
        <h2>Bài viết liên quan</h2>
        <ul class="card-grid">
            @foreach ($related as $item)
                <li class="card"><a href="{{ route('blog.show', $item->slug) }}"><h3>{{ $item->title }}</h3></a></li>
            @endforeach
        </ul>
    </section>

@endsection