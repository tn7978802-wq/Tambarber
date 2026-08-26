@extends('layouts.admin')

@section('title', 'Quản lý Barber')

@section('content')

    <h1>Quản lý Barber</h1>

    <h2>Thêm barber mới</h2>
    <form action="{{ route('admin.barbers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Tên barber<strong></strong>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </label>

        <label>Chức danh
            <input type="text" name="title" value="{{ old('title') }}">
        </label>

        <label>Số năm kinh nghiệm:
            <input type="number" name="years_experience" min="0" max="80" value="{{ old('years_experience') }}">
        </label>

        {{-- Nút "+" chọn ảnh: bấm vào sẽ mở hộp thoại duyệt file của máy (ổ C:...) để chọn ảnh. --}}
        <div class="image-picker">
            <label for="avatar-input" class="image-picker-btn">➕ Chọn ảnh đại diện (không bắt buộc)</label>
            <input type="file" id="avatar-input" name="avatar" accept="image/*" onchange="document.getElementById('avatar-filename').textContent = this.files[0] ? this.files[0].name : '';">
            <span id="avatar-filename" class="image-picker-filename"></span>
        </div>

        <label>Giới thiệu / tiểu sử (không bắt buộc):
            <textarea name="bio" rows="3" cols="50">{{ old('bio') }}</textarea>
        </label>

        <label><input type="checkbox" name="is_active" value="1" checked> Đang hoạt động (hiển thị cho khách đặt lịch)</label>

        <button type="submit">Thêm barber</button>
    </form>

    <hr>

    <h2>Danh sách barber</h2>

    <table>
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Chức danh</th>
                <th>Kinh nghiệm</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barbers as $barber)
                <tr>
                    <td>
                        @if ($barber->avatar)
                            <img src="{{ $barber->avatar }}" alt="{{ $barber->name }}" width="80">
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $barber->name }}</td>
                    <td>{{ $barber->title ?? '—' }}</td>
                    <td>{{ $barber->years_experience ? $barber->years_experience . ' năm' : '—' }}</td>
                    <td>{{ $barber->is_active ? 'Đang hoạt động' : 'đang nghỉ phép' }}</td>
                    <td>
                        {{-- Bật/tắt trạng thái hoạt động nhanh: chỉ gửi các field text, không đụng tới
                             ảnh nên avatar cũ luôn được giữ nguyên (không gửi field 'avatar' ở đây vì
                             nó giờ là kiểu file, không thể gán giá trị có sẵn qua input ẩn). --}}
                        <form action="{{ route('admin.barbers.update', $barber) }}" method="POST" style="display:inline">
                            @csrf @method('PUT')
                            <input type="hidden" name="name" value="{{ $barber->name }}">
                            <input type="hidden" name="title" value="{{ $barber->title }}">
                            <input type="hidden" name="years_experience" value="{{ $barber->years_experience }}">
                            <input type="hidden" name="bio" value="{{ $barber->bio }}">
                            <input type="hidden" name="is_active" value="{{ $barber->is_active ? 0 : 1 }}">
                            <button type="submit">{{ $barber->is_active ? 'Tạm ngưng' : 'Hoạt Động' }}</button>
                        </form>

                        <form action="{{ route('admin.barbers.destroy', $barber) }}" method="POST" style="display:inline" onsubmit="return confirm('Xoá barber này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger">Xoá</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Chưa có barber nào.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $barbers->links() }}

@endsection
