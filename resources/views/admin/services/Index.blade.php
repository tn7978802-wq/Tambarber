@extends('layouts.admin')

@section('title', 'Quản lý Dịch vụ')

@section('content')

    <h1>Quản lý Dịch vụ</h1>

    <h2>Thêm dịch vụ mới</h2>
    <form action="{{ route('admin.services.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Tên dịch vụ" required>
        <input type="number" name="price" placeholder="Giá (VND)" required>
        <input type="number" name="duration_minutes" placeholder="Thời gian (phút)" required>
        <input type="text" name="description" placeholder="Mô tả">
        <label><input type="checkbox" name="is_active" value="1" checked> Đang hoạt động</label>
        <button type="submit">Thêm</button>
    </form>

    <hr>

    <table border="1" cellpadding="8">
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
                    <td>{{ number_format((float) $service->price, 0, ',', '.') }}đ</td>
                    <td>{{ $service->duration_minutes }} phút</td>
                    <td>{{ $service->is_active ? 'Hoạt động' : 'Tạm ẩn' }}</td>
                    <td>
                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" style="display:inline" onsubmit="return confirm('Xoá dịch vụ này?')">
                            @csrf @method('DELETE')
                            <button type="submit">Xoá</button>
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