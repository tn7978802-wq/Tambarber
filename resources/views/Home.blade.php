@extends('layouts.app')

@section('title', 'Barbershop - Cắt tóc nam chuyên nghiệp')

@section('content')

    {{-- 1. HERO SECTION --}}
    <section class="hero">
        <div>
            <span class="section-eyebrow">Đẹp trai hơn &middot; Tự tin hơn &middot; Thành công hơn</span>
            <h1>Tâm Barbershop<br>Cắt tóc nam chuyên nghiệp</h1>
            <p>Chuẩn phong cách, đúng tay nghề. Đến với chúng tôi để có kiểu tóc ưng ý mỗi lần ghé thăm.</p>
            <a href="{{ route('booking.create') }}" class="btn btn-gold">Đặt lịch ngay</a>
        </div>
        <img src="/images/fade-cut-closeup.jpg" alt="Barber đang cắt tóc fade cho khách">
    </section>

    <div class="pole-divider"></div>

    {{-- 2. KIỂU TÓC NỔI BẬT --}}
    <section>
        <span class="section-eyebrow">Xu hướng</span>
        <h2>Kiểu tóc nổi bật</h2>
        <ul class="card-grid">
            @forelse ($featuredHairstyles as $hairstyle)
                <li class="card">
                    <a href="{{ route('hairstyles.show', $hairstyle->slug) }}">
                        <img src="{{ $hairstyle->image ?? '/images/fade-cut-closeup.jpg' }}" alt="{{ $hairstyle->name }}">
                        <h3>{{ $hairstyle->name }}</h3>
                    </a>
                </li>
            @empty
                <li class="card">Danh sách kiểu tóc đang được cập nhật.</li>
            @endforelse
        </ul>
        <p class="text-center" style="margin-top:1.25rem;">
            <a href="{{ route('hairstyles.index') }}">Xem tất cả kiểu tóc &rarr;</a>
        </p>
    </section>

    {{-- 3. DỊCH VỤ --}}
    <section>
        <span class="section-eyebrow">Bảng giá</span>
        <h2>Dịch vụ của chúng tôi</h2>
        <ul class="card-grid">
            @forelse ($services as $service)
                <li class="card">
                    <h3>{{ $service->name }}</h3>
                    <p class="price">{{ number_format((float) $service->price, 0, ',', '.') }}đ</p>
                    <p class="meta">{{ $service->duration_minutes }} phút</p>
                    <p>{{ $service->description }}</p>
                </li>
            @empty
                <li class="card">Danh sách dịch vụ đang được cập nhật.</li>
            @endforelse
        </ul>
        <p class="text-center" style="margin-top:1.25rem;">
            <a href="{{ route('services.index') }}">Xem toàn bộ bảng giá &rarr;</a>
        </p>
    </section>

    <div class="pole-divider"></div>

    {{-- 4. ĐÁNH GIÁ KHÁCH HÀNG --}}
    <section>
        <div style="display:grid; grid-template-columns:1fr auto; gap:2rem; align-items:start;">
            <div>
                <span class="section-eyebrow">Cảm nhận</span>
                <h2>Khách hàng nói gì về chúng tôi</h2>
                @forelse ($reviews as $review)
                    <blockquote class="review">
                        &ldquo;{{ $review->comment }}&rdquo;
                        <br>
                        <strong>{{ $review->customer_name }}</strong> &middot;
                        <span class="stars">{{ $review->rating }}/5 sao</span>
                    </blockquote>
                @empty
                    <p>Chưa có đánh giá nào.</p>
                @endforelse
            </div>
            <div class="seal" aria-hidden="true">
                SỰ HÀI LÒNG<br><span style="font-size:1.7rem;">100%</span><br>
                <small>HOẶC HOÀN TIỀN</small>
            </div>
        </div>
    </section>

    <div class="pole-divider"></div>

    {{-- 5. BÀI VIẾT MỚI --}}
    <section>
        <span class="section-eyebrow">Cập nhật</span>
        <h2>Kiến thức &amp; Tin tức</h2>
        <ul class="card-grid">
            @forelse ($latestPosts as $post)
                <li class="card">
                    <a href="{{ route('blog.show', $post->slug) }}"><h3>{{ $post->title }}</h3></a>
                    <p>{{ $post->excerpt }}</p>
                </li>
            @empty
                <li class="card">Chưa có bài viết nào.</li>
            @endforelse
        </ul>
        <p class="text-center" style="margin-top:1.25rem;">
            <a href="{{ route('blog.index') }}">Xem thêm bài viết &rarr;</a>
        </p>
    </section>

@endsection