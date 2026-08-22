@extends('layouts.app')

@section('title', 'Blog - Barbershop')

@section('content')

    <span class="section-eyebrow">Kiến thức</span>
    <h1>Blog &amp; Kiến thức</h1>
    <div class="pole-divider small" style="margin-left:0;"></div>

    <ul class="card-grid">
        @forelse ($posts as $post)
            <li class="card">
                <a href="{{ route('blog.show', $post->slug) }}"><h3>{{ $post->title }}</h3></a>
                <p>{{ $post->excerpt }}</p>
                <p class="meta">{{ $post->publish_at?->format('d/m/Y') }} &middot; {{ $post->category }}</p>
            </li>
        @empty
            <li class="card">Chưa có bài viết nào.</li>
        @endforelse
    </ul>

    <div class="text-center" style="margin-top:1.5rem;">
        {{ $posts instanceof \Illuminate\Pagination\LengthAwarePaginator ? $posts->links() : '' }}
    </div>

@endsection