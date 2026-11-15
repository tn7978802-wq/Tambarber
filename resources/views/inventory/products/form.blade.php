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
            <label class="block text-sm font-medium text-slate-700">Ảnh vật tư
                <input type="file" name="image" accept="image/*" class="mt-1.5 block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-slate-700">
            </label>
            @if ($product->exists)
                <div class="rounded-lg bg-slate-50 p-3 text-sm text-slate-600">
                    Tồn hiện tại: <strong class="text-slate-900">{{ number_format((float) $product->stock_quantity, 3) }} {{ $product->unit }}</strong>.
                    Điều chỉnh tồn kho qua phiếu nhập/xuất hoặc kiểm kê.
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
