@extends('layouts.app')

@section('title', 'Barbershop - Cắt tóc nam chuyên nghiệp')

@section('content')

{{-- Bố cục 2 cột: nội dung chính bên trái, khung "Trạng thái & Sự kiện" bên phải. --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex gap-6 items-start flex-wrap">

    <div class="w-full lg:w-3/4 min-w-[280px]">

        {{-- 1. HERO SECTION --}}
        <section class="bg-gray-800/60 border border-gray-700 rounded p-6 grid lg:grid-cols-2 gap-6 items-center overflow-hidden">
            <div>
                <img src="/images/fade-cut-closeup.jpg" alt="Barber đang cắt tóc fade cho khách" class="w-full h-auto rounded shadow-lg object-cover">
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-wider text-amber-300 uppercase">Barbershop - Cắt tóc nam chuyên nghiệp</h1>
                <p class="mt-3 text-gray-300">Chuẩn phong cách, đúng tay nghề. Đến với chúng tôi để có kiểu tóc ưng ý mỗi lần ghé thăm.</p>
                <a href="{{ route('booking.create') }}" class="inline-block mt-5 px-6 py-3 rounded bg-amber-400 text-black font-semibold">Đặt lịch ngay</a>
            </div>
        </section>

        <hr class="border-t border-gray-700 my-8">

        {{-- 2. KIỂU TÓC NỔI BẬT --}}
        <section>
            <h2 class="text-2xl font-bold text-amber-300 uppercase">Kiểu tóc nổi bật</h2>
            <ul class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4">
                @forelse ($featuredHairstyles as $hairstyle)
                    <li class="bg-gray-800/50 border border-gray-700 rounded p-3 text-center">
                        <a href="{{ route('hairstyles.show', $hairstyle->slug) }}" class="block">
                            <img src="{{ $hairstyle->image ?? '/images/fade-cut-closeup.jpg' }}" alt="{{ $hairstyle->name }}" class="w-full h-36 object-cover rounded mb-2">
                            <div class="text-gray-200 font-medium">{{ $hairstyle->name }}</div>
                        </a>
                    </li>
                @empty
                    <li class="text-gray-400">Danh sách kiểu tóc đang được cập nhật.</li>
                @endforelse
            </ul>
            <a href="{{ route('hairstyles.index') }}" class="inline-block mt-3 text-amber-300 hover:text-amber-400">Xem tất cả kiểu tóc &rarr;</a>
        </section>

        <hr class="border-t border-gray-700 my-8">

        {{-- 3. DỊCH VỤ --}}
        <section>
            <h2 class="text-2xl font-bold text-amber-300 uppercase">Dịch vụ của chúng tôi</h2>
            <ul class="mt-4 space-y-3">
                @forelse ($services as $service)
                    <li class="bg-gray-800/50 border border-gray-700 rounded p-3">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <div class="font-semibold text-gray-100">{{ $service->name }}</div>
                                <div class="text-sm text-gray-400">{{ $service->description }}</div>
                            </div>
                            <div class="text-amber-300 font-bold">{{ number_format((float) $service->price, 0, ',', '.') }}đ<br><span class="text-sm text-gray-400">{{ $service->duration_minutes }} phút</span></div>
                        </div>
                    </li>
                @empty
                    <li class="text-gray-400">Danh sách dịch vụ đang được cập nhật.</li>
                @endforelse
            </ul>
            <a href="{{ route('services.index') }}" class="inline-block mt-3 text-amber-300 hover:text-amber-400">Xem toàn bộ bảng giá &rarr;</a>
        </section>

        <hr class="border-t border-gray-700 my-8">

        {{-- 4. ĐÁNH GIÁ KHÁCH HÀNG --}}
        <section>
            <h2 class="text-2xl font-bold text-amber-300 uppercase">Khách hàng nói gì về chúng tôi</h2>
            <div class="mt-4 space-y-4">
                @forelse ($reviews as $review)
                    <blockquote class="review bg-gray-800/50 border border-gray-700 rounded p-4 italic text-gray-100">
                        "{{ $review->comment }}"
                        <div class="mt-2 text-sm text-amber-300"><strong>{{ $review->customer_name }}</strong> &middot; {{ $review->rating }}/5</div>
                    </blockquote>
                @empty
                    <p class="text-gray-400">Chưa có đánh giá nào.</p>
                @endforelse
            </div>
        </section>

        <hr class="border-t border-gray-700 my-8">

        {{-- 5. BÀI VIẾT MỚI --}}
        <section>
            <h2 class="text-2xl font-bold text-amber-300 uppercase">Kiến thức &amp; Tin tức</h2>
            <ul class="mt-4 space-y-3">
                @forelse ($latestPosts as $post)
                    <li class="bg-gray-800/50 border border-gray-700 rounded p-3">
                        <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-100 font-medium">{{ $post->title }}</a>
                        <div class="text-sm text-gray-400">{{ $post->excerpt }}</div>
                    </li>
                @empty
                    <li class="text-gray-400">Chưa có bài viết nào.</li>
                @endforelse
            </ul>
            <a href="{{ route('blog.index') }}" class="inline-block mt-3 text-amber-300 hover:text-amber-400">Xem thêm bài viết &rarr;</a>
        </section>

    </div>

    {{-- 6. KHUNG TRẠNG THÁI & SỰ KIỆN - BÊN PHẢI --}}
    <aside class="w-full lg:w-1/4 min-w-[260px] bg-gray-800/50 border border-gray-700 rounded p-4">
        <h2 class="text-lg font-semibold text-amber-300">Trạng thái &amp; Sự kiện</h2>

        @forelse ($announcements as $announcement)
            <div class="border-b border-gray-700 py-3">
                @if ($announcement->is_pinned)
                    <small class="text-amber-300">📌 Ghim</small>
                @endif
                @if ($announcement->image)
                    <a href="{{ route('announcements.show', $announcement) }}">
                        <img src="{{ $announcement->image }}" alt="" class="w-full rounded mt-2 mb-2 object-cover">
                    </a>
                @endif
                <p class="mt-1">
                    <a href="{{ route('announcements.show', $announcement) }}" class="text-gray-100 font-medium">
                        <strong>{{ $announcement->title ?: \Illuminate\Support\Str::limit($announcement->content, 60) }}</strong>
                    </a>
                </p>
                @if ($announcement->event_at)
                    <small class="text-sm text-gray-400">🗓️ {{ $announcement->event_at->format('H:i d/m/Y') }}</small><br>
                @endif
                <small class="text-sm text-gray-400">{{ $announcement->created_at->diffForHumans() }} &middot; {{ $announcement->comments_count }} bình luận</small>
            </div>
        @empty
            <p><small class="text-gray-400">Chưa có trạng thái/sự kiện nào.</small></p>
        @endforelse
        <a href="{{ route('announcements.index') }}" class="inline-block mt-3 text-amber-300 hover:text-amber-400">Xem tất cả &rarr;</a>
    </aside>

</div>
@endsection