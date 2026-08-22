@extends('layouts.admin')

@section('title', 'Quản lý tối cao')

@section('content')

    <span class="section-eyebrow">Khu vực đặc quyền</span>
    <h1>Khu vực chủ tiệm (System Owner)</h1>
    <p class="muted">Khu vực dành riêng cho Chủ Tiệm — toàn quyền kiểm soát hệ thống và phân quyền nhân sự.</p>
    <div class="pole-divider small" style="margin-left:0;"></div>

    <h2>Thống kê tổng quan</h2>
    <ul class="metric-grid">
        <li class="metric-card"><span class="metric-label">Tổng số người dùng</span><span class="metric-value">{{ number_format($stats['total_users']) }}</span></li>
        <li class="metric-card"><span class="metric-label">Nhân sự có quyền quản trị</span><span class="metric-value">{{ number_format($stats['total_admins']) }}</span></li>
        <li class="metric-card"><span class="metric-label">Tổng doanh thu</span><span class="metric-value">{{ number_format($stats['total_revenue'], 0, ',', '.') }}đ</span></li>
        <li class="metric-card"><span class="metric-label">Đăng ký hôm nay</span><span class="metric-value">{{ number_format($stats['new_users_today']) }}</span></li>
        <li class="metric-card"><span class="metric-label">Lịch hẹn hôm nay</span><span class="metric-value">{{ number_format($stats['bookings_today']) }}</span></li>
        <li class="metric-card"><span class="metric-label">Liên hệ chưa xử lý</span><span class="metric-value">{{ number_format($stats['pending_contact_messages']) }}</span></li>
    </ul>

    <h2>Dịch vụ được đặt nhiều nhất</h2>
    <ol class="ranked-list">
        @forelse ($topServices as $service)
            <li><span>{{ $service->name }}</span> <strong>{{ $service->total_bookings }} lượt đặt</strong></li>
        @empty
            <li>Chưa có dữ liệu.</li>
        @endforelse
    </ol>

    @if (auth()->user()->isRootOwner())
        <div class="pole-divider"></div>
        <section style="border:1px solid var(--rosewood-br); border-radius:6px; padding:1.5rem;">
            <h2>Hội đồng Quản lý tối cao <span class="muted" style="font-family:var(--font-body); font-size:.75rem; text-transform:none;">(chỉ Chủ Tiệm gốc mới thấy mục này)</span></h2>

            <h3>Thăng chức Quản lý tối cao</h3>
            <form action="{{ route('admin.system-owner.sub-owners.store') }}" method="POST" class="form-inline">
                @csrf
                <input type="email" name="email" placeholder="Email nhân sự..." required>
                <input type="text" name="note" placeholder="Ghi chú (vd: Quản lý chi nhánh 2)">
                <button type="submit" class="btn btn-gold">Thăng chức</button>
            </form>

            <h3>Danh sách Quản lý tối cao hiện tại</h3>
            <ul class="ranked-list">
                @forelse ($subOwners as $sub)
                    <li>
                        <span>{{ $sub->email }} <span class="role-badge owner">{{ $sub->note ?: 'Quản lý tối cao' }}</span></span>
                        <form action="{{ route('admin.system-owner.sub-owners.destroy', $sub->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Tước chức</button>
                        </form>
                    </li>
                @empty
                    <li>Chưa có ai được thăng chức.</li>
                @endforelse
            </ul>
        </section>
    @endif

    <div class="pole-divider"></div>

    <h2>Quản lý phân quyền nhân sự</h2>
    <table class="data-table">
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
                            <span class="role-badge owner">Quản lý tối cao</span>
                        @elseif ($user->admin_role == \App\Models\User::ROLE_ADMIN)
                            <span class="role-badge">Nhân viên quản trị</span>
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
                            <em class="muted">Cấp độ tối cao</em>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}

@endsection