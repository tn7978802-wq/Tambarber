@extends('layouts.admin')

@section('title', 'Chi tiết liên hệ')

@section('content')
<div class="mx-auto max-w-4xl space-y-6 py-4">
    <div class="flex items-center justify-between gap-3">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#8a641d]">Tin nhắn</p>
            <h1 class="font-['Bebas_Neue'] text-3xl tracking-[0.08em] text-[#f2d788] uppercase">Chi tiết liên hệ</h1>
        </div>
        <a href="{{ route('admin.contact.index') }}" class="inline-flex items-center gap-2 rounded-[2px] border border-[#3c2c15] bg-[#251b0e] px-3 py-2 text-[11px] font-bold uppercase tracking-[0.08em] text-[#f4ecd8] transition hover:border-[#8a641d] hover:text-[#f2d788]">
            <i class="fa-solid fa-arrow-left"></i>
            Quay lại
        </a>
    </div>

    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-[0_10px_30px_rgba(0,0,0,0.45)]">
        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-1">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#6f6248]">Họ tên</div>
                <div class="text-lg font-semibold text-[#f2d788]">{{ $contact->name }}</div>
            </div>
            <div class="space-y-1">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#6f6248]">Email</div>
                <div class="text-lg font-semibold text-[#f4ecd8]">
                    <a href="mailto:{{ $contact->email ?? '' }}" class="text-[#f2d788] hover:underline">
                        {{ $contact->email ?? '—' }}
                    </a>
                </div>
            </div>
            <div class="space-y-1 md:col-span-2">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#6f6248]">Số điện thoại</div>
                <div class="text-lg font-semibold text-[#f4ecd8]">{{ $contact->phone }}</div>
            </div>
        </div>

        <div class="mt-6 space-y-2">
            <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#6f6248]">Thời gian gửi</div>
            <div class="text-sm text-[#f4ecd8]">{{ \Carbon\Carbon::parse($contact->created_at)->format('d/m/Y H:i') }}</div>
        </div>

        <div class="mt-6 rounded-[2px] border border-[#3c2c15] bg-[#171008] p-4">
            <div class="mb-3 text-[10px] font-bold uppercase tracking-[0.15em] text-[#6f6248]">Nội dung</div>
            <div class="whitespace-pre-line text-sm leading-7 text-[#f4ecd8]">{{ $contact->message }}</div>
        </div>
    </div>
</div>
@endsection
