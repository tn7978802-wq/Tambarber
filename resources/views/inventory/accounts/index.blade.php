@extends('layouts.admin')

@section('title', 'Quản lý tài khoản')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-blue-800">PHÂN QUYỀN HỆ THỐNG</p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Tài khoản đăng nhập</h1>
            <p class="mt-1 text-sm text-slate-500">Tạo tài khoản, phân quyền và khóa/mở quyền truy cập kho.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Quay lại tổng quan</a>
    </div>

    <section class="mb-6 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-base font-semibold text-slate-900">Tạo tài khoản mới</h2>
        <p class="mt-1 text-sm text-slate-500">Mật khẩu tối thiểu 8 ký tự. Không dùng email của System Owner hoặc Sub-Owner.</p>
        <form method="POST" action="{{ route('admin.accounts.store') }}" class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @csrf
            <label class="text-xs font-medium text-slate-600">Họ và tên
                <input name="fullname" value="{{ old('fullname') }}" required maxlength="255" class="mt-1 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            </label>
            <label class="text-xs font-medium text-slate-600">Email đăng nhập
                <input name="email" type="email" value="{{ old('email') }}" required maxlength="255" class="mt-1 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            </label>
            <label class="text-xs font-medium text-slate-600">Số điện thoại
                <input name="phone" value="{{ old('phone') }}" maxlength="20" class="mt-1 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            </label>
            <label class="text-xs font-medium text-slate-600">Vai trò
                @if (auth()->user()->isSystemOwner())
                    <select name="admin_role" required class="mt-1 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
                        <option value="1" @selected(old('admin_role', '1') == '1')>Tài khoản thường</option>
                        <option value="2" @selected(old('admin_role') == '2')>admin</option>
                    </select>
                @else
                    <input type="hidden" name="admin_role" value="1">
                    <span class="mt-1 block rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-600">Tài khoản thường</span>
                @endif
            </label>
            <label class="text-xs font-medium text-slate-600">Mật khẩu
                <input name="password" type="password" required minlength="8" autocomplete="new-password" class="mt-1 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            </label>
            <label class="text-xs font-medium text-slate-600">Xác nhận mật khẩu
                <input name="password_confirmation" type="password" required minlength="8" autocomplete="new-password" class="mt-1 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            </label>
            <label class="flex items-center gap-2 text-sm font-medium text-slate-700 sm:col-span-2 lg:col-span-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', '1')) class="rounded border-slate-300 text-blue-800 focus:ring-blue-700">
                Tài khoản được phép đăng nhập
            </label>
            <div class="sm:col-span-2 lg:col-span-3">
                <button class="rounded-lg bg-blue-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">Tạo tài khoản</button>
            </div>
        </form>
    </section>

    <form method="GET" class="mb-5 flex flex-wrap gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <input name="q" value="{{ $query }}" placeholder="Tìm tên, email hoặc số điện thoại..." class="min-w-[220px] flex-1 rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <button class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Tìm kiếm</button>
        <a href="{{ route('admin.accounts.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Xóa lọc</a>
    </form>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Tài khoản</th>
                        <th class="px-5 py-3">Vai trò</th>
                        <th class="px-5 py-3">Trạng thái</th>
                        <th class="px-5 py-3">Phiếu đã tạo</th>
                        <th class="px-5 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($accounts as $account)
                        @php($canManage = ! $account->isSystemOwner() && (auth()->user()->isSystemOwner() || in_array($account->admin_role, [0, 1], true)))
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-900">{{ $account->fullname }}</p>
                                <p class="mt-1 text-xs text-slate-600">{{ $account->email }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $account->phone ?: 'Chưa có số điện thoại' }}</p>
                            </td>
                            <td class="px-5 py-4">
                                @if ($account->isSystemOwner())
                                    <span class="rounded-full bg-violet-100 px-2.5 py-1 text-xs font-semibold text-violet-800">System Owner</span>
                                @elseif ($account->admin_role === 2)
                                    <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-800">Nhân viên kho</span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">Tài khoản thường</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if ($account->is_active)
                                    <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800">Đang hoạt động</span>
                                @else
                                    <span class="rounded-full bg-rose-100 px-2.5 py-1 text-xs font-semibold text-rose-800">Đã khóa</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $account->inventory_transactions_count }}</td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    @if ($canManage)
                                        <a href="{{ route('admin.accounts.edit', $account) }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">Sửa</a>
                                        <form method="POST" action="{{ route('admin.accounts.destroy', $account) }}" onsubmit="return confirm('Xóa tài khoản này? Tài khoản có lịch sử phiếu sẽ không thể xóa.')">
                                            @csrf @method('DELETE')
                                            <button class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">Xóa</button>
                                        </form>
                                    @else
                                        <span class="px-3 py-2 text-xs text-slate-400">Được bảo vệ</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-slate-500">Chưa có tài khoản phù hợp.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($accounts->hasPages())
            <div class="border-t border-slate-200 px-5 py-4">{{ $accounts->links() }}</div>
        @endif
    </div>

    <aside class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
        Admin thường chỉ quản lý tài khoản thường. Chỉ System Owner mới cấp quyền nhân viên kho; tài khoản System Owner không thể sửa/xóa. Tài khoản có lịch sử phiếu phải khóa thay vì xóa.
    </aside>
@endsection
