@extends('layouts.admin')

@section('title', 'Sửa bài viết')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex items-center justify-between gap-4 border-b border-[#3c2c15] pb-5">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#6f6248]">Cập nhật</p>
            <h1 class="font-['Bebas_Neue'] text-4xl tracking-wider text-[#f2d788] uppercase">Sửa bài viết</h1>
        </div>

        <a href="{{ route('admin.blog.index') }}" class="rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3.5 py-2 text-xs font-bold uppercase tracking-wider text-[#f4ecd8] hover:border-[#8a641d] hover:text-[#f2d788] transition-all">
            Quay lại
        </a>
    </div>

    <form action="{{ route('admin.blog.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6 rounded-[2px] border border-[#3c2c15] bg-[#171008] p-6 shadow-xl">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="title" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#f2d788]">Tiêu đề <span class="text-red-500">*</span></label>
                <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}" required class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">
                @error('title') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80">Slug</label>
                <input id="slug" type="text" name="slug" value="{{ old('slug', $post->slug) }}" class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">
                @error('slug') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="category" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80">Danh mục</label>
                <input id="category" type="text" name="category" value="{{ old('category', $post->category) }}" class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">
            </div>

            <div class="md:col-span-2">
                <label for="excerpt" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80">Mô tả ngắn</label>
                <textarea id="excerpt" name="excerpt" rows="3" class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label for="content" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#f2d788]">Nội dung <span class="text-red-500">*</span></label>
                <textarea id="content" name="content" rows="12" required class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">{{ old('content', $post->content) }}</textarea>
                @error('content') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80">Ảnh đại diện</label>
                <label for="thumbnail" class="flex min-h-[180px] cursor-pointer flex-col items-center justify-center rounded-[2px] border-2 border-dashed border-[#3c2c15] bg-[#0b0805] p-4 text-center transition hover:border-[#8a641d]">
                    <img id="thumbnail-preview" src="{{ old('thumbnail', $post->thumbnail) ? (str_starts_with((string) old('thumbnail', $post->thumbnail), 'http') ? old('thumbnail', $post->thumbnail) : asset('storage/' . old('thumbnail', $post->thumbnail))) : '' }}" class="{{ old('thumbnail', $post->thumbnail) ? '' : 'hidden' }} max-h-44 w-full rounded-[2px] object-cover" alt="preview">
                    <span id="thumbnail-placeholder" class="{{ old('thumbnail', $post->thumbnail) ? 'hidden' : 'flex' }} flex-col items-center text-[#6f6248]">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl mb-3"></i>
                        <span class="text-xs font-semibold">Tải ảnh từ máy</span>
                        <span class="mt-1 text-[10px]">PNG, JPG, WEBP, GIF</span>
                    </span>
                </label>
                <input id="thumbnail" type="file" name="thumbnail" accept="image/*" class="hidden" onchange="previewImage(this, 'thumbnail-preview', 'thumbnail-placeholder')">
                @error('thumbnail') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="status" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80">Trạng thái</label>
                <select id="status" name="status" class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">
                    <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Nháp</option>
                    <option value="scheduled" {{ old('status', $post->status) === 'scheduled' ? 'selected' : '' }}>Chờ xuất bản</option>
                    <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Xuất bản</option>
                </select>
                @error('status') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label for="publish_at" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]/80">Ngày đăng</label>
                <input id="publish_at" type="datetime-local" name="publish_at" value="{{ old('publish_at', $post->publish_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">
                @error('publish_at') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center gap-3 border-t border-[#3c2c15] pt-6">
            <button type="submit" class="rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-[#0b0805] shadow-md hover:brightness-110 transition-all">
                Cập nhật bài viết
            </button>
            <a href="{{ route('admin.blog.index') }}" class="rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-[#f4ecd8] hover:border-[#8a641d] hover:text-[#f2d788] transition-all">
                Hủy bỏ
            </a>
        </div>
    </form>
</div>

<script>
function previewImage(input, previewId, placeholderId) {
    const preview = document.getElementById(previewId);
    const placeholder = document.getElementById(placeholderId);
    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
    }
}
</script>
@endsection