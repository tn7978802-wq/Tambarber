@extends('layouts.admin')

@section('title', 'Sửa bài viết - Tâm Barbershop Admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 py-4">

    <!-- HEADER SECTION / TIÊU ĐỀ -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
         style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                        <i class="fa-solid fa-[#f2d788] fa-pen-to-square text-xs"></i>
                    </span>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a8342f]">Góc chia sẻ / Cập nhật</span>
                        <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase leading-tight">
                            Chỉnh Sửa Bài Viết
                        </h1>
                    </div>
                </div>
                <p class="text-xs text-[#f4ecd8]/70">
                    Cập nhật nội dung, trạng thái xuất bản và thông tin chi tiết bài viết.
                </p>
            </div>

            <div>
                <a href="{{ route('admin.blog.index') }}" 
                   class="inline-flex items-center gap-2 rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80 hover:text-[#f2d788] hover:border-[#8a641d] hover:bg-[#171008] transition-all">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    <span>Quay lại</span>
                </a>
            </div>
        </div>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- FORM CARD CONTAINER -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 sm:p-8 shadow-2xl">
        <form action="{{ route('admin.blog.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="blog-edit-form">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- TIÊU ĐỀ BÀI VIẾT -->
                <div class="md:col-span-2 space-y-1.5">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-[#f2d788]">
                        Tiêu đề bài viết <span class="text-red-500">*</span>
                    </label>
                    <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}" required 
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d] transition-all placeholder-[#6f6248]">
                    @error('title') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- SLUG & DANH MỤC -->
                <div class="space-y-1.5">
                    <label for="slug" class="block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80">
                        Đường dẫn (Slug)
                    </label>
                    <input id="slug" type="text" name="slug" value="{{ old('slug', $post->slug) }}" 
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d] transition-all placeholder-[#6f6248]">
                    @error('slug') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="category" class="block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80">
                        Danh mục
                    </label>
                    <input id="category" type="text" name="category" value="{{ old('category', $post->category) }}" 
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d] transition-all placeholder-[#6f6248]">
                </div>

                <!-- MÔ TẢ NGẮN -->
                <div class="md:col-span-2 space-y-1.5">
                    <label for="excerpt" class="block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80">
                        Mô tả ngắn (Sapo)
                    </label>
                    <textarea id="excerpt" name="excerpt" rows="3" 
                              class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d] transition-all placeholder-[#6f6248]">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <!-- NỘI DUNG -->
                <div class="md:col-span-2 space-y-1.5">
                    <label for="content" class="block text-xs font-bold uppercase tracking-wider text-[#f2d788]">
                        Nội dung chi tiết <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" name="content" rows="12" required 
                              class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d] transition-all placeholder-[#6f6248]">{{ old('content', $post->content) }}</textarea>
                    @error('content') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- UPLOAD ẢNH ĐẠI DIỆN -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80 flex items-center gap-1.5">
                        <i class="fa-solid fa-image text-[10px] text-[#a8342f]"></i>
                        <span>Ảnh đại diện (Thumbnail)</span>
                    </label>
                    @php
                        $thumbUrl = old('thumbnail', $post->thumbnail);
                        $hasThumb = !empty($thumbUrl);
                        if ($hasThumb && !str_starts_with((string)$thumbUrl, 'http')) {
                            $thumbUrl = asset('storage/' . $thumbUrl);
                        }
                    @endphp
                    <label for="thumbnail" 
                           class="flex min-h-[200px] cursor-pointer flex-col items-center justify-center rounded-[2px] border border-dashed border-[#3c2c15] bg-[#070503] p-4 text-center transition hover:border-[#a8342f] relative group overflow-hidden">
                        <img id="thumbnail-preview" src="{{ $thumbUrl }}" class="{{ $hasThumb ? '' : 'hidden' }} max-h-48 w-full rounded-[2px] object-cover" alt="preview">
                        <span id="thumbnail-placeholder" class="{{ $hasThumb ? 'hidden' : 'flex' }} flex-col items-center text-[#6f6248] group-hover:text-[#f2d788] transition-colors">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl mb-2 text-[#a8342f]"></i>
                            <span class="text-xs font-semibold">Tải ảnh đại diện lên</span>
                            <span class="mt-1 text-[10px] text-[#6f6248]">Hỗ trợ PNG, JPG, WEBP, GIF</span>
                        </span>
                        <span class="absolute inset-0 bg-[#070503]/80 opacity-0 group-hover:opacity-100 flex items-center justify-center text-[#f2d788] text-xs font-bold uppercase tracking-wider transition-all backdrop-blur-sm">
                            <i class="fa-solid fa-arrows-rotate mr-2 text-[#a8342f]"></i> Thay đổi ảnh
                        </span>
                    </label>
                    <input id="thumbnail" type="file" name="thumbnail" accept="image/*" class="hidden" onchange="previewImage(this, 'thumbnail-preview', 'thumbnail-placeholder')">
                    @error('thumbnail') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- TRẠNG THÁI & NGÀY ĐĂNG -->
                <div class="space-y-6">
                    <div class="space-y-1.5">
                        <label for="status" class="block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80">
                            Trạng thái xuất bản
                        </label>
                        <select id="status" name="status" class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d] transition-all">
                            <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }} class="bg-[#070503] text-[#f4ecd8]">Bản nháp</option>
                            <option value="scheduled" {{ old('status', $post->status) === 'scheduled' ? 'selected' : '' }} class="bg-[#070503] text-[#f4ecd8]">Chờ xuất bản</option>
                            <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }} class="bg-[#070503] text-[#f4ecd8]">Xuất bản ngay</option>
                        </select>
                        @error('status') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="publish_at" class="block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80">
                            Thời gian xuất bản
                        </label>
                        <input id="publish_at" type="datetime-local" name="publish_at" 
                               value="{{ old('publish_at', $post->publish_at?->format('Y-m-d\TH:i')) }}" 
                               class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d] transition-all">
                        @error('publish_at') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- NÚT BẤM THAO TÁC -->
            <div class="flex items-center gap-3 border-t border-[#3c2c15] pt-6">
                <button type="submit" id="blog-submit-btn" 
                        class="rounded-[2px] border border-[#f2d788]/50 bg-gradient-to-r from-[#7c1f22] to-[#8a641d] px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-[#f2d788] shadow-[0_0_15px_rgba(168,52,47,0.4)] hover:brightness-125 transition-all flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Cập nhật bài viết</span>
                </button>
                <a href="{{ route('admin.blog.index') }}" 
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

const blogForm = document.getElementById('blog-edit-form');
const blogSubmitBtn = document.getElementById('blog-submit-btn');

if (blogForm && blogSubmitBtn) {
    blogForm.addEventListener('submit', function () {
        blogSubmitBtn.disabled = true;
        blogSubmitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i> <span>Đang cập nhật...</span>';
    });
}
</script>
@endsection