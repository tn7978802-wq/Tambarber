@extends('layouts.app')

@section('title', ($announcement->title ?: 'Trạng thái') . ' - Barbershop')

@section('content')

    <div class="max-w-4xl mx-auto px-4 py-4">
        <!-- Nút Quay lại -->
        <a href="{{ route('announcements.index') }}" class="inline-flex items-center text-xs font-semibold text-[#6f6248] hover:text-[#f2d788] transition mb-6">
            &larr; Quay lại Trạng thái &amp; Sự kiện
        </a>

        <!-- Khung Bài viết Chính -->
        <article class="bg-[#171008] border border-[#3c2c15] p-6 rounded-sm shadow-[0_0_0_1px_rgba(207,159,63,0.35),0_18px_40px_-20px_rgba(0,0,0,0.8)] mb-10">
            @if ($announcement->title)
                <h1 class="text-2xl md:text-3xl font-bold text-[#f2d788] uppercase tracking-wide mb-4">
                    {{ $announcement->title }}
                </h1>
            @endif

            <!-- Hình ảnh bài viết (Đã khống chế chiều cao, ôm sát khung) -->
            @if ($announcement->image)
                <div class="mb-6 rounded-sm overflow-hidden border border-[#3c2c15] bg-[#0b0805] max-h-[500px] flex items-center justify-center">
                    <img 
                        src="{{ asset($announcement->image) }}" 
                        alt="{{ $announcement->title ?? 'Hình ảnh' }}" 
                        class="w-full h-auto max-h-[500px] object-contain"
                    >
                </div>
            @endif

            <!-- Nội dung bài viết -->
            <div class="text-[#f4ecd8] text-sm md:text-base leading-relaxed mb-6 space-y-2">
                {!! nl2br(e($announcement->content)) !!}
            </div>

            <!-- Thời gian sự kiện (nếu có) -->
            @if ($announcement->event_at)
                <div class="inline-block px-3 py-1.5 bg-[#0b0805] border border-[#3c2c15] text-xs text-[#f2d788] rounded-sm mb-4">
                    🗓️ Sự kiện diễn ra lúc: <strong>{{ $announcement->event_at->format('H:i d/m/Y') }}</strong>
                </div>
            @endif

            <!-- Meta Tác giả & Ngày đăng -->
            <div class="text-xs text-[#6f6248] border-t border-[#3c2c15] pt-4">
                Đăng bởi <strong class="text-[#cf9f3f] font-medium">{{ $announcement->user->fullname ?? 'Barbershop' }}</strong> &middot; {{ $announcement->created_at->format('H:i d/m/Y') }}
            </div>
        </article>

        <!-- Divider phân cách bình luận -->
        <div class="h-1 w-full my-8 rounded-full bg-[repeating-linear-gradient(-45deg,#7c1f22_0_14px,#f4ecd8_14px_28px,#171008_28px_42px)] opacity-50"></div>

        <!-- Khung Bình luận -->
        <section id="binh-luan" class="space-y-6">
            <div>
                <h2 class="text-xl font-bold text-[#f2d788] uppercase tracking-wide">
                    Bình luận <span class="text-sm font-normal text-[#6f6248]">({{ $announcement->comments->count() }})</span>
                </h2>
                <p class="text-xs text-[#6f6248] mt-1">Ai cũng có thể bình luận tại đây, kể cả khi chưa có tài khoản.</p>
            </div>

            <!-- Form tạo bình luận chính -->
            <form action="{{ route('announcements.comment', $announcement) }}" method="POST" class="bg-[#171008] border border-[#3c2c15] p-5 rounded-sm space-y-4">
                @csrf

                @guest
                    <div>
                        <label for="main_guest_name" class="block text-xs font-medium text-[#6f6248] mb-1">Tên của bạn:</label>
                        <input 
                            id="main_guest_name"
                            type="text" 
                            name="guest_name" 
                            value="{{ old('guest_name') }}" 
                            required 
                            placeholder="Nhập tên của bạn..."
                            class="w-full px-3 py-2 bg-[#0b0805] border border-[#3c2c15] text-[#f4ecd8] text-sm rounded-sm focus:outline-none focus:border-[#cf9f3f] placeholder-[#6f6248]/50"
                        >
                    </div>
                @endguest

                <div>
                    <label for="main_comment_content" class="block text-xs font-medium text-[#6f6248] mb-1">Bình luận:</label>
                    <textarea 
                        id="main_comment_content"
                        name="content" 
                        rows="3" 
                        required 
                        placeholder="Viết ý kiến của bạn..."
                        class="w-full px-3 py-2 bg-[#0b0805] border border-[#3c2c15] text-[#f4ecd8] text-sm rounded-sm focus:outline-none focus:border-[#cf9f3f] placeholder-[#6f6248]/50 resize-y"
                    >{{ old('content') }}</textarea>
                </div>

                <button 
                    type="submit" 
                    class="py-2 px-5 bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] text-[#0b0805] font-semibold text-xs uppercase tracking-wider rounded-sm hover:brightness-110 active:scale-[0.99] transition"
                >
                    Gửi bình luận
                </button>
            </form>

            <!-- Danh sách Bình luận & Trả lời -->
            <div class="space-y-4 mt-6">
                @forelse ($announcement->comments as $comment)
                    <!-- BÌNH LUẬN GỐC -->
                    <div class="bg-[#171008] border border-[#3c2c15] p-4 rounded-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <strong class="text-sm font-semibold text-[#f2d788]">{{ $comment->display_name }}</strong>
                            <span class="text-xs text-[#6f6248]">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>

                        <p class="text-sm text-[#f4ecd8] leading-relaxed">{{ $comment->content }}</p>

                        <!-- NÚT & FORM TRẢ LỜI -->
                        <div class="pt-2">
                            <!-- Nút ẩn/hiện form -->
                            <button 
                                type="button" 
                                onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')" 
                                class="text-xs text-[#cf9f3f] hover:underline focus:outline-none font-medium"
                            >
                                Trả lời
                            </button>

                            <!-- Form trả lời (ẩn theo mặc định) -->
                            <div id="reply-form-{{ $comment->id }}" class="hidden mt-3 pl-4 border-l-2 border-[#cf9f3f]/50 space-y-3">
                                <form action="{{ route('announcements.comment', $announcement) }}" method="POST" class="space-y-3">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    
                                    @guest
                                        <div>
                                            <label class="block text-xs text-[#6f6248] mb-1">Tên của bạn:</label>
                                            <input 
                                                type="text" 
                                                name="guest_name" 
                                                required 
                                                placeholder="Tên của bạn..."
                                                class="w-full px-3 py-1.5 bg-[#0b0805] border border-[#3c2c15] text-[#f4ecd8] text-xs rounded-sm focus:outline-none focus:border-[#cf9f3f]"
                                            >
                                        </div>
                                    @endguest

                                    <div>
                                        <textarea 
                                            name="content" 
                                            rows="2" 
                                            placeholder="Viết phản hồi của bạn..." 
                                            required 
                                            class="w-full px-3 py-1.5 bg-[#0b0805] border border-[#3c2c15] text-[#f4ecd8] text-xs rounded-sm focus:outline-none focus:border-[#cf9f3f] resize-y"
                                        ></textarea>
                                    </div>
                                    
                                    <div class="flex items-center gap-3">
                                        <button 
                                            type="submit" 
                                            class="py-1 px-3 bg-[#cf9f3f] text-[#0b0805] font-semibold text-xs rounded-sm hover:bg-[#f2d788] transition"
                                        >
                                            Gửi trả lời
                                        </button>
                                        <button 
                                            type="button" 
                                            onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.add('hidden')"
                                            class="text-xs text-[#6f6248] hover:text-[#f4ecd8] transition"
                                        >
                                            Hủy
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- CÁC CÂU TRẢ LỜI CẤP CON -->
                            @if ($comment->replies && $comment->replies->count() > 0)
                                <div class="mt-4 pl-4 border-l-2 border-[#3c2c15] space-y-3">
                                    @foreach ($comment->replies as $reply)
                                        <div class="bg-[#0b0805] p-3 rounded-sm border border-[#3c2c15]">
                                            <div class="flex items-center justify-between mb-1">
                                                <strong class="text-xs font-semibold text-[#f2d788]">{{ $reply->display_name }}</strong>
                                                <span class="text-[11px] text-[#6f6248]">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-xs text-[#f4ecd8] leading-relaxed">{{ $reply->content }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 bg-[#171008] border border-[#3c2c15] rounded-sm">
                        <p class="text-xs text-[#6f6248]">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

@endsection