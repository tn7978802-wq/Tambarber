@extends('layouts.admin')

@section('title', 'Quản lý liên hệ - Tâm Barbershop Admin')

@section('content')
<div class="mx-auto max-w-9xl space-y-8 py-4">

    <!-- HEADER SECTION (Phong cách Banner Khu Vực Chủ Tiệm) -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
        style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                        <i class="fa-solid fa-envelope-open-text text-xs"></i>
                    </span>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a8342f]">Hộp thư hệ thống</span>
                        <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase leading-tight">
                            Quản Lý Liên Hệ
                        </h1>
                    </div>
                </div>
                <p class="text-xs text-[#f4ecd8]/70">
                    Tiếp nhận và xử lý phản hồi, thắc mắc cũng như yêu cầu từ khách hàng.
                </p>
            </div>

            <!-- Card Đếm Tổng Tin Nhắn -->
            <div class="flex items-center gap-2 bg-[#070503] px-5 py-3 rounded-[2px] border border-[#3c2c15] text-center">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#6f6248] block">Tổng tin nhắn</span>
                    <span class="font-['Bebas_Neue'] text-2xl font-bold text-[#f2d788] leading-none block mt-1">
                        {{ $messages->total() }}
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- MAIN TABLE CARD -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-4">
        
        <div class="flex items-center gap-2 border-b border-[#3c2c15] pb-3">
            <i class="fa-solid fa-inbox text-xs text-[#a8342f]"></i>
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">
                Danh Sách Phản Hồi
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#f4ecd8]/90">
                <thead class="border-b border-[#3c2c15] bg-[#070503] text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">
                    <tr>
                        <th class="py-3 px-4 w-12 text-center">#</th>
                        <th class="py-3 px-4">Trạng thái</th>
                        <th class="py-3 px-4">Họ tên</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Số điện thoại</th>
                        <th class="py-3 px-4">Nội dung</th>
                        <th class="py-3 px-4">Thời gian</th>
                        <th class="py-3 px-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#3c2c15]/50">
                    @forelse ($messages as $message)
                        <tr class="hover:bg-[#171008] transition-colors {{ isset($message->is_read) && !$message->is_read ? 'bg-[#18120a]' : '' }}">
                            <td class="py-3.5 px-4 font-mono font-bold text-[#f2d788] text-center whitespace-nowrap">
                                #{{ $message->id }}
                            </td>
                            
                            <!-- Trạng thái -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if(isset($message->is_read) && !$message->is_read)
                                    <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-amber-500/40 bg-amber-950/40 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-300">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                        Mới
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-[#3c2c15] bg-[#070503] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">
                                        Đã xem
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 font-semibold text-[#f4ecd8] whitespace-nowrap">
                                {{ $message->name }}
                            </td>

                            <td class="py-3.5 px-4 text-[#f4ecd8]/80 whitespace-nowrap">
                                {{ $message->email ?? '—' }}
                            </td>

                            <td class="py-3.5 px-4 font-mono text-[#f2d788] whitespace-nowrap">
                                {{ $message->phone }}
                            </td>

                            <td class="py-3.5 px-4 text-[#f4ecd8]/70 max-w-xs truncate">
                                {{ $message->message }}
                            </td>

                            <td class="py-3.5 px-4 whitespace-nowrap font-medium text-[#6f6248] font-mono">
                                {{ \Carbon\Carbon::parse($message->created_at)->format('d/m/Y H:i') }}
                            </td>

                            <!-- Thao tác Buttons -->
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.contact.show', $message->id) }}" 
                                       class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-[2px] bg-gradient-to-r from-[#7c1f22] to-[#8a641d] text-[#f2d788] border border-[#f2d788]/50 shadow-[0_0_10px_rgba(168,52,47,0.3)] hover:brightness-110 transition-all inline-flex items-center gap-1">
                                        <i class="fa-solid fa-eye text-[9px]"></i>
                                        <span>Xem</span>
                                    </a>

                                    <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa tin nhắn này không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-[2px] border border-red-500/40 bg-red-950/40 text-red-400 hover:bg-red-900/60 transition-all inline-flex items-center gap-1">
                                            <i class="fa-solid fa-trash text-[9px]"></i>
                                            <span>Xóa</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-[#6f6248] italic">
                                <i class="fa-solid fa-envelope-open text-2xl mb-2 block"></i>
                                Chưa có tin nhắn liên hệ nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($messages->hasPages())
            <div class="pt-4 border-t border-[#3c2c15] flex justify-center">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection