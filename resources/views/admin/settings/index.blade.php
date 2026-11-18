@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.app')

@section('title', 'Cài đặt tài khoản')

@section('content')
    <div class="mb-6">
        <p class="text-sm font-semibold text-blue-800">TÀI KHOẢN CỦA TÔI</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Cài đặt cá nhân</h1>
        <p class="mt-1 text-sm text-slate-500">Cập nhật tên hiển thị, email đăng nhập và số điện thoại.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-2xl space-y-5 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf @method('PUT')
        <label class="block text-sm font-medium text-slate-700">Tên hiển thị
            <input name="name" value="{{ old('name', $user->name) }}" required maxlength="255" autocomplete="name" class="mt-1.5 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            @error('name')<span class="mt-1 block text-xs text-rose-700">{{ $message }}</span>@enderror
        </label>
        <label class="block text-sm font-medium text-slate-700">Email đăng nhập
            <input name="email" type="email" value="{{ old('email', $user->email) }}" required maxlength="255" autocomplete="email" class="mt-1.5 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            @error('email')<span class="mt-1 block text-xs text-rose-700">{{ $message }}</span>@enderror
        </label>
        <label class="block text-sm font-medium text-slate-700">Số điện thoại
            <input name="phone" type="tel" value="{{ old('phone', $user->phone) }}" maxlength="20" autocomplete="tel" class="mt-1.5 block w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            @error('phone')<span class="mt-1 block text-xs text-rose-700">{{ $message }}</span>@enderror
        </label>
        <div class="border-t border-slate-100 pt-4">
            <button type="submit" class="rounded-lg bg-blue-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">Lưu thay đổi</button>
        </div>
    </form>
@endsection
