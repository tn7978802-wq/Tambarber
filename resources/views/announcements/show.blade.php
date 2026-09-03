@extends('layouts.app')

@section('title', ($announcement->title ?: 'Trạng thái') . ' - Barbershop')

@section('content')

    <a href="{{ route('announcements.index') }}">&larr; Quay lại Trạng thái &amp; Sự kiện</a>

    <article>
        @if ($announcement->title)
            <h1>{{ $announcement->title }}</h1>
        @endif

        @if ($announcement->image)
            <img src="{{ $announcement->image }}" alt="{{ $announcement->title }}" width="500">
        @endif

        <p>{!! nl2br(e($announcement->content)) !!}</p>

        @if ($announcement->event_at)
            <p>🗓️ Sự kiện diễn ra lúc: <strong>{{ $announcement->event_at->format('H:i d/m/Y') }}</strong></p>
        @endif

        <p><small>Đăng bởi {{ $announcement->user->fullname ?? 'Barbershop' }} &middot; {{ $announcement->created_at->format('H:i d/m/Y') }}</small></p>
    </article>

    <hr id="binh-luan">

    <h2>Bình luận ({{ $announcement->comments->count() }})</h2>
    <p><small>Ai cũng có thể bình luận tại đây, kể cả khi chưa có tài khoản.</small></p>

    <form action="{{ route('announcements.comment', $announcement) }}" method="POST">
        @csrf

        @guest
            <label>Tên của bạn:
                <input class="px-3 py-2 border rounded text-sm w-full" type="text" name="guest_name" value="{{ old('guest_name') }}" required>
            </label>
            <br>
        @endguest

        <label>Bình luận:
            <br>
            <textarea class="px-3 py-2 border rounded text-sm w-full" name="content" rows="3" cols="50" required>{{ old('content') }}</textarea>
        </label>
        <br>
        <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700" type="submit">Gửi bình luận</button>
    </form>

   <div class="comment-section">
        @forelse ($announcement->comments as $comment)
            <!-- BÌNH LUẬN GỐC -->
            <div class="comment-root" style="border-top:1px solid #ddd; padding:12px 0;">
                <div class="comment-info">
                    <strong style="color: #ffc107;">{{ $comment->display_name }}</strong>
                    <small style="color: #bbb; margin-left: 8px;">&middot; {{ $comment->created_at->diffForHumans() }}</small>
                </div>
                <p class="comment-text" style="margin: 8px 0; color: #f8f9fa;">{{ $comment->content }}</p>

                <!-- NÚT TRẢ LỜI & PHẢN HỒI -->
                <div class="comment-actions" style="margin-left: 20px;">
                    <!-- Nút bấm ẩn/hiện form -->
                    <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700" type="button" 
                        onclick="document.getElementById('reply-form-{{ $comment->id }}').style.display = 'block'" 
                        style="background: transparent; border: none; color: #ddd; font-size: 13px; cursor: pointer; text-decoration: underline; padding: 0;">
                        Trả lời
                    </button>

                    <!-- Form trả lời (ẩn theo mặc định) -->
                    <div id="reply-form-{{ $comment->id }}" style="display: none; margin-top: 10px; border-left: 2px solid #555; padding-left: 10px;">
                        <form action="{{ route('announcements.comment', $announcement) }}" method="POST">
                            @csrf
                            <input class="px-3 py-2 border rounded text-sm w-full" type="hidden" name="parent_id" value="{{ $comment->id }}">
                            
                            @guest
                                <div style="margin-bottom: 8px;">
                                    <label style="color: #ddd; font-size: 13px;">Tên của bạn:
                                        <input class="px-3 py-2 border rounded text-sm w-full" type="text" name="guest_name" required style="background: #222; border: 1px solid #444; color: #fff; padding: 4px;">
                                    </label>
                                </div>
                            @endguest

                            <div style="margin-bottom: 8px;">
                                <textarea class="px-3 py-2 border rounded text-sm w-full" name="content" rows="2" placeholder="Viết phản hồi của bạn..." required 
                                    style="width: 100%; background: #222; border: 1px solid #444; color: #fff; padding: 8px; box-sizing: border-box;"></textarea>
                            </div>
                            
                            <div class="form-actions">
                                <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700" type="submit" style="background: #ffc107; color: #000; border: none; padding: 5px 10px; cursor: pointer;">Gửi trả lời</button>
                                <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700" type="button" 
                                    onclick="document.getElementById('reply-form-{{ $comment->id }}').style.display = 'none'"
                                    style="background: transparent; color: #aaa; border: none; padding: 5px 10px; cursor: pointer; text-decoration: underline;">
                                    Hủy
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- HIỂN THỊ CÁC CÂU TRẢ LỜI (NẾU CÓ) -->
                    @if ($comment->replies && $comment->replies->count() > 0)
                        <div class="replies-list" style="margin-top: 15px;">
                            @foreach ($comment->replies as $reply)
                                <div class="comment-reply" style="border-left: 2px solid #555; padding-left: 12px; margin-bottom: 12px;">
                                    <div class="reply-info">
                                        <strong style="color: #ffc107;">{{ $reply->display_name }}</strong>
                                        <small style="color: #bbb; margin-left: 8px;">&middot; {{ $reply->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="reply-text" style="margin: 5px 0; color: #f8f9fa;">{{ $reply->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p style="color: #aaa; text-align: center; margin-top: 20px;">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
        @endforelse
    </div>

@endsection

