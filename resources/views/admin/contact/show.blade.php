@extends('layouts.admin')

@section('title', 'Chi tiết liên hệ - Tâm Barbershop Admin')

@section('content')
<div class="mx-auto max-w-9xl space-y-8 py-4">

    <!-- HEADER SECTION -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
        style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                        <i class="fa-solid fa-address-card text-xs"></i>
                    </span>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a8342f]">Chi tiết phản hồi</span>
                        <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase leading-tight">
                            {{ $contact->name }}
                        </h1>
                    </div>
                </div>
                <p class="text-xs text-[#f4ecd8]/70">
                    Nội dung thông tin chi tiết và tin nhắn được gửi từ khách hàng.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.contact.index') }}" 
                   class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-[2px] border border-[#3c2c15] bg-[#070503] text-[#f4ecd8]/80 hover:text-[#f2d788] hover:border-[#8a641d] transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Quay lại</span>
                </a>

                <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa tin nhắn này không?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-[2px] border border-red-500/40 bg-red-950/40 text-red-400 hover:bg-red-900/60 transition-all flex items-center gap-1.5">
                        <i class="fa-solid fa-trash text-[10px]"></i>
                        <span>Xóa</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- MAIN CONTENT CARD -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-6">
        
        <!-- GRID THÔNG TIN KHÁCH HÀNG -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <div class="rounded-[4px] border border-[#3c2c15] bg-[#070503] p-4 space-y-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">Họ tên khách hàng</span>
                <p class="text-sm font-semibold text-[#f2d788]">{{ $contact->name }}</p>
            </div>

            <div class="rounded-[4px] border border-[#3c2c15] bg-[#070503] p-4 space-y-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">Thời gian gửi</span>
                <p class="text-xs font-mono text-[#f4ecd8]/90">{{ \Carbon\Carbon::parse($contact->created_at)->format('d/m/Y - H:i:s') }}</p>
            </div>

            <div class="rounded-[4px] border border-[#3c2c15] bg-[#070503] p-4 space-y-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">Địa chỉ Email</span>
                <p class="text-xs text-[#f4ecd8]/90 truncate">{{ $contact->email ?? '—' }}</p>
            </div>

            <div class="rounded-[4px] border border-[#3c2c15] bg-[#070503] p-4 space-y-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">Số điện thoại</span>
                <p class="text-xs font-mono font-bold text-[#f2d788]">{{ $contact->phone }}</p>
            </div>

        </div>

        <!-- KHUNG NỘI DUNG TIN NHẮN -->
        <div class="rounded-[4px] border border-[#3c2c15] bg-[#070503] p-5 space-y-3">
            <div class="flex items-center justify-between border-b border-[#3c2c15] pb-2">
                <h2 class="font-['Bebas_Neue'] text-xl tracking-wide text-[#f2d788] uppercase flex items-center gap-2">
                    <i class="fa-solid fa-comment-dots text-xs text-[#a8342f]"></i>
                    Nội dung tin nhắn
                </h2>
                <i class="fa-solid fa-quote-right text-xs text-[#3c2c15]"></i>
            </div>
            
            <p class="text-xs leading-relaxed text-[#f4ecd8]/90 whitespace-pre-line pt-1">
                {{ $contact->message }}
            </p>
        </div>

    </div>

</div>
@endsection