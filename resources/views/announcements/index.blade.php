@extends('layouts.app')

@section('title', 'Trạng thái & Sự kiện - Barbershop')

@section('content')

    <h1>Trạng thái &amp; Sự kiện</h1>
    <p>Cập nhật khuyến mãi, sự kiện và thông báo mới nhất từ tiệm.</p>

    @forelse ($announcements as $announcement)
        <article style="border:1px solid #ccc;padding:12px;margin-bottom:16px;">
            @if ($announcement->is_pinned)
                <p><strong>📌 Ghim</strong></p>
            @endif

            @if ($announcement->title)
                <h2><a href="{{ route('announcements.show', $announcement) }}">{{ $announcement->title }}</a></h2>
            @endif

            @if ($announcement->image)
                <img src="{{ $announcement->image }}" alt="{{ $announcement->title }}" width="300">
            @endif

            <p>{{ \Illuminate\Support\Str::limit($announcement->content, 200) }}</p>

            @if ($announcement->event_at)
                <p><small>🗓️ Sự kiện diễn ra lúc: {{ $announcement->event_at->format('H:i d/m/Y') }}</small></p>
            @endif

            <p>
                <small>
                    Đăng bởi {{ $announcement->user->fullname ?? 'Barbershop' }}
                    &middot; {{ $announcement->created_at->diffForHumans() }}
                    &middot; {{ $announcement->comments_count }} bình luận
                </small>
            </p>

            <a href="{{ route('announcements.show', $announcement) }}">Xem &amp; bình luận &rarr;</a>
        </article>
    @empty
        <p>Chưa có trạng thái/sự kiện nào được đăng.</p>
    @endforelse

    {{ $announcements->links() }}

@endsection
