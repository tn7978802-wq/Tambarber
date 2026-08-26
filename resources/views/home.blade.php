@extends('layouts.app')

@section('title', 'Barbershop - Cắt tóc nam chuyên nghiệp')

@section('content')

{{-- Bố cục 2 cột: nội dung chính bên trái, khung "Trạng thái & Sự kiện" bên phải. --}}
<div style="display:flex;gap:24px;align-items:flex-start;flex-wrap:wrap;">

<div style="flex:3;min-width:280px;">

    {{-- 1. HERO SECTION --}}
    <section>
        <img src="/images/fade-cut-closeup.jpg" alt="Barber đang cắt tóc fade cho khách" width="600">
        <h1>Barbershop - Cắt tóc nam chuyên nghiệp</h1>
        <p>Chuẩn phong cách, đúng tay nghề. Đến với chúng tôi để có kiểu tóc ưng ý mỗi lần ghé thăm.</p>
        <a href="{{ route('booking.create') }}"><strong>Đặt lịch ngay</strong></a>
    </section>

    <hr>

    {{-- 2. KIỂU TÓC NỔI BẬT --}}
    <section>
        <h2>Kiểu tóc nổi bật</h2>
        <ul>
            @forelse ($featuredHairstyles as $hairstyle)
                <li>
                    <a href="{{ route('hairstyles.show', $hairstyle->slug) }}">
                        <img src="{{ $hairstyle->image ?? '/images/fade-cut-closeup.jpg' }}" alt="{{ $hairstyle->name }}" width="150">
                        <br>
                        {{ $hairstyle->name }}
                    </a>
                </li>
            @empty
                <li>Danh sách kiểu tóc đang được cập nhật.</li>
            @endforelse
        </ul>
        <a href="{{ route('hairstyles.index') }}">Xem tất cả kiểu tóc &rarr;</a>
    </section>

    <hr>

    {{-- 3. DỊCH VỤ --}}
    <section>
        <h2>Dịch vụ của chúng tôi</h2>
        <ul>
            @forelse ($services as $service)
                <li>
                    <strong>{{ $service->name }}</strong> -
                    {{ number_format((float) $service->price, 0, ',', '.') }}đ
                    ({{ $service->duration_minutes }} phút)
                    <br>{{ $service->description }}
                </li>
            @empty
                <li>Danh sách dịch vụ đang được cập nhật.</li>
            @endforelse
        </ul>
        <a href="{{ route('services.index') }}">Xem toàn bộ bảng giá &rarr;</a>
    </section>

    <hr>

    {{-- 4. ĐÁNH GIÁ KHÁCH HÀNG --}}
    <section>
        <h2>Khách hàng nói gì về chúng tôi</h2>
        @forelse ($reviews as $review)
            <blockquote>
                "{{ $review->comment }}"
                <br>
                <strong>{{ $review->customer_name }}</strong> - {{ $review->rating }}/5 sao
            </blockquote>
        @empty
            <p>Chưa có đánh giá nào.</p>
        @endforelse
    </section>

    <hr>

    {{-- 5. BÀI VIẾT MỚI --}}
    <section>
        <h2>Kiến thức &amp; Tin tức</h2>
        <ul>
            @forelse ($latestPosts as $post)
                <li>
                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    <br>{{ $post->excerpt }}
                </li>
            @empty
                <li>Chưa có bài viết nào.</li>
            @endforelse
        </ul>
        <a href="{{ route('blog.index') }}">Xem thêm bài viết &rarr;</a>
    </section>

</div>

{{-- 6. KHUNG TRẠNG THÁI & SỰ KIỆN - BÊN PHẢI --}}
<aside style="flex:1;min-width:260px;border:1px solid #ccc;padding:12px;">
    <h2>Trạng thái &amp; Sự kiện</h2>

    @forelse ($announcements as $announcement)
        <div style="border-bottom:1px solid #ddd;padding:8px 0;">
            @if ($announcement->is_pinned)
                <small>📌 Ghim</small>
            @endif
            @if ($announcement->image)
                <a href="{{ route('announcements.show', $announcement) }}">
                    <img src="{{ $announcement->image }}" alt="" width="100%">
                </a>
            @endif
            <p>
                <a href="{{ route('announcements.show', $announcement) }}">
                    <strong>{{ $announcement->title ?: \Illuminate\Support\Str::limit($announcement->content, 60) }}</strong>
                </a>
            </p>
            @if ($announcement->event_at)
                <small>🗓️ {{ $announcement->event_at->format('H:i d/m/Y') }}</small><br>
            @endif
            <small>{{ $announcement->created_at->diffForHumans() }} &middot; {{ $announcement->comments_count }} bình luận</small>
        </div>
    @empty
        <p><small>Chưa có trạng thái/sự kiện nào.</small></p>
    @endforelse
    <a href="{{ route('announcements.index') }}">Xem tất cả &rarr;</a>
</aside>
</div>
@endsection