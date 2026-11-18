@extends('layouts.admin')

@section('title', 'Sửa tài khoản')

@section('content')
    <div class="mb-6">
        <p class="text-sm font-semibold text-blue-800">QUẢN LÝ TÀI KHOẢN</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Cập nhật tài khoản</h1>
        <p class="mt-1 text-sm text-slate-500">{{ $account->fullname }} · {{ $account->inventoryTransactions()->count() }} phiếu kho đã tạo</p>
    </div>

    <form method="POST" action="{{ route('admin.accounts.update', $account) }}" class="max-w-3xl space-y-5 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf @method('PUT')
        <div class="grid gap-4 sm:grid-cols-2">
            <label class="text-sm font-medium text-slate-700">Họ và tên
                <input name="fullname" value="{{ old('fullname', $account->fullname) }}" required maxlength="255" class="mt-1 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            </label>
            <label class="text-sm font-medium text-slate-700">Email đăng nhập
                <input name="email" type="email" value="{{ old('email', $account->email) }}" required maxlength="255" class="mt-1 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            </label>
            <label class="text-sm font-medium text-slate-700">Số điện thoại
                <input name="phone" value="{{ old('phone', $account->phone) }}" maxlength="20" class="mt-1 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            </label>
            <label class="text-sm font-medium text-slate-700">Vai trò
                @if (auth()->user()->isSystemOwner())
                    <select name="admin_role" required class="mt-1 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
                        <option value="1" @selected(old('admin_role', (string) $account->admin_role) == '1')>Tài khoản thường</option>
                        <option value="2" @selected(old('admin_role', (string) $account->admin_role) == '2')>Nhân viên kho (Admin)</option>
                    </select>
                @else
                    <input type="hidden" name="admin_role" value="1">
                    <span class="mt-1 block rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-600">Tài khoản thường</span>
                @endif
            </label>
            <label class="text-sm font-medium text-slate-700 sm:col-span-2">Mật khẩu mới
                <input name="password" type="password" minlength="8" autocomplete="new-password" class="mt-1 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
                <span class="mt-1 block text-xs font-normal text-slate-500">Để trống nếu không muốn đổi mật khẩu.</span>
            </label>
            <label class="text-sm font-medium text-slate-700 sm:col-span-2">Xác nhận mật khẩu mới
                <input name="password_confirmation" type="password" minlength="8" autocomplete="new-password" class="mt-1 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            </label>
        </div>
        <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $account->is_active ? '1' : '0')) class="rounded border-slate-300 text-blue-800 focus:ring-blue-700">
            Tài khoản được phép đăng nhập
        </label>
        <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-4">
            <button class="rounded-lg bg-blue-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">Lưu thay đổi</button>
            <a href="{{ route('admin.accounts.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Hủy</a>
        </div>
    </form>
@endsection
