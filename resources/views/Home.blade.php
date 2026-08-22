@extends('layouts.app')

@section('title', 'Barbershop - Cắt tóc nam chuyên nghiệp')

@section('content')

    {{-- 1. HERO SECTION --}}
    <section>
        <img src="/images/fade-cut-closeup.jpg" alt="Barber đang cắt tóc fade cho khách" width="600">
        <h1>Tâm Barbershop - Cắt tóc nam chuyên nghiệp</h1>
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

@endsection