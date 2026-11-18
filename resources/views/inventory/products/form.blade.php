@extends('layouts.admin')

@section('title', $product->exists ? 'Cập nhật vật tư' : 'Thêm vật tư')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-blue-800 hover:underline">← Danh mục vật tư</a>
        <h1 class="mt-3 text-2xl font-bold text-slate-950">{{ $product->exists ? 'Cập nhật thông tin vật tư' : 'Thêm vật tư mới' }}</h1>
    </div>

    <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data" class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @if ($product->exists) @method('PUT') @endif
        <input type="hidden" name="remove_image" id="remove-image-input" value="0">
        <div class="grid gap-5 md:grid-cols-2">
            <label class="block text-sm font-medium text-slate-700">Mã SKU / barcode *
                <input name="sku" value="{{ old('sku', $product->sku) }}" required maxlength="100" class="mt-1.5 w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
                @error('sku')<span class="mt-1 block text-xs text-rose-700">{{ $message }}</span>@enderror
            </label>
            <label class="block text-sm font-medium text-slate-700">Tên vật tư *
                <input name="name" value="{{ old('name', $product->name) }}" required maxlength="255" class="mt-1.5 w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
                @error('name')<span class="mt-1 block text-xs text-rose-700">{{ $message }}</span>@enderror
            </label>
            <label class="block text-sm font-medium text-slate-700">Danh mục *
                <select name="category_id" required class="mt-1.5 w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
                    <option value="">Chọn danh mục</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<span class="mt-1 block text-xs text-rose-700">{{ $message }}</span>@enderror
            </label>
            <label class="block text-sm font-medium text-slate-700">Hãng sản xuất
                <input name="brand" value="{{ old('brand', $product->brand) }}" maxlength="100" class="mt-1.5 w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            </label>
            <label class="block text-sm font-medium text-slate-700">Đơn vị tính *
                <select name="unit" required class="mt-1.5 w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
                    @foreach (['Cái', 'Cuộn', 'Hộp', 'Mét', 'Bịch', 'Bộ', 'Thùng'] as $unit)
                        <option value="{{ $unit }}" @selected(old('unit', $product->unit ?: 'Cái') === $unit)>{{ $unit }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block text-sm font-medium text-slate-700">Định mức cảnh báo *
                <input type="number" name="min_stock_alert" value="{{ old('min_stock_alert', $product->min_stock_alert ?? 0) }}" min="0" step="0.001" required class="mt-1.5 w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            </label>
            <label class="block text-sm font-medium text-slate-700">Vị trí kệ / tủ
                <input name="location" value="{{ old('location', $product->location) }}" maxlength="255" placeholder="Ví dụ: Kệ A-01" class="mt-1.5 w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            </label>
            <div class="text-sm font-medium text-slate-700 md:col-span-2">
                <span>Ảnh vật tư</span>
                <div id="image-dropzone" class="mt-1.5 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 p-6 text-center transition-colors hover:border-blue-500 hover:bg-blue-50 focus-within:border-blue-700 focus-within:ring-2 focus-within:ring-blue-200">
                    <input
                        id="product-image-input"
                        type="file"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        aria-describedby="image-dropzone-help image-upload-message"
                        class="block w-full cursor-pointer text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-900 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-800"
                    >
                    <p id="image-dropzone-help" class="mt-3 text-sm text-slate-600">Bấm để chọn ảnh, kéo thả ảnh vào đây, hoặc nhấn Ctrl+V để dán ảnh trực tiếp</p>
                    <p class="mt-1 text-xs font-normal text-slate-500">Hỗ trợ JPG, PNG, WebP; dung lượng tối đa 5 MB.</p>
                </div>
                <div id="image-upload-message" class="mt-2 text-sm font-medium text-rose-700" role="status" aria-live="polite"></div>
                <div id="image-preview" class="{{ $product->image ? 'mt-4 flex' : 'mt-4 hidden' }} items-center gap-4 rounded-lg border border-slate-200 bg-white p-3">
                    <img
                        id="image-preview-element"
                        @if ($product->image) src="{{ '/storage/' . ltrim($product->image, '/') }}" @endif
                        data-existing-src="{{ $product->image ? '/storage/' . ltrim($product->image, '/') : '' }}"
                        alt="{{ $product->image ? 'Ảnh ' . $product->name : '' }}"
                        class="h-24 w-24 shrink-0 rounded-lg border border-slate-200 bg-slate-50 object-contain"
                    >
                    <div class="min-w-0 flex-1">
                        <p id="image-preview-name" class="truncate text-sm font-semibold text-slate-800">{{ $product->image ? 'Ảnh hiện tại' : '' }}</p>
                        <p id="image-preview-size" class="mt-1 text-xs text-slate-500"></p>
                    </div>
                    <button id="clear-image-button" type="button" class="{{ $product->image ? '' : 'hidden' }} shrink-0 rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">
                        Xóa ảnh / Chọn lại
                    </button>
                </div>
                @error('image')<span class="mt-1 block text-xs text-rose-700">{{ $message }}</span>@enderror
            </div>
            @if ($product->exists)
                <div class="space-y-3 rounded-lg bg-slate-50 p-3 text-sm text-slate-600">
                    <p>Tồn hiện tại: <strong class="text-slate-900">{{ number_format((float) $product->stock_quantity, 3) }} {{ $product->unit }}</strong>.
                    Điều chỉnh tồn kho qua phiếu nhập/xuất hoặc kiểm kê.</p>
                </div>
            @endif
            <label class="block text-sm font-medium text-slate-700 md:col-span-2">Mô tả
                <textarea name="description" rows="4" class="mt-1.5 w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">{{ old('description', $product->description) }}</textarea>
            </label>
        </div>
        <div class="mt-6 flex justify-end gap-3 border-t border-slate-200 pt-5">
            <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Hủy</a>
            <button class="rounded-lg bg-blue-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">{{ $product->exists ? 'Lưu thay đổi' : 'Tạo vật tư' }}</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        (() => {
            const input = document.getElementById('product-image-input');
            const dropzone = document.getElementById('image-dropzone');
            const preview = document.getElementById('image-preview');
            const previewImage = document.getElementById('image-preview-element');
            const previewName = document.getElementById('image-preview-name');
            const previewSize = document.getElementById('image-preview-size');
            const clearButton = document.getElementById('clear-image-button');
            const removeImageInput = document.getElementById('remove-image-input');
            const message = document.getElementById('image-upload-message');
            const maximumBytes = 5 * 1024 * 1024;
            const supportedTypes = ['image/png', 'image/jpeg', 'image/webp'];
            const existingImage = previewImage.dataset.existingSrc;
            let previewObjectUrl = null;

            const formatSize = (bytes) => `${(bytes / (1024 * 1024)).toFixed(2)} MB`;

            const showMessage = (text = '') => {
                message.textContent = text;
            };

            const releasePreviewUrl = () => {
                if (previewObjectUrl) {
                    URL.revokeObjectURL(previewObjectUrl);
                    previewObjectUrl = null;
                }
            };

            const showExistingImage = () => {
                releasePreviewUrl();
                if (existingImage && removeImageInput.value !== '1') {
                    previewImage.src = existingImage;
                    previewImage.alt = 'Ảnh vật tư hiện tại';
                    previewName.textContent = 'Ảnh hiện tại';
                    previewSize.textContent = '';
                    preview.classList.remove('hidden');
                    preview.classList.add('flex');
                    clearButton.classList.remove('hidden');
                } else {
                    previewImage.removeAttribute('src');
                    previewName.textContent = '';
                    previewSize.textContent = '';
                    preview.classList.add('hidden');
                    preview.classList.remove('flex');
                    clearButton.classList.add('hidden');
                }
            };

            const clearSelectedFile = () => {
                input.value = '';
                showExistingImage();
            };

            const assignFile = (file) => {
                if (!supportedTypes.includes(file.type.toLowerCase())) {
                    clearSelectedFile();
                    showMessage('Định dạng ảnh không được hỗ trợ. Vui lòng chọn PNG, JPG/JPEG hoặc WebP.');
                    return;
                }

                if (file.size > maximumBytes) {
                    clearSelectedFile();
                    showMessage('Ảnh vượt quá dung lượng tối đa 5 MB. Vui lòng chọn ảnh nhỏ hơn.');
                    return;
                }

                try {
                    const transfer = new DataTransfer();
                    transfer.items.add(file);
                    input.files = transfer.files;
                } catch (error) {
                    clearSelectedFile();
                    showMessage('Trình duyệt không thể đính kèm ảnh này. Vui lòng chọn ảnh bằng nút tải lên.');
                    return;
                }

                removeImageInput.value = '0';
                showMessage('');
                releasePreviewUrl();
                previewObjectUrl = URL.createObjectURL(file);
                previewImage.src = previewObjectUrl;
                previewImage.alt = `Xem trước ${file.name || 'ảnh vật tư'}`;
                previewName.textContent = file.name || 'Ảnh từ clipboard';
                previewSize.textContent = formatSize(file.size);
                preview.classList.remove('hidden');
                preview.classList.add('flex');
                clearButton.classList.remove('hidden');
            };

            input.addEventListener('change', () => {
                const file = input.files?.[0];
                if (file) {
                    assignFile(file);
                }
            });

            clearButton.addEventListener('click', () => {
                if (input.files?.length) {
                    input.value = '';
                    removeImageInput.value = '0';
                    showExistingImage();
                    showMessage('');
                    return;
                }

                if (existingImage && removeImageInput.value !== '1') {
                    removeImageInput.value = '1';
                    showExistingImage();
                    showMessage('Ảnh hiện tại sẽ được xóa khi bạn lưu thay đổi.');
                }
            });

            ['dragenter', 'dragover'].forEach((eventName) => {
                dropzone.addEventListener(eventName, (event) => {
                    event.preventDefault();
                    dropzone.classList.add('border-blue-700', 'bg-blue-50');
                });
            });

            ['dragleave', 'drop'].forEach((eventName) => {
                dropzone.addEventListener(eventName, (event) => {
                    event.preventDefault();
                    dropzone.classList.remove('border-blue-700', 'bg-blue-50');
                });
            });

            dropzone.addEventListener('drop', (event) => {
                const file = event.dataTransfer?.files?.[0];
                if (file) {
                    assignFile(file);
                } else {
                    showMessage('Vui lòng kéo thả một tệp ảnh vào vùng này.');
                }
            });

            window.addEventListener('paste', (event) => {
                const items = Array.from(event.clipboardData?.items ?? []);
                const imageItem = items.find((item) => item.kind === 'file' && item.type.startsWith('image/'));
                if (!imageItem) {
                    return;
                }

                event.preventDefault();
                const file = imageItem.getAsFile();
                if (!file) {
                    showMessage('Không thể đọc ảnh từ clipboard. Vui lòng thử lại hoặc chọn tệp ảnh.');
                    return;
                }

                assignFile(file);
            });

            showExistingImage();
        })();
    </script>
@endpush
