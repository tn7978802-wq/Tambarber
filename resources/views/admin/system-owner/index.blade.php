@extends('layouts.admin')

@section('title', 'Quản lý tối cao')

@section('content')

    <h1>Quản lý tối cao (System Owner)</h1>
    <p>Khu vực dành riêng cho Chủ Tiệm — toàn quyền kiểm soát hệ thống và phân quyền nhân sự.</p>

    <h2>Thống kê tổng quan</h2>
    <ul>
        <li>Tổng số người dùng: {{ number_format($stats['total_users']) }}</li>
        <li>Tổng số nhân sự có quyền quản trị: {{ number_format($stats['total_admins']) }}</li>
        <li>Tổng doanh thu (lịch đã hoàn thành): {{ number_format($stats['total_revenue'], 0, ',', '.') }}đ</li>
        <li>Khách hàng đăng ký hôm nay: {{ number_format($stats['new_users_today']) }}</li>
        <li>Lịch hẹn hôm nay: {{ number_format($stats['bookings_today']) }}</li>
        <li>Tin nhắn liên hệ chưa xử lý: {{ number_format($stats['pending_contact_messages']) }}</li>
    </ul>

    <h2>Dịch vụ được đặt nhiều nhất</h2>
    <ol>
        @forelse ($topServices as $service)
            <li>{{ $service->name }} - {{ $service->total_bookings }} lượt đặt</li>
        @empty
            <li>Chưa có dữ liệu.</li>
        @endforelse
    </ol>

    @if (auth()->user()->isRootOwner())
        <hr>
        <h2>Hội đồng Quản lý tối cao (chỉ Chủ Tiệm mới thấy mục này)</h2>

        <h3>Thăng chức Quản lý tối cao</h3>
        <form action="{{ route('admin.system-owner.sub-owners.store') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email nhân sự..." required>
            <input type="text" name="note" placeholder="Ghi chú (vd: Quản lý chi nhánh 2)">
            <button type="submit">Thăng chức</button>
        </form>

        <h3>Danh sách Quản lý tối cao hiện tại</h3>
        <ul>
            @forelse ($subOwners as $sub)
                <li>
                    {{ $sub->email }} ({{ $sub->note ?: 'Quản lý tối cao' }})
                    <form action="{{ route('admin.system-owner.sub-owners.destroy', $sub->id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger">Tước chức</button>
                    </form>
                </li>
            @empty
                <li>Chưa có ai được thăng chức.</li>
            @endforelse
        </ul>
    @endif

    <hr>

    <h2>Quản lý phân quyền nhân sự</h2>
    <table>
        <thead>
            <tr>
                <th>Thành viên</th>
                <th>Email / SĐT</th>
                <th>Vai trò hiện tại</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->fullname }}</td>
                    <td>{{ $user->email }}<br>{{ $user->phone }}</td>
                    <td>
                        @if ($user->isSystemOwner())
                            Quản lý tối cao
                        @elseif ($user->admin_role == \App\Models\User::ROLE_ADMIN)
                            Nhân viên quản trị
                        @elseif ($user->admin_role == \App\Models\User::ROLE_CLIENT)
                            Khách hàng
                        @else
                            Khách vãng lai
                        @endif
                    </td>
                    <td>
                        @if (! $user->isSystemOwner())
                            <form action="{{ route('admin.system-owner.update-role', $user->id) }}" method="POST">
                                @csrf @method('PUT')
                                <select name="admin_role" onchange="this.form.submit()">
                                    <option value="0" @selected($user->admin_role == 0)>0 - Khách vãng lai</option>
                                    <option value="1" @selected($user->admin_role == 1)>1 - Khách hàng</option>
                                    <option value="2" @selected($user->admin_role == 2)>2 - Nhân viên quản trị</option>
                                    @if (auth()->user()->isRootOwner())
                                        <option value="3" @selected($user->admin_role == 3)>3 - Quản lý tối cao</option>
                                    @endif
                                </select>
                            </form>
                        @else
                            <em>Cấp độ tối cao</em>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}

@endsection
