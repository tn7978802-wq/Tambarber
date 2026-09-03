@extends('layouts.admin')

@section('title', 'Quản lý Dịch vụ')

@section('content')

    <span class="section-eyebrow">Quản trị</span>
    <h1>Quản lý Dịch vụ</h1>
    <div class="pole-divider small" style="margin-left:0;"></div>

    <h2>Thêm dịch vụ mới</h2>
    <form action="{{ route('admin.services.store') }}" method="POST" class="form-inline">
        @csrf
        <input class="px-3 py-2 border rounded text-sm w-full" type="text" name="name" placeholder="Tên dịch vụ" required>
        <input class="px-3 py-2 border rounded text-sm w-full" type="number" name="price" placeholder="Giá (VND)" required>
        <input class="px-3 py-2 border rounded text-sm w-full" type="number" name="duration_minutes" placeholder="Thời gian (phút)" required>
        <input class="px-3 py-2 border rounded text-sm w-full" type="text" name="description" placeholder="Mô tả">

        {{-- Nút "+" chọn ảnh minh hoạ dịch vụ từ máy. --}}
        <label for="service-image-input" style="display:inline-block;border:1px dashed #999;padding:10px 16px;cursor:pointer;">
            ➕ Chọn ảnh từ máy
        </label>
        <input class="px-3 py-2 border rounded text-sm w-full" type="file" id="service-image-input" name="image" accept="image/*" style="display:none" onchange="document.getElementById('service-image-filename').textContent = this.files[0] ? this.files[0].name : '';">
        <span id="service-image-filename"></span>

        <label><input class="px-3 py-2 border rounded text-sm w-full" type="checkbox" name="is_active" value="1" checked> Đang hoạt động</label>
        <button type="submit" class="btn btn-gold">Thêm</button>
    </form>

    <hr>

    <table class="data-table w-full bg-white rounded-lg overflow-hidden mb-4">
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Thời gian</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($services as $service)
                <tr>
                    <td>
                        @if ($service->image)
                            <img src="{{ $service->image }}" alt="{{ $service->name }}" width="80">
                        @endif
                    </td>
                    <td>{{ $service->name }}</td>
                    <td class="price">{{ number_format((float) $service->price, 0, ',', '.') }}đ</td>
                    <td>{{ $service->duration_minutes }} phút</td>
                    <td><span class="status-pill {{ $service->is_active ? 'confirmed' : 'cancelled' }}">{{ $service->is_active ? 'Hoạt động' : 'Tạm ẩn' }}</span></td>
                    <td>
                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Xoá dịch vụ này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Chưa có dịch vụ nào.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $services->links() }}

@endsection
