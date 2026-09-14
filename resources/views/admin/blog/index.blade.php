@extends('layouts.admin')

@section('title', 'Góc chia sẻ - Tâm Barbershop Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4 px-2 sm:px-4">

    <!-- HEADER SECTION / TIÊU ĐỀ -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
         style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                        <i class="fa-solid fa-newspaper text-xs"></i>
                    </span>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a8342f]">Quản trị nội dung</span>
                        <h1 class="font-['Bebas_Neue'] text-3xl sm:text-5xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase leading-tight">
                            Góc Chia Sẻ
                        </h1>
                    </div>
                </div>
                <p class="text-xs text-[#f4ecd8]/70">
                    Danh sách tất cả tin tức, bài viết chia sẻ kinh nghiệm và xu hướng kiểu tóc trên hệ thống.
                </p>
            </div>

            <div>
                <a href="{{ route('admin.blog.create') }}" 
                   class="inline-flex items-center gap-2 rounded-[2px] border border-[#f2d788]/50 bg-gradient-to-r from-[#7c1f22] to-[#8a641d] px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-[#f2d788] shadow-[0_0_15px_rgba(168,52,47,0.4)] hover:brightness-125 transition-all">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Thêm bài viết mới</span>
                </a>
            </div>
        </div>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- NOTIFICATION ALERT -->
    @if (session('success'))
        <div class="rounded-[2px] border border-[#8a641d]/60 bg-[#171008] px-4 py-3 text-xs text-[#f2d788] shadow-lg flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-[#a8342f]"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- TABLE CONTAINER -->
    <div class="overflow-hidden rounded-[4px] border border-[#3c2c15] bg-[#110d07] shadow-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-[#070503] text-[#6f6248] uppercase tracking-wider text-[10px] border-b border-[#3c2c15]">
                    <tr>
                        <th class="px-5 py-3.5 font-bold">Bài viết</th>
                        <th class="px-5 py-3.5 font-bold">Danh mục</th>
                        <th class="px-5 py-3.5 font-bold">Trạng thái</th>
                        <th class="px-5 py-3.5 font-bold">Ngày đăng</th>
                        <th class="px-5 py-3.5 font-bold text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#3c2c15]/60">
                    @forelse ($posts as $post)
                        <tr class="hover:bg-[#171008]/80 transition-colors align-middle">
                            <!-- TIÊU ĐỀ BÀI VIẾT & SLUG -->
                            <td class="px-5 py-4">
                                <div class="font-semibold text-[#f4ecd8] text-sm leading-snug">{{ $post->title }}</div>
                                <div class="mt-1 text-[11px] text-[#6f6248] font-mono">{{ $post->slug }}</div>
                            </td>

                            <!-- DANH MỤC -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 rounded-[2px] bg-[#070503] border border-[#3c2c15] px-2.5 py-1 text-[11px] text-[#f4ecd8]/90">
                                    <i class="fa-solid fa-tag text-[9px] text-[#a8342f]"></i>
                                    {{ $post->category ?? 'Chung' }}
                                </span>
                            </td>

                            <!-- TRẠNG THÁI -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                @php
                                    $effectiveStatus = ($post->status === 'scheduled' && $post->publish_at && $post->publish_at->lte(now())) ? 'published' : $post->status;
                                @endphp

                                @if($effectiveStatus === 'published')
                                    <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-[#8a641d]/60 bg-[#251b0e] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-[#f2d788]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#f2d788]"></span> Đã đăng
                                    </span>
                                @elseif($effectiveStatus === 'scheduled')
                                    <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-cyan-800/60 bg-cyan-950/40 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-cyan-300">
                                        <span class="h-1.5 w-1.5 rounded-full bg-cyan-400"></span> Chờ xuất bản
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-[#3c2c15] bg-[#070503] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#6f6248]"></span> Bản nháp
                                    </span>
                                @endif
                            </td>

                            <!-- NGÀY ĐĂNG -->
                            <td class="px-5 py-4 whitespace-nowrap text-xs text-[#f4ecd8]/80 font-mono">
                                {{ $post->publish_at ? $post->publish_at->format('d/m/Y H:i') : '—' }}
                            </td>

                            <!-- THAO TÁC -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.blog.edit', $post) }}" 
                                       class="inline-flex items-center gap-1 rounded-[2px] border border-[#3c2c15] bg-[#070503] px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-[#f4ecd8] hover:border-[#8a641d] hover:text-[#f2d788] hover:bg-[#171008] transition-all">
                                        <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                        <span>Sửa</span>
                                    </a>

                                    <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 rounded-[2px] border border-red-900/60 bg-red-950/40 px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-red-300 hover:bg-red-900/60 hover:text-red-100 transition-all">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                            <span>Xóa</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-[#6f6248] italic">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 text-[#3c2c15] block"></i>
                                Chưa có bài viết nào trong Góc chia sẻ.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINATION -->
    @if ($posts->hasPages())
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    @endif

</div>
@endsection