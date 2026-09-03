@extends('layouts.admin')

@section('title', 'Trạng thái & Sự kiện - Tâm Barbershop Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4">

    <!-- HEADER SECTION -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
         style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex items-center gap-3 mb-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                <i class="fa-solid fa-[#f2d788] fa-bullhorn text-xs"></i>
            </span>
            <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase">
                Quản Lý Trạng Thái &amp; Sự Kiện
            </h1>
        </div>
        <p class="text-xs text-[#f4ecd8]/70 pl-11">
            Nội dung đăng ở đây sẽ hiển thị trực tiếp ở bảng tin Trang chủ và cho phép tất cả mọi người vào bình luận tương tác.
        </p>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- CREATE ANNOUNCEMENT FORM CARD -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 sm:p-8 shadow-2xl relative overflow-hidden transition-all duration-300 hover:border-[#a8342f]/50">
        
        <div class="flex items-center gap-2 mb-6 border-b border-[#3c2c15] pb-3">
            <i class="fa-solid fa-[#f2d788] fa-pen-to-square text-[#a8342f] text-sm"></i>
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">
                Đăng Trạng Thái / Sự Kiện Mới
            </h2>
        </div>

        <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Title -->
            <div class="space-y-1.5">
                <label for="title" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                    Tiêu đề bài đăng
                </label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Nhập tiêu đề thông báo hoặc sự kiện..."
                       class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
            </div>

            <!-- Content -->
            <div class="space-y-1.5">
                <label for="content" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                    Nội dung chi tiết <span class="text-[#a8342f]">*</span>
                </label>
                <textarea id="content" name="content" rows="4" required placeholder="Viết nội dung tin tức, ưu đãi hoặc trạng thái..."
                          class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] p-4 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">{{ old('content') }}</textarea>
            </div>

            <!-- Grid 2 Cột: Image Picker & Event Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <!-- Custom Image Upload -->
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Hình ảnh đính kèm
                    </label>
                    <div class="relative flex items-center gap-3">
                        <label for="announcement-image-input" 
                               class="cursor-pointer inline-flex items-center gap-2 rounded-[2px] border border-[#8a641d] bg-[#070503] px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-[#f2d788] transition-all hover:bg-[#8a641d] hover:text-[#0b0805]">
                            <i class="fa-solid fa-file-image"></i>
                            <span>➕ Chọn ảnh từ máy</span>
                        </label>
                        <input type="file" id="announcement-image-input" name="image" accept="image/*" class="hidden" 
                               onchange="document.getElementById('announcement-image-filename').textContent = this.files[0] ? this.files[0].name : '';">
                        <span id="announcement-image-filename" class="text-xs text-[#6f6248] italic truncate max-w-[200px]"></span>
                    </div>
                </div>

                <!-- Datetime Local -->
                <div class="space-y-1.5">
                    <label for="event_at" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Thời gian diễn ra sự kiện <span class="text-[#6f6248] font-normal">(không bắt buộc)</span>
                    </label>
                    <input type="datetime-local" id="event_at" name="event_at" value="{{ old('event_at') }}"
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                </div>
            </div>

            <!-- Pin Checkbox & Submit Button -->
            <div class="pt-3 flex flex-wrap items-center justify-between gap-4 border-t border-[#3c2c15]/60">
                <label class="inline-flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_pinned" value="1" 
                           class="h-4 w-4 rounded-[2px] border-[#3c2c15] bg-[#070503] text-[#a8342f] focus:ring-0 focus:ring-offset-0">
                    <span class="text-xs font-semibold text-[#f4ecd8] flex items-center gap-1.5">
                        <i class="fa-solid fa-thumbtack text-xs text-[#f2d788]"></i>
                        Ghim bài đăng lên đầu bảng tin
                    </span>
                </label>

                <button type="submit" 
                        class="inline-flex items-center gap-2 rounded-[2px] border border-[#f2d788]/60 bg-gradient-to-r from-[#7c1f22] via-[#cf9f3f] to-[#8a641d] px-8 py-2.5 text-xs font-bold uppercase tracking-[0.15em] text-[#f4ecd8] shadow-[0_0_15px_rgba(124,31,34,0.4)] transition-all hover:brightness-125 hover:shadow-[0_0_25px_rgba(168,52,47,0.6)] active:scale-[0.98]">
                    <i class="fa-solid fa-paper-plane text-[10px]"></i>
                    <span>Đăng Bài Viết</span>
                </button>
            </div>
        </form>
    </div>

    <!-- ANNOUNCEMENTS TABLE LIST -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-4">
        
        <div class="flex items-center justify-between border-b border-[#3c2c15] pb-3">
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase flex items-center gap-2">
                <i class="fa-solid fa-list-check text-xs text-[#a8342f]"></i>
                Danh Sách Đã Đăng
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#f4ecd8]/90">
                <thead class="border-b border-[#3c2c15] bg-[#070503] text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">
                    <tr>
                        <th class="py-3 px-4">Ảnh</th>
                        <th class="py-3 px-4">Tiêu đề / Nội dung</th>
                        <th class="py-3 px-4">Sự kiện lúc</th>
                        <th class="py-3 px-4 text-center">Bình luận</th>
                        <th class="py-3 px-4">Đăng lúc</th>
                        <th class="py-3 px-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#3c2c15]/50">
                    @forelse ($announcements as $announcement)
                        <tr class="hover:bg-[#171008] transition-colors">
                            <!-- Image -->
                            <td class="py-3 px-4">
                                @if ($announcement->image)
                                    <div class="h-12 w-16 overflow-hidden rounded-[2px] border border-[#3c2c15] bg-[#070503]">
                                        <img src="{{ $announcement->image }}" alt="" class="h-full w-full object-cover">
                                    </div>
                                @else
                                    <span class="text-[#6f6248] italic text-[11px]">Không ảnh</span>
                                @endif
                            </td>

                            <!-- Title & Content -->
                            <td class="py-3 px-4 max-w-xs space-y-1">
                                <div class="font-bold text-[#f2d788] flex items-center gap-1.5">
                                    @if ($announcement->is_pinned)
                                        <span class="text-xs text-red-500" title="Đã ghim">📌</span>
                                    @endif
                                    <span>{{ $announcement->title ?: 'Không có tiêu đề' }}</span>
                                </div>
                                <p class="text-[#f4ecd8]/60 line-clamp-2 text-[11px] leading-relaxed">
                                    {{ \Illuminate\Support\Str::limit($announcement->content, 80) }}
                                </p>
                            </td>

                            <!-- Event At -->
                            <td class="py-3 px-4 text-[#f2d788] font-semibold whitespace-nowrap">
                                {{ $announcement->event_at?->format('H:i d/m/Y') ?? '—' }}
                            </td>

                            <!-- Comment Count -->
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center justify-center rounded-[2px] border border-[#3c2c15] bg-[#070503] px-2.5 py-1 text-[11px] font-bold text-[#f2d788]">
                                    <i class="fa-regular fa-comment text-[10px] mr-1 text-[#6f6248]"></i>
                                    {{ $announcement->comments_count }}
                                </span>
                            </td>

                            <!-- Created At -->
                            <td class="py-3 px-4 text-[#6f6248] whitespace-nowrap">
                                {{ $announcement->created_at->format('H:i d/m/Y') }}
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('announcements.show', $announcement) }}" target="_blank" 
                                   class="inline-flex items-center gap-1 rounded-[2px] border border-[#8a641d] bg-[#070503] px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-[#f2d788] transition-all hover:bg-[#8a641d] hover:text-[#0b0805]">
                                    <i class="fa-solid fa-eye text-[10px]"></i>
                                    <span>Xem</span>
                                </a>

                                <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xoá bài đăng này?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1 rounded-[2px] border border-[#a8342f] bg-[#7c1f22]/30 px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-red-300 transition-all hover:bg-[#a8342f] hover:text-white">
                                        <i class="fa-solid fa-trash text-[10px]"></i>
                                        <span>Xoá</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#6f6248] italic">
                                <i class="fa-regular fa-folder-open text-2xl mb-2 block"></i>
                                Chưa có bài đăng nào trong hệ thống.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-4 border-t border-[#3c2c15]">
            {{ $announcements->links() }}
        </div>
    </div>

</div>
@endsection