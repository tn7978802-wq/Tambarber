@extends('layouts.app')

@section('title', 'Barbershop - Cắt tóc nam chuyên nghiệp')

@section('content')

{{-- Bố cục 2 cột: Nội dung chính bên trái, Khung Trạng thái & Sự kiện bên phải --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row gap-8 items-start">

    <!-- CỘT TRÁI - NỘI DUNG CHÍNH -->
    <div class="w-full lg:w-3/4 space-y-10">

        {{-- 1. HERO SECTION --}}
        <section class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-6 sm:p-8 shadow-2xl relative overflow-hidden grid lg:grid-cols-2 gap-8 items-center"
                 style="box-shadow: 0 0 0 1px rgba(138,100,29,.25), 0 20px 40px -20px rgba(0,0,0,.9);">
            
            <div class="relative group overflow-hidden rounded-[2px] border border-[#3c2c15]">
                <img src="/images/fade-cut-closeup.jpg" alt="Barber đang cắt tóc fade cho khách" 
                     class="w-full h-64 sm:h-80 object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0b0805]/80 via-transparent to-transparent"></div>
            </div>

            <div>
                <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Đúng tay nghề &middot; Chuẩn phong cách</span>
                <h1 class="font-['Bebas_Neue'] text-4xl sm:text-5xl tracking-wider text-[#f2d788] uppercase mt-1 leading-tight">
                    Tâm Barbershop
                </h1>
                <p class="mt-3 text-xs sm:text-sm text-[#f4ecd8]/80 leading-relaxed">
                    Đến với chúng tôi để trải nghiệm quy trình chăm sóc tóc &amp; râu chuyên nghiệp, tận hưởng không gian thư giãn cổ điển sang trọng.
                </p>

                <div class="mt-6 flex items-center gap-4">
                    <a href="{{ route('booking.create') }}" 
                       class="inline-flex items-center gap-2 rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-6 py-3 text-xs font-bold uppercase tracking-wider text-[#0b0805] shadow-lg transition-all hover:brightness-110 active:scale-[0.99]">
                        <i class="fa-solid fa-scissors"></i>
                        <span>Đặt lịch ngay</span>
                    </a>
                    <a href="{{ route('services.index') }}" 
                       class="inline-flex items-center gap-2 rounded-[2px] border border-[#3c2c15] bg-[#251b0e] px-5 py-3 text-xs font-bold uppercase tracking-wider text-[#f2d788] transition-all hover:border-[#8a641d]">
                        <span>Bảng giá</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- BARBER POLE LINE -->
        <div class="h-[2px] w-full bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>

        {{-- 2. KIỂU TÓC NỔI BẬT --}}
        <section class="space-y-4">
            <div class="flex items-center justify-between border-b border-[#3c2c15] pb-3">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Bộ sưu tập</span>
                    <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">Kiểu tóc nổi bật</h2>
                </div>
                <a href="{{ route('hairstyles.index') }}" class="text-xs font-bold text-[#8a641d] hover:text-[#f2d788] hover:underline flex items-center gap-1">
                    <span>Xem tất cả</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @forelse ($featuredHairstyles as $hairstyle)
                    <div class="group rounded-[2px] border border-[#3c2c15] bg-[#171008] p-3 transition-all hover:border-[#8a641d]">
                        <a href="{{ route('hairstyles.show', $hairstyle->slug) }}" class="block">
                            <div class="overflow-hidden rounded-[2px] mb-2.5 h-36 bg-[#0b0805]">
                                <img src="{{ $hairstyle->image ?? '/images/fade-cut-closeup.jpg' }}" alt="{{ $hairstyle->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                            <div class="font-semibold text-xs text-[#f4ecd8] group-hover:text-[#f2d788] transition-colors truncate text-center">
                                {{ $hairstyle->name }}
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center text-xs text-[#6f6248]">
                        Danh sách kiểu tóc đang được cập nhật.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- BARBER POLE LINE -->
        <div class="h-[2px] w-full bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>

        {{-- 3. DỊCH VỤ --}}
        <section class="space-y-4">
            <div class="flex items-center justify-between border-b border-[#3c2c15] pb-3">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Dành cho bạn</span>
                    <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">Dịch vụ của chúng tôi</h2>
                </div>
                <a href="{{ route('services.index') }}" class="text-xs font-bold text-[#8a641d] hover:text-[#f2d788] hover:underline flex items-center gap-1">
                    <span>Toàn bộ bảng giá</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="space-y-3">
                @forelse ($services as $service)
                    <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-4 transition-colors hover:border-[#8a641d]/60 flex items-center justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-[2px] border border-[#8a641d]/40 bg-[#0b0805] text-[#8a641d] mt-0.5">
                                <i class="fa-solid fa-scissors text-xs"></i>
                            </div>
                            <div>
                                <div class="font-bold text-sm text-[#f4ecd8]">{{ $service->name }}</div>
                                <div class="text-xs text-[#6f6248] mt-0.5 leading-relaxed line-clamp-1">{{ $service->description }}</div>
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            <div class="font-['Bebas_Neue'] text-xl tracking-wider text-[#f2d788]">
                                {{ number_format((float) $service->price, 0, ',', '.') }}đ
                            </div>
                            <div class="text-[10px] text-[#6f6248] uppercase tracking-wider flex items-center justify-end gap-1">
                                <i class="fa-regular fa-clock text-[9px]"></i>
                                {{ $service->duration_minutes }} phút
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-[#6f6248]">
                        Danh sách dịch vụ đang được cập nhật.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- BARBER POLE LINE -->
        <div class="h-[2px] w-full bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>

        {{-- 4. ĐÁNH GIÁ KHÁCH HÀNG --}}
        <section class="space-y-4">
            <div class="border-b border-[#3c2c15] pb-3">
                <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Phản hồi thực tế</span>
                <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">Khách hàng nói gì về chúng tôi</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse ($reviews as $review)
                    <blockquote class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-4 text-xs text-[#f4ecd8]/90 italic flex flex-col justify-between">
                        <p class="mb-3 leading-relaxed">"{{ $review->comment }}"</p>
                        <div class="flex items-center justify-between not-italic pt-2 border-t border-[#3c2c15]/50">
                            <span class="font-bold text-[#f2d788]">{{ $review->customer_name }}</span>
                            <span class="text-[11px] text-[#8a641d] font-bold">
                                <i class="fa-solid fa-star text-[10px] text-[#f2d788]"></i> {{ $review->rating }}/5
                            </span>
                        </div>
                    </blockquote>
                @empty
                    <p class="text-xs text-[#6f6248]">Chưa có đánh giá nào.</p>
                @endforelse
            </div>
        </section>

        <!-- BARBER POLE LINE -->
        <div class="h-[2px] w-full bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>

        {{-- 5. BÀI VIẾT MỚI --}}
        <section class="space-y-4">
            <div class="flex items-center justify-between border-b border-[#3c2c15] pb-3">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Góc chia sẻ</span>
                    <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">Kiến thức &amp; Tin tức</h2>
                </div>
                <a href="{{ route('blog.index') }}" class="text-xs font-bold text-[#8a641d] hover:text-[#f2d788] hover:underline flex items-center gap-1">
                    <span>Xem thêm bài viết</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="space-y-3">
                @forelse ($latestPosts as $post)
                    <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-4 transition-colors hover:border-[#8a641d]/60">
                        <a href="{{ route('blog.show', $post->slug) }}" class="block text-sm font-bold text-[#f4ecd8] hover:text-[#f2d788] transition-colors">
                            {{ $post->title }}
                        </a>
                        <p class="text-xs text-[#6f6248] mt-1 line-clamp-2 leading-relaxed">
                            {{ $post->excerpt }}
                        </p>
                    </div>
                @empty
                    <p class="text-xs text-[#6f6248]">Chưa có bài viết nào.</p>
                @endforelse
            </div>
        </section>

    </div>

    <!-- CỘT PHẢI - SIDEBAR SỰ KIỆN -->
    <aside class="w-full lg:w-1/4 shrink-0 rounded-[2px] border border-[#3c2c15] bg-[#171008] p-5 shadow-2xl space-y-4 sticky top-24"
           style="box-shadow: 0 0 0 1px rgba(138,100,29,.2), 0 10px 25px -10px rgba(0,0,0,.8);">
        
        <div class="border-b border-[#3c2c15] pb-2.5 flex items-center justify-between">
            <h2 class="font-['Bebas_Neue'] text-xl tracking-wider text-[#f2d788] uppercase">
                Trạng thái &amp; Sự kiện
            </h2>
            <i class="fa-solid fa-bullhorn text-[#8a641d] text-sm"></i>
        </div>

        <div class="divide-y divide-[#3c2c15] space-y-3">
            @forelse ($announcements as $announcement)
                <div class="pt-3 first:pt-0">
                    @if ($announcement->is_pinned)
                        <span class="inline-block rounded-[2px] bg-[#8a641d]/20 border border-[#8a641d] px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-[#f2d788] mb-1.5">
                            📌 Ghim
                        </span>
                    @endif

                    @if ($announcement->image)
                        <a href="{{ route('announcements.show', $announcement) }}" class="block mb-2 overflow-hidden rounded-[2px] border border-[#3c2c15]">
                            <img src="{{ $announcement->image }}" alt="" class="w-full h-28 object-cover transition-transform hover:scale-105">
                        </a>
                    @endif

                    <a href="{{ route('announcements.show', $announcement) }}" class="block text-xs font-semibold text-[#f4ecd8] hover:text-[#f2d788] transition-colors leading-snug">
                        {{ $announcement->title ?: \Illuminate\Support\Str::limit($announcement->content, 60) }}
                    </a>

                    <div class="mt-2 text-[10px] text-[#6f6248] space-y-0.5">
                        @if ($announcement->event_at)
                            <p class="text-[#f2d788] font-medium flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[9px]"></i>
                                {{ $announcement->event_at->format('H:i d/m/Y') }}
                            </p>
                        @endif
                        <p>
                            {{ $announcement->created_at->diffForHumans() }} &middot; {{ $announcement->comments_count }} bình luận
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-xs text-[#6f6248] py-2">Chưa có trạng thái hoặc sự kiện nào.</p>
            @endforelse
        </div>

        <div class="pt-3 border-t border-[#3c2c15]">
            <a href="{{ route('announcements.index') }}" 
               class="inline-flex w-full items-center justify-center gap-1.5 rounded-[2px] border border-[#3c2c15] bg-[#251b0e] py-2 text-[11px] font-bold uppercase tracking-wider text-[#f2d788] transition-all hover:border-[#8a641d]">
                <span>Xem tất cả sự kiện</span>
                <i class="fa-solid fa-arrow-right text-[9px]"></i>
            </a>
        </div>
    </aside>

</div>

@endsection