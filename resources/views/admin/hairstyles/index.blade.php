@extends('layouts.admin')

@section('title', 'Quản lý Kiểu tóc')

@section('content')

    <span class="section-eyebrow">Quản trị</span>
    <h1>Quản lý Kiểu tóc</h1>
    <div class="pole-divider small" style="margin-left:0;"></div>

    <h2>Thêm kiểu tóc mới</h2>
    <form action="{{ route('admin.hairstyles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>
            <input class="px-3 py-2 border rounded text-sm w-full" type="text" name="name" placeholder="Tên kiểu tóc" required>
        </label>

        {{-- Nút "+" chọn ảnh: bấm vào sẽ mở hộp thoại duyệt file của máy (ổ C:...) để chọn ảnh,
             thay vì phải gõ tay đường dẫn ảnh có sẵn trên server. --}}
        <div class="image-picker">
            <label for="hairstyle-image-input" class="image-picker-btn">➕ Chọn ảnh từ máy</label>
            <input class="px-3 py-2 border rounded text-sm w-full" type="file" id="hairstyle-image-input" name="image" accept="image/*" onchange="document.getElementById('hairstyle-image-filename').textContent = this.files[0] ? this.files[0].name : '';">
            <span id="hairstyle-image-filename" class="image-picker-filename"></span>
        </div>

        <input class="px-3 py-2 border rounded text-sm w-full" type="text" name="suitable_face_shapes" placeholder="Khuôn mặt phù hợp">
        <select class="px-3 py-2 border rounded text-sm w-full" name="difficulty" required>
            <option value="easy">Dễ</option>
            <option value="medium" selected>Trung bình</option>
            <option value="hard">Khó</option>
        </select>
        <input class="px-3 py-2 border rounded text-sm w-full" type="number" name="reference_price" placeholder="Giá tham khảo (VND)">
        <textarea class="px-3 py-2 border rounded text-sm w-full" name="description" placeholder="Mô tả" style="min-height:42px;"></textarea>
        <button type="submit" class="btn btn-gold">Thêm</button>
    </form>

    <table class="data-table w-full bg-white rounded-lg overflow-hidden mb-4">
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Độ khó</th>
                <th>Giá tham khảo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hairstyles as $hairstyle)
                <tr>
                    <td>
                        @if ($hairstyle->image)
                            <img src="{{ $hairstyle->image }}" alt="{{ $hairstyle->name }}" width="80">
                        @endif
                    </td>
                    <td>{{ $hairstyle->name }}</td>
                    <td>{{ $hairstyle->difficulty }}</td>
                    <td class="price">
                        {{ $hairstyle->reference_price ? number_format((float) $hairstyle->reference_price, 0, ',', '.') . 'đ' : '—' }}
                    </td>
                    <td>
                        <form action="{{ route('admin.hairstyles.destroy', $hairstyle) }}" method="POST" onsubmit="return confirm('Xoá kiểu tóc này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Chưa có kiểu tóc nào.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $hairstyles->links() }}

@endsection
