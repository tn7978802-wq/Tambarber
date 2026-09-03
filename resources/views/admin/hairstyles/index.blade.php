@extends('layouts.admin')

@section('title', 'Quản lý Kiểu tóc - Tâm Barbershop Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4">

    <!-- HEADER SECTION -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
         style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex items-center gap-3 mb-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                <i class="fa-solid fa-[#f2d788] fa-scissors text-xs"></i>
            </span>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a8342f]">Quản trị hệ thống</span>
                <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase leading-tight">
                    Quản Lý Kiểu Tóc
                </h1>
            </div>
        </div>
        <p class="text-xs text-[#f4ecd8]/70 pl-11">
            Thêm mới các kiểu tóc mẫu, đặt mức độ khó thực hiện, gợi ý khuôn mặt phù hợp và cập nhật bảng giá tham khảo.
        </p>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- CREATE HAIRSTYLE FORM CARD -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 sm:p-8 shadow-2xl relative overflow-hidden transition-all duration-300 hover:border-[#a8342f]/50">
        
        <div class="flex items-center gap-2 mb-6 border-b border-[#3c2c15] pb-3">
            <i class="fa-solid fa-[#f2d788] fa-plus text-[#a8342f] text-sm"></i>
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">
                Thêm Kiểu Tóc Mới
            </h2>
        </div>

        <form action="{{ route('admin.hairstyles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Grid 2 Cột: Tên kiểu tóc & Khuôn mặt phù hợp -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <!-- Hairstyle Name -->
                <div class="space-y-1.5">
                    <label for="name" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Tên kiểu tóc <span class="text-[#a8342f]">*</span>
                    </label>
                    <input type="text" id="name" name="name" placeholder="Ví dụ: Undercut Quiff, Crop Fade..." required
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                </div>

                <!-- Suitable Face Shapes -->
                <div class="space-y-1.5">
                    <label for="suitable_face_shapes" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Khuôn mặt phù hợp
                    </label>
                    <input type="text" id="suitable_face_shapes" name="suitable_face_shapes" placeholder="Ví dụ: Trái xoan, Mặt dài, Mặt vuông..."
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                </div>
            </div>

            <!-- Grid 2 Cột: Độ khó & Giá tham khảo -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <!-- Difficulty -->
                <div class="space-y-1.5">
                    <label for="difficulty" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Độ khó tạo kiểu <span class="text-[#a8342f]">*</span>
                    </label>
                    <select id="difficulty" name="difficulty" required
                            class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                        <option value="easy">Dễ (Easy)</option>
                        <option value="medium" selected>Trung bình (Medium)</option>
                        <option value="hard">Khó (Hard)</option>
                    </select>
                </div>

                <!-- Reference Price -->
                <div class="space-y-1.5">
                    <label for="reference_price" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Giá tham khảo (VND)
                    </label>
                    <input type="number" id="reference_price" name="reference_price" placeholder="Ví dụ: 100000"
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                </div>
            </div>

            <!-- Image Picker -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                    Hình ảnh minh hoạ
                </label>
                <div class="relative flex items-center gap-3">
                    <label for="hairstyle-image-input" 
                           class="cursor-pointer inline-flex items-center gap-2 rounded-[2px] border border-[#8a641d] bg-[#070503] px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-[#f2d788] transition-all hover:bg-[#8a641d] hover:text-[#0b0805]">
                        <i class="fa-solid fa-file-image"></i>
                        <span>➕ Chọn ảnh từ máy</span>
                    </label>
                    <input type="file" id="hairstyle-image-input" name="image" accept="image/*" class="hidden" 
                           onchange="document.getElementById('hairstyle-image-filename').textContent = this.files[0] ? this.files[0].name : '';">
                    <span id="hairstyle-image-filename" class="text-xs text-[#6f6248] italic truncate max-w-[250px]"></span>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-1.5">
                <label for="description" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                    Mô tả kiểu tóc
                </label>
                <textarea id="description" name="description" rows="3" placeholder="Mô tả chi tiết đặc điểm kiểu tóc, cách sấy vuốt tạo kiểu..."
                          class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] p-4 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-3 flex justify-end border-t border-[#3c2c15]/60">
                <button type="submit" 
                        class="inline-flex items-center gap-2 rounded-[2px] border border-[#f2d788]/60 bg-gradient-to-r from-[#7c1f22] via-[#cf9f3f] to-[#8a641d] px-8 py-2.5 text-xs font-bold uppercase tracking-[0.15em] text-[#f4ecd8] shadow-[0_0_15px_rgba(124,31,34,0.4)] transition-all hover:brightness-125 hover:shadow-[0_0_25px_rgba(168,52,47,0.6)] active:scale-[0.98]">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                    <span>Thêm Kiểu Tóc</span>
                </button>
            </div>
        </form>
    </div>

    <!-- HAIRSTYLES TABLE LIST -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-4">
        
        <div class="flex items-center justify-between border-b border-[#3c2c15] pb-3">
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase flex items-center gap-2">
                <i class="fa-solid fa-list text-xs text-[#a8342f]"></i>
                Danh Sách Kiểu Tóc
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#f4ecd8]/90">
                <thead class="border-b border-[#3c2c15] bg-[#070503] text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">
                    <tr>
                        <th class="py-3 px-4">Ảnh</th>
                        <th class="py-3 px-4">Tên kiểu tóc</th>
                        <th class="py-3 px-4">Độ khó</th>
                        <th class="py-3 px-4">Giá tham khảo</th>
                        <th class="py-3 px-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#3c2c15]/50">
                    @forelse ($hairstyles as $hairstyle)
                        <tr class="hover:bg-[#171008] transition-colors">
                            <!-- Image -->
                            <td class="py-3 px-4">
                                @if ($hairstyle->image)
                                    <div class="h-12 w-16 overflow-hidden rounded-[2px] border border-[#3c2c15] bg-[#070503]">
                                        <img src="{{ $hairstyle->image }}" alt="{{ $hairstyle->name }}" class="h-full w-full object-cover">
                                    </div>
                                @else
                                    <span class="text-[#6f6248] italic text-[11px]">Không ảnh</span>
                                @endif
                            </td>

                            <!-- Name -->
                            <td class="py-3 px-4 font-bold text-[#f2d788]">
                                {{ $hairstyle->name }}
                            </td>

                            <!-- Difficulty Badge -->
                            <td class="py-3 px-4">
                                @switch($hairstyle->difficulty)
                                    @case('easy')
                                        <span class="inline-flex items-center gap-1 rounded-[2px] border border-emerald-500/30 bg-emerald-950/40 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-400">
                                            Dễ
                                        </span>
                                        @break
                                    @case('hard')
                                        <span class="inline-flex items-center gap-1 rounded-[2px] border border-red-500/30 bg-red-950/40 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-red-400">
                                            Khó
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-flex items-center gap-1 rounded-[2px] border border-amber-500/30 bg-amber-950/40 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-400">
                                            Trung bình
                                        </span>
                                @endswitch
                            </td>

                            <!-- Reference Price -->
                            <td class="py-3 px-4 font-semibold text-[#f2d788]">
                                {{ $hairstyle->reference_price ? number_format((float) $hairstyle->reference_price, 0, ',', '.') . 'đ' : '—' }}
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <form action="{{ route('admin.hairstyles.destroy', $hairstyle) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xoá kiểu tóc này?')">
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
                            <td colspan="5" class="py-8 text-center text-[#6f6248] italic">
                                <i class="fa-solid fa-scissors text-2xl mb-2 block"></i>
                                Chưa có kiểu tóc nào trong hệ thống.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-4 border-t border-[#3c2c15]">
            {{ $hairstyles->links() }}
        </div>
    </div>

</div>
@endsection