@extends('layouts.app')

@section('title', 'Không có quyền truy cập')

@section('content')
    <section class="mx-auto max-w-xl rounded-xl border border-slate-200 bg-white p-8 text-center shadow-sm">
        <p class="text-sm font-semibold uppercase tracking-wide text-rose-700">Lỗi 403</p>
        <h1 class="mt-2 text-2xl font-bold text-slate-900">Bạn không có quyền truy cập</h1>
        <p class="mt-3 text-slate-600">Vui lòng liên hệ quản trị viên hệ thống nếu bạn cần quyền sử dụng chức năng này.</p>
        <a href="{{ route('home') }}" class="mt-6 inline-flex rounded-lg bg-blue-700 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">
            Về trang chính
        </a>
    </section>
@endsection
