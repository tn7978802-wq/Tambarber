@extends('layouts.admin')

@section('title', 'Thêm tác phẩm mới - Tâm Barbershop Admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 py-4">

    <!-- HEADER SECTION / TIÊU ĐỀ -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
         style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </span>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a8342f]">Quản lý nội dung</span>
                        <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase leading-tight">
                            Thêm Tác Phẩm Mới
                        </h1>
                    </div>
                </div>
                <p class="text-xs text-[#f4ecd8]/70">
                    Thêm hình ảnh vào Thư viện tác phẩm (Portfolio) hiển thị ở trang công khai cho khách hàng tham khảo.
                </p>
            </div>

            <div>
                <a href="{{ route('admin.portfolio.index') }}" 
                   class="inline-flex items-center gap-2 rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80 hover:text-[#f2d788] hover:border-[#8a641d] hover:bg-[#171008] transition-all">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    <span>Quay lại</span>
                </a>
            </div>
        </div>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- FORM CARD CONTAINER -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 sm:p-8 shadow-2xl space-y-6">

        <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="portfolio-create-form">
            @csrf

            <!-- UPLOAD 2 CỘT ẢNH (BEFORE / AFTER) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Ảnh sau khi cắt (bắt buộc) --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] flex items-center gap-1.5">
                        <i class="fa-solid fa-image text-[10px] text-[#a8342f]"></i>
                        <span>Ảnh tác phẩm hoàn thiện (Sau khi cắt) <span class="text-red-500">*</span></span>
                    </label>
                    <label for="image_after"
                           class="flex flex-col items-center justify-center w-full h-56 rounded-[2px] border border-dashed
                                  border-[#3c2c15] hover:border-[#a8342f] cursor-pointer bg-[#070503] transition overflow-hidden relative group"
                           id="preview-after-wrap">
                        <img id="preview-after" class="hidden w-full h-full object-cover" />
                        <span id="placeholder-after" class="flex flex-col items-center text-[#6f6248] group-hover:text-[#f2d788] transition-colors">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl mb-2 text-[#a8342f]"></i>
                            <span class="text-xs font-semibold">Tải ảnh tác phẩm lên</span>
                            <span class="text-[10px] text-[#6f6248] mt-1">(Định dạng PNG, JPG, WEBP)</span>
                        </span>
                        <span class="absolute inset-0 bg-[#070503]/80 opacity-0 group-hover:opacity-100 flex items-center justify-center text-[#f2d788] text-xs font-bold uppercase tracking-wider transition-all backdrop-blur-sm">
                            <i class="fa-solid fa-arrows-rotate mr-2 text-[#a8342f]"></i> Đổi ảnh khác
                        </span>
                    </label>
                    <input type="file" id="image_after" name="image_after" accept="image/*" class="hidden" required
                           onchange="previewImage(this, 'preview-after', 'placeholder-after')">
                    @error('image_after') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Ảnh trước khi cắt (tuỳ chọn) --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80 flex items-center gap-1.5">
                        <i class="fa-solid fa-camera text-[10px] text-[#a8342f]"></i>
                        <span>Ảnh trước khi cắt (Tùy chọn)</span>
                    </label>
                    <label for="image_before"
                           class="flex flex-col items-center justify-center w-full h-56 rounded-[2px] border border-dashed
                                  border-[#3c2c15] hover:border-[#a8342f] cursor-pointer bg-[#070503] transition overflow-hidden relative group">
                        <img id="preview-before" class="hidden w-full h-full object-cover" />
                        <span id="placeholder-before" class="flex flex-col items-center text-[#6f6248] group-hover:text-[#f2d788] transition-colors">
                            <i class="fa-solid fa-camera text-3xl mb-2 text-[#a8342f]"></i>
                            <span class="text-xs font-semibold">Tải ảnh ban đầu (Nếu có)</span>
                            <span class="text-[10px] text-[#6f6248] mt-1">(Dùng cho hiệu ứng Trước/Sau)</span>
                        </span>
                        <span class="absolute inset-0 bg-[#070503]/80 opacity-0 group-hover:opacity-100 flex items-center justify-center text-[#f2d788] text-xs font-bold uppercase tracking-wider transition-all backdrop-blur-sm">
                            <i class="fa-solid fa-arrows-rotate mr-2 text-[#a8342f]"></i> Đổi ảnh khác
                        </span>
                    </label>
                    <input type="file" id="image_before" name="image_before" accept="image/*" class="hidden"
                           onchange="previewImage(this, 'preview-before', 'placeholder-before')">
                </div>
            </div>

            <!-- TIÊU ĐỀ -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold uppercase tracking-wider text-[#f2d788]">
                    Tiêu đề tác phẩm <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full rounded-[2px] bg-[#070503] border border-[#3c2c15] text-[#f4ecd8] px-4 py-2.5 text-sm
                              focus:outline-none focus:border-[#8a641d] focus:ring-1 focus:ring-[#8a641d] transition-all placeholder-[#6f6248]" 
                       placeholder="VD: Skin Fade vuốt Pomade lịch lãm">
                @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- MÔ TẢ -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80">
                    Mô tả ngắn
                </label>
                <textarea name="description" rows="3"
                          class="w-full rounded-[2px] bg-[#070503] border border-[#3c2c15] text-[#f4ecd8] px-4 py-2.5 text-sm
                                 focus:outline-none focus:border-[#8a641d] focus:ring-1 focus:ring-[#8a641d] transition-all placeholder-[#6f6248]"
                          placeholder="Mô tả về chất tóc, sản phẩm vuốt tạo kiểu hoặc chi tiết tác phẩm...">{{ old('description') }}</textarea>
            </div>

            <!-- DANH MỤC & BARBER -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#f2d788]">
                        Danh mục <span class="text-red-500">*</span>
                    </label>
                    <select name="category" required
                            class="w-full rounded-[2px] bg-[#070503] border border-[#3c2c15] text-[#f4ecd8] px-4 py-2.5 text-sm
                                   focus:outline-none focus:border-[#8a641d] focus:ring-1 focus:ring-[#8a641d] transition-all">
                        @foreach($categories as $slug => $label)
                            <option value="{{ $slug }}" @selected(old('category') === $slug) class="bg-[#070503] text-[#f4ecd8]">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80">
                        Barber thực hiện
                    </label>
                    <select name="barber_id"
                            class="w-full rounded-[2px] bg-[#070503] border border-[#3c2c15] text-[#f4ecd8] px-4 py-2.5 text-sm
                                   focus:outline-none focus:border-[#8a641d] focus:ring-1 focus:ring-[#8a641d] transition-all">
                        <option value="" class="bg-[#070503] text-[#f4ecd8]">—— Chọn Thợ Barber ——</option>
                        @foreach($barbers as $barber)
                            <option value="{{ $barber->id }}" @selected((string) old('barber_id') === (string) $barber->id) class="bg-[#070503] text-[#f4ecd8]">
                                {{ $barber->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- CHECKBOX NỔI BẬT -->
            <div class="p-3 rounded-[2px] border border-[#3c2c15] bg-[#070503] flex items-center gap-3">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" @checked(old('is_featured'))
                       class="w-4 h-4 rounded-[2px] bg-[#110d07] border-[#3c2c15] text-[#a8342f] focus:ring-[#a8342f] focus:ring-offset-0 cursor-pointer">
                <label for="is_featured" class="text-xs text-[#f4ecd8]/90 font-medium cursor-pointer select-none">
                    Đánh dấu đây là <strong class="text-[#f2d788]">Tác phẩm nổi bật</strong> (Ưu tiên hiển thị trên trang chủ/đầu thư viện)
                </label>
            </div>

            <!-- NÚT BẤM CÔNG CỤ -->
            <div class="flex items-center gap-3 pt-6 border-t border-[#3c2c15]">
                <button type="submit" id="portfolio-submit-btn"
                        class="rounded-[2px] border border-[#f2d788]/50 bg-gradient-to-r from-[#7c1f22] to-[#8a641d] px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-[#f2d788] shadow-[0_0_15px_rgba(168,52,47,0.4)] hover:brightness-125 transition-all flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Lưu tác phẩm</span>
                </button>
                <a href="{{ route('admin.portfolio.index') }}" 
                   class="rounded-[2px] border border-[#3c2c15] bg-[#070503] px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80 hover:text-[#f2d788] hover:border-[#8a641d] hover:bg-[#171008] transition-all">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>

</div>

<script>
function previewImage(input, previewId, placeholderId) {
    const preview = document.getElementById(previewId);
    const placeholder = document.getElementById(placeholderId);
    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        preview.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
    }
}

const portfolioForm = document.getElementById('portfolio-create-form');
const portfolioSubmitBtn = document.getElementById('portfolio-submit-btn');

if (portfolioForm && portfolioSubmitBtn) {
    portfolioForm.addEventListener('submit', function () {
        portfolioSubmitBtn.disabled = true;
        portfolioSubmitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs mr-1"></i> Đang lưu...';
    });
}
</script>
@endsection