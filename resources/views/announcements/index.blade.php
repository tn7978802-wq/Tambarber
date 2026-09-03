@extends('layouts.app')

@section('title', 'Trạng thái & Sự kiện - Barbershop')

@section('content')

    <div class="max-w-5xl mx-auto px-4 py-4">
        <!-- Eyebrow & Tiêu đề -->
        <span class="text-xs uppercase tracking-widest text-[#6f6248] font-medium block mb-1">Cập nhật tin tức</span>
        <h1 class="text-3xl md:text-4xl font-bold text-[#f2d788] uppercase tracking-wide mb-1">Trạng thái &amp; Sự kiện</h1>
        <p class="text-sm text-[#6f6248] mb-4">Cập nhật khuyến mãi, sự kiện và thông báo mới nhất từ tiệm.</p>

        <!-- Pole Divider -->
        <div class="h-1 w-full mb-8 rounded-full bg-[repeating-linear-gradient(-45deg,#7c1f22_0_14px,#f4ecd8_14px_28px,#171008_28px_42px)] shadow-md"></div>

        <!-- Danh sách bài viết dạng Lưới Thẻ (Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse ($announcements as $announcement)
                <article class="bg-[#171008] border border-[#3c2c15] rounded-sm p-5 shadow-[0_0_0_1px_rgba(207,159,63,0.2),0_10px_25px_-10px_rgba(0,0,0,0.8)] flex flex-col justify-between hover:border-[#cf9f3f] transition duration-200">
                    
                    <div>
                        <!-- Header bài viết: Ghim + Tác giả / Thời gian -->
                        <div class="flex items-center justify-between gap-2 mb-3">
                            @if ($announcement->is_pinned)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-0.5 rounded-full bg-[#7c1f22]/30 text-[#f2d788] border border-[#a8342f]">
                                    📌 Ghim
                                </span>
                            @else
                                <span></span>
                            @endif

                            <span class="text-xs text-[#6f6248]">
                                {{ $announcement->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <!-- Tiêu đề bài viết -->
                        @if ($announcement->title)
                            <h2 class="text-xl font-bold text-[#f2d788] mb-3 hover:text-[#cf9f3f] transition">
                                <a href="{{ route('announcements.show', $announcement) }}">
                                    {{ $announcement->title }}
                                </a>
                            </h2>
                        @endif

                        <!-- Hình ảnh đính kèm -->
                        @if ($announcement->image)
                            <div class="mb-4 rounded-sm overflow-hidden border border-[#3c2c15] bg-[#0b0805] max-h-72 flex items-center justify-center">
                                <img 
                                    src="{{ asset($announcement->image) }}" 
                                    alt="{{ $announcement->title ?? 'Hình ảnh thông báo' }}" 
                                    class="w-full h-auto max-h-72 object-cover hover:scale-105 transition duration-300"
                                >
                            </div>
                        @endif

                        <!-- Nội dung vắn tắt -->
                        <p class="text-[#f4ecd8] text-sm leading-relaxed mb-4">
                            {{ \Illuminate\Support\Str::limit($announcement->content, 200) }}
                        </p>
                    </div>

                    <!-- Footer bài viết: Thời gian sự kiện + Thông tin phụ + Link -->
                    <div class="pt-3 border-t border-[#3c2c15] space-y-2.5">
                        @if ($announcement->event_at)
                            <div class="inline-block px-2.5 py-1 bg-[#0b0805] border border-[#3c2c15] text-xs text-[#f2d788] rounded-sm">
                                🗓️ Sự kiện diễn ra lúc: <strong>{{ $announcement->event_at->format('H:i d/m/Y') }}</strong>
                            </div>
                        @endif

                        <div class="flex items-center justify-between text-xs text-[#6f6248]">
                            <span>
                                Đăng bởi <strong class="text-[#cf9f3f] font-medium">{{ $announcement->user->fullname ?? 'Barbershop' }}</strong>
                                &middot; {{ $announcement->comments_count }} bình luận
                            </span>

                            <a href="{{ route('announcements.show', $announcement) }}" class="text-[#f2d788] font-semibold hover:underline flex items-center gap-1">
                                Xem &amp; bình luận &rarr;
                            </a>
                        </div>
                    </div>

                </article>
            @empty
                <div class="col-span-full text-center py-12 bg-[#171008] border border-[#3c2c15] rounded-sm">
                    <p class="text-[#6f6248] text-sm">Chưa có trạng thái/sự kiện nào được đăng.</p>
                </div>
            @endforelse
        </div>

        <!-- Thanh phân trang (Pagination) -->
        @if ($announcements->hasPages())
            <div class="mt-8">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>

@endsection