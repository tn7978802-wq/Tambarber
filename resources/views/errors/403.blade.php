@extends('layouts.app')

@section('title', '403 Forbidden - Tâm Barbershop')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-6">
    <div class="max-w-2xl w-full text-center">
        <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-[#1a140f] border-2 border-[#8a641d] mx-auto mb-6">
            <i class="fa-solid fa-lock text-3xl text-[#f2d788]"></i>
        </div>

        <h1 class="font-['Bebas_Neue'] text-5xl text-[#f2d788] tracking-wide mb-3">403 — Quyền truy cập bị từ chối</h1>
        <p class="text-[#f4ecd8] mb-6">Bạn không có quyền truy cập vào trang này hoặc hành động bị cấm. Nếu bạn nghĩ mình nên có quyền truy cập, vui lòng liên hệ quản trị viên.</p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="inline-block rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-5 py-2 text-[#0b0805] font-semibold shadow">Về trang chủ</a>
            @auth
                <a href="{{ route('account.index') }}" class="inline-block rounded-[2px] border border-[#3c2c15] bg-[#251b0e] px-5 py-2 text-[#f4ecd8] font-semibold">Trang tài khoản</a>
            @else
                <a href="{{ route('login') }}" class="inline-block rounded-[2px] border border-[#3c2c15] bg-[#251b0e] px-5 py-2 text-[#f4ecd8] font-semibold">Đăng nhập</a>
            @endauth
            <a href="{{ route('contact.index') }}" class="inline-block text-sm text-[#6f6248] underline hover:text-[#f2d788]">Liên hệ quản trị</a>
        </div>

        <p class="mt-6 text-xs text-[#6f6248]">Nếu bạn là quản trị viên và đang xem nhầm trang này, kiểm tra cấu hình quyền (middleware / policy) hoặc logs để biết chi tiết.</p>
    </div>
</div>
@endsection
