@extends('layouts.app')

@section('title', 'Tổng quan kho vật tư')

@section('content')
    <section class="rounded-xl border border-slate-200 bg-white p-8 shadow-sm">
        <p class="text-sm font-semibold uppercase tracking-wide text-blue-700">Hệ thống quản lý kho</p>
        <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">
            Xin chào, {{ $user->fullname }}
        </h1>
        <p class="mt-3 max-w-2xl text-slate-600">
            Nền tảng quản lý vật tư hạ tầng mạng và CCTV đang được thiết lập.
            Danh mục, tồn kho và giao dịch sẽ được bổ sung trong các bước tiếp theo.
        </p>
        <p class="mt-3 max-w-2xl text-slate-600">
            Bạn có thể tạo được cấp quyền từ admin.
            Hãy đảm bảo rằng tài khoản được cấp quyền truy cập hợp lý để bảo mật thông tin kho.
        </p>
    </section>
@endsection
