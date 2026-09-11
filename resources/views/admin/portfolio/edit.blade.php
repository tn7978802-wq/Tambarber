@extends('layouts.admin')

@section('title', 'Sửa tác phẩm')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    <!-- HEADER / TIÊU ĐỀ -->
    <div class="mb-8 border-b border-[#3c2c15] pb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl text-[#f2d788] uppercase tracking-wider">
                Sửa Tác Phẩm
            </h1>
            <p class="text-xs text-[#f4ecd8]/70 mt-1">
                Cập nhật thông tin tác phẩm: <span class="text-[#f2d788] font-semibold">{{ $item->title }}</span>
            </p>
        </div>
        <div>
            <a href="{{ route('admin.portfolio.index') }}" 
               class="inline-flex items-center gap-1.5 rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3.5 py-1.5 text-xs font-bold uppercase tracking-wider text-[#f4ecd8] hover:border-[#8a641d] hover:text-[#f2d788] transition-all">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                 Quay lại
            </a>
        </div>
    </div>

    <!-- FORM CARD CONTAINER -->
    <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-6 sm:p-8 shadow-2xl"
         style="box-shadow: 0 0 0 1px rgba(138,100,29,.15), 0 10px 25px -10px rgba(0,0,0,.8);">

        <form action="{{ route('admin.portfolio.update', $item) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- UPLOAD 2 CỘT ẢNH (BEFORE / AFTER) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Ảnh sau khi cắt (bắt buộc) --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] mb-2">
                        Ảnh tác phẩm hoàn thiện (Sau khi cắt) <span class="text-red-500">*</span>
                    </label>
                    <label for="image_after"
                           class="flex flex-col items-center justify-center w-full h-52 rounded-[2px] border-2 border-dashed
                                  border-[#3c2c15] hover:border-[#8a641d] cursor-pointer bg-[#0b0805] transition overflow-hidden relative group"
                           id="preview-after-wrap">
                        <img id="preview-after"
                             src="{{ str_starts_with($item->image_after, 'http') ? $item->image_after : asset('storage/' . $item->image_after) }}"
                             class="w-full h-full object-cover" />
                        <span id="placeholder-after" class="hidden flex flex-col items-center text-[#6f6248] group-hover:text-[#f2d788] transition-colors">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl mb-2"></i>
                            <span class="text-xs font-semibold">Tải ảnh tác phẩm lên</span>
                            <span class="text-[10px] text-[#6f6248]/70 mt-1">(Định dạng PNG, JPG, WEBP)</span>
                        </span>
                        <span class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center text-[#f2d788] text-xs font-bold uppercase tracking-wider transition-all">
                            + Đổi ảnh mới
                        </span>
                    </label>
                    <input type="file" id="image_after" name="image_after" accept="image/*" class="hidden"
                           onchange="previewImage(this, 'preview-after', 'placeholder-after')">
                    @error('image_after') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Ảnh trước khi cắt (tuỳ chọn) --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80 mb-2">
                        Ảnh trước khi cắt (Tùy chọn)
                    </label>
                    <label for="image_before"
                           class="flex flex-col items-center justify-center w-full h-52 rounded-[2px] border-2 border-dashed
                                  border-[#3c2c15] hover:border-[#8a641d] cursor-pointer bg-[#0b0805] transition overflow-hidden relative group">
                        @if($item->image_before)
                            <img id="preview-before"
                                 src="{{ str_starts_with($item->image_before, 'http') ? $item->image_before : asset('storage/' . $item->image_before) }}"
                                 class="w-full h-full object-cover" />
                            <span id="placeholder-before" class="hidden flex flex-col items-center text-[#6f6248] group-hover:text-[#f2d788] transition-colors">
                                <i class="fa-solid fa-camera text-3xl mb-2"></i>
                                <span class="text-xs font-semibold">Tải ảnh ban đầu (Nếu có)</span>
                                <span class="text-[10px] text-[#6f6248]/70 mt-1">(Dùng cho hiệu ứng Trước/Sau)</span>
                            </span>
                            <span class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center text-[#f2d788] text-xs font-bold uppercase tracking-wider transition-all">
                                + Đổi ảnh mới
                            </span>
                        @else
                            <img id="preview-before" class="hidden w-full h-full object-cover" />
                            <span id="placeholder-before" class="flex flex-col items-center text-[#6f6248] group-hover:text-[#f2d788] transition-colors">
                                <i class="fa-solid fa-camera text-3xl mb-2"></i>
                                <span class="text-xs font-semibold">Tải ảnh ban đầu (Nếu có)</span>
                                <span class="text-[10px] text-[#6f6248]/70 mt-1">(Dùng cho hiệu ứng Trước/Sau)</span>
                            </span>
                            <span class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center text-[#f2d788] text-xs font-bold uppercase tracking-wider transition-all">
                                + Tải ảnh
                            </span>
                        @endif
                    </label>
                    <input type="file" id="image_before" name="image_before" accept="image/*" class="hidden"
                           onchange="previewImage(this, 'preview-before', 'placeholder-before')">
                </div>
            </div>

            <!-- TIÊU ĐỀ -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] mb-2">
                    Tiêu đề tác phẩm <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title', $item->title) }}" required
                       class="w-full rounded-[2px] bg-[#0b0805] border border-[#3c2c15] text-[#f4ecd8] px-4 py-2.5 text-sm
                              focus:outline-none focus:border-[#8a641d] focus:ring-1 focus:ring-[#8a641d] transition-all" 
                       placeholder="VD: Skin Fade vuốt Pomade lịch lãm">
                @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- MÔ TẢ -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80 mb-2">
                    Mô tả ngắn
                </label>
                <textarea name="description" rows="3"
                          class="w-full rounded-[2px] bg-[#0b0805] border border-[#3c2c15] text-[#f4ecd8] px-4 py-2.5 text-sm
                                 focus:outline-none focus:border-[#8a641d] focus:ring-1 focus:ring-[#8a641d] transition-all"
                          placeholder="Mô tả về chất tóc, sản phẩm vuốt tạo kiểu hoặc chi tiết tác phẩm...">{{ old('description', $item->description) }}</textarea>
            </div>

            <!-- DANH MỤC & BARBER -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] mb-2">
                        Danh mục <span class="text-red-500">*</span>
                    </label>
                    <select name="category" required
                            class="w-full rounded-[2px] bg-[#0b0805] border border-[#3c2c15] text-[#f4ecd8] px-4 py-2.5 text-sm
                                   focus:outline-none focus:border-[#8a641d] focus:ring-1 focus:ring-[#8a641d] transition-all">
                        @foreach($categories as $slug => $label)
                            <option value="{{ $slug }}" @selected(old('category', $item->category) === $slug) class="bg-[#0b0805] text-[#f4ecd8]">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80 mb-2">
                        Barber thực hiện
                    </label>
                    <select name="barber_id"
                            class="w-full rounded-[2px] bg-[#0b0805] border border-[#3c2c15] text-[#f4ecd8] px-4 py-2.5 text-sm
                                   focus:outline-none focus:border-[#8a641d] focus:ring-1 focus:ring-[#8a641d] transition-all">
                        <option value="" class="bg-[#0b0805] text-[#f4ecd8]">—— Chọn Thợ Barber ——</option>
                        @foreach($barbers as $barber)
                            <option value="{{ $barber->id }}" @selected((string) old('barber_id', $item->barber_id) === (string) $barber->id) class="bg-[#0b0805] text-[#f4ecd8]">
                                {{ $barber->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- CHECKBOX NỔI BẬT -->
            <div class="flex items-center gap-3 pt-2">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $item->is_featured))
                       class="w-4 h-4 rounded-[2px] bg-[#0b0805] border-[#3c2c15] text-[#8a641d] focus:ring-[#8a641d] focus:ring-offset-0 cursor-pointer">
                <label for="is_featured" class="text-xs text-[#f4ecd8] font-medium cursor-pointer select-none">
                    Đánh dấu đây là tác phẩm nổi bật (Ưu tiên hiển thị trên trang chủ/đầu thư viện)
                </label>
            </div>

            <!-- NÚT BẤM CÔNG CỤ -->
            <div class="flex items-center gap-3 pt-6 border-t border-[#3c2c15]">
                <button type="submit" 
                        class="rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-[#0b0805] shadow-md hover:brightness-110 transition-all">
                    Cập nhật
                </button>
                <a href="{{ route('admin.portfolio.index') }}" 
                   class="rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-[#f4ecd8] hover:border-[#8a641d] hover:text-[#f2d788] transition-all">
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
</script>
@endsection