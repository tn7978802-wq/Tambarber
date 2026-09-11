@extends('layouts.admin')

@section('title', 'Sửa tác phẩm')

@section('content')
<x-page-header title="Sửa tác phẩm" subtitle="{{ $item->title }}" />

<x-form-card>
    <form action="{{ route('admin.portfolio.update', $item) }}" method="POST" enctype="multipart/form-data" class="space-y-6 font-jost">
        @csrf @method('PUT')

        <div>
            <label class="block text-white/70 text-sm mb-2">Ảnh sau khi cắt</label>
            <label for="image_after"
                   class="flex items-center justify-center w-full h-48 rounded-xl border-2 border-dashed
                          border-white/15 hover:border-[#f2d788]/50 cursor-pointer bg-white/5 transition overflow-hidden relative group">
                <img id="preview-after"
                     src="{{ str_starts_with($item->image_after, 'http') ? $item->image_after : asset('storage/' . $item->image_after) }}"
                     class="w-full h-full object-cover" />
                <span class="absolute inset-0 bg-black/0 group-hover:bg-black/50 flex items-center justify-center
                             text-white/0 group-hover:text-white text-sm transition">
                    + Đổi ảnh
                </span>
            </label>
            <input type="file" id="image_after" name="image_after" accept="image/*" class="hidden"
                   onchange="previewImage(this, 'preview-after')">
            @error('image_after') <p class="text-[#a8342f] text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-white/70 text-sm mb-2">Ảnh trước khi cắt (tuỳ chọn)</label>
            <label for="image_before"
                   class="flex flex-col items-center justify-center w-full h-48 rounded-xl border-2 border-dashed
                          border-white/15 hover:border-[#f2d788]/50 cursor-pointer bg-white/5 transition overflow-hidden relative group">
                @if($item->image_before)
                    <img id="preview-before"
                         src="{{ str_starts_with($item->image_before, 'http') ? $item->image_before : asset('storage/' . $item->image_before) }}"
                         class="w-full h-full object-cover" />
                    <span class="absolute inset-0 bg-black/0 group-hover:bg-black/50 flex items-center justify-center
                                 text-white/0 group-hover:text-white text-sm transition">
                        + Đổi ảnh
                    </span>
                @else
                    <img id="preview-before" class="hidden w-full h-full object-cover" />
                    <span id="placeholder-before" class="flex flex-col items-center text-white/40">
                        <span class="text-3xl leading-none mb-1">+</span>
                        <span class="text-xs">Chọn ảnh từ thiết bị</span>
                    </span>
                @endif
            </label>
            <input type="file" id="image_before" name="image_before" accept="image/*" class="hidden"
                   onchange="previewImage(this, 'preview-before', 'placeholder-before')">
        </div>

        <div>
            <label class="block text-white/70 text-sm mb-2">Tiêu đề <span class="text-[#a8342f]">*</span></label>
            <input type="text" name="title" value="{{ old('title', $item->title) }}" required
                   class="w-full rounded-lg bg-white/5 border border-white/10 text-white px-4 py-2.5
                          focus:outline-none focus:border-[#f2d788]/50">
            @error('title') <p class="text-[#a8342f] text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-white/70 text-sm mb-2">Mô tả</label>
            <textarea name="description" rows="3"
                      class="w-full rounded-lg bg-white/5 border border-white/10 text-white px-4 py-2.5
                             focus:outline-none focus:border-[#f2d788]/50">{{ old('description', $item->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-white/70 text-sm mb-2">Danh mục <span class="text-[#a8342f]">*</span></label>
                <select name="category" required
                        class="w-full rounded-lg bg-white/5 border border-white/10 text-white px-4 py-2.5
                               focus:outline-none focus:border-[#f2d788]/50">
                    @foreach($categories as $slug => $label)
                        <option value="{{ $slug }}" @selected(old('category', $item->category) === $slug)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-white/70 text-sm mb-2">Barber thực hiện</label>
                <select name="barber_id"
                        class="w-full rounded-lg bg-white/5 border border-white/10 text-white px-4 py-2.5
                               focus:outline-none focus:border-[#f2d788]/50">
                    <option value="">— Không chọn —</option>
                    @foreach($barbers as $barber)
                        <option value="{{ $barber->id }}" @selected((string) old('barber_id', $item->barber_id) === (string) $barber->id)>
                            {{ $barber->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $item->is_featured))
                   class="w-4 h-4 rounded accent-[#f2d788]">
            <label for="is_featured" class="text-white/70 text-sm">Đánh dấu là tác phẩm nổi bật</label>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-white/10">
            <x-btn type="submit" variant="primary">Cập nhật</x-btn>
            <x-btn href="{{ route('admin.portfolio.index') }}" variant="ghost">Huỷ</x-btn>
        </div>
    </form>
</x-form-card>

<script>
function previewImage(input, previewId, placeholderId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        preview.classList.remove('hidden');
        if (placeholderId) document.getElementById(placeholderId)?.classList.add('hidden');
    }
}
</script>
@endsection
