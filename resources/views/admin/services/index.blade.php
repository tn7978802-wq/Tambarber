@extends('layouts.admin')

@section('title', 'Quản lý Dịch vụ')

@section('content')

    <span class="section-eyebrow">Quản trị</span>
    <h1>Quản lý Dịch vụ</h1>
    <div class="pole-divider small" style="margin-left:0;"></div>

    <h2>Thêm dịch vụ mới</h2>
    <form action="{{ route('admin.services.store') }}" method="POST" class="form-inline">
        @csrf
        <input type="text" name="name" placeholder="Tên dịch vụ" required>
        <input type="number" name="price" placeholder="Giá (VND)" required>
        <input type="number" name="duration_minutes" placeholder="Thời gian (phút)" required>
        <input type="text" name="description" placeholder="Mô tả">
        <label><input type="checkbox" name="is_active" value="1" checked> Đang hoạt động</label>
        <button type="submit" class="btn btn-gold">Thêm</button>
    </form>

    <table class="data-table">
        <thead>
            <tr>
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