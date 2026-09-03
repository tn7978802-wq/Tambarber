@extends('layouts.admin')

@section('title', 'Trạng thái & Sự kiện')

@section('content')

    <h1>Trạng thái &amp; Sự kiện</h1>
    <p><small>Nội dung đăng ở đây sẽ hiện ở khung bên phải Trang chủ và cho phép tất cả mọi người vào bình luận.</small></p>

    <h2>Đăng trạng thái/sự kiện mới</h2>
    <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Tiêu đề
            <input class="px-3 py-2 border rounded text-sm w-full" type="text" name="title" value="{{ old('title') }}">
        </label>

        <label>Nội dung
            <textarea class="px-3 py-2 border rounded text-sm w-full" name="content" rows="4" cols="50" required>{{ old('content') }}</textarea>
        </label>

        {{-- Nút "+" chọn ảnh: mở hộp thoại duyệt file của máy (ổ C:...) để chọn ảnh minh hoạ. --}}
        <div class="image-picker">
            <label for="announcement-image-input" class="image-picker-btn">➕ Chọn ảnh từ máy</label>
            <input class="px-3 py-2 border rounded text-sm w-full" type="file" id="announcement-image-input" name="image" accept="image/*" onchange="document.getElementById('announcement-image-filename').textContent = this.files[0] ? this.files[0].name : '';">
            <span id="announcement-image-filename" class="image-picker-filename"></span>
        </div>

        <label>Thời gian sự kiện (không bắt buộc, để trống nếu chỉ là thông báo/trạng thái):
            <input class="px-3 py-2 border rounded text-sm w-full" type="datetime-local" name="event_at" value="{{ old('event_at') }}">
        </label>

        <label><input class="px-3 py-2 border rounded text-sm w-full" type="checkbox" name="is_pinned" value="1"> Ghim lên đầu</label>

        <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700" type="submit">Đăng</button>
    </form>

    <hr>

    <h2>Danh sách đã đăng</h2>

    <table>
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Tiêu đề / Nội dung</th>
                <th>Sự kiện lúc</th>
                <th>Bình luận</th>
                <th>Đăng lúc</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($announcements as $announcement)
                <tr>
                    <td>
                        @if ($announcement->image)
                            <img src="{{ $announcement->image }}" alt="" width="80">
                        @endif
                    </td>
                    <td>
                        @if ($announcement->is_pinned) 📌 @endif
                        <strong>{{ $announcement->title }}</strong>
                        <br>{{ \Illuminate\Support\Str::limit($announcement->content, 80) }}
                    </td>
                    <td>{{ $announcement->event_at?->format('H:i d/m/Y') ?? '—' }}</td>
                    <td>{{ $announcement->comments_count }}</td>
                    <td>{{ $announcement->created_at->format('H:i d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('announcements.show', $announcement) }}" target="_blank">Xem</a>
                        <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" style="display:inline" onsubmit="return confirm('Xoá bài đăng này?')">
                            @csrf @method('DELETE')
                            <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700" type="submit">Xoá</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Chưa có bài đăng nào.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $announcements->links() }}

@endsection

