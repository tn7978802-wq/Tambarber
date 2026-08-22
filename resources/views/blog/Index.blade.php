@extends('layouts.app')

@section('title', 'Blog - Barbershop')

@section('content')

    <h1>Blog &amp; Kiến thức</h1>

    <ul>
        @forelse ($posts as $post)
            <li>
                <a href="{{ route('blog.show', $post->slug) }}"><strong>{{ $post->title }}</strong></a>
                <br>{{ $post->excerpt }}
                <br><small>{{ $post->publish_at?->format('d/m/Y') }} &middot; {{ $post->category }}</small>
            </li>
        @empty
            <li>Chưa có bài viết nào.</li>
        @endforelse
    </ul>

    {{ $posts instanceof \Illuminate\Pagination\LengthAwarePaginator ? $posts->links() : '' }}

@endsection