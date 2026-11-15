@extends('layouts.admin')

@section('title', ['import' => 'Tạo phiếu nhập', 'export' => 'Tạo phiếu xuất', 'adjustment' => 'Kiểm kê tồn kho'][$type])

@section('content')
    @php
        $typeLabels = ['import' => 'Nhập kho', 'export' => 'Xuất kho thi công', 'adjustment' => 'Kiểm kê / điều chỉnh'];
        $items = old('items', [['product_id' => '', 'quantity' => '', 'unit_price' => '', 'serial_numbers' => '']]);
        $oldProductIds = collect($items)->pluck('product_id')->filter()->all();
    @endphp
    <div class="mb-6">
        <a href="{{ route('admin.transactions.index') }}" class="text-sm font-medium text-blue-800 hover:underline">← Lịch sử giao dịch</a>
        <h1 class="mt-3 text-2xl font-bold text-slate-950">{{ $typeLabels[$type] }}</h1>
        <p class="mt-1 text-sm text-slate-500">Phiếu sẽ được ghi nhận ngay sau khi lưu; tồn kho được cập nhật trong cùng giao dịch dữ liệu.</p>
    </div>

    <form method="POST" action="{{ route('admin.transactions.store') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">
        <section class="grid gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm md:grid-cols-2">
            @if ($type === 'import')
                <label class="text-sm font-medium text-slate-700">Nhà cung cấp *
                    <select name="supplier_id" required class="mt-1.5 w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
                        <option value="">Chọn nhà cung cấp</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </label>
            @elseif ($type === 'export')
                <label class="text-sm font-medium text-slate-700">Dự án / chi nhánh nhận hàng *
                    <select name="project_id" required class="mt-1.5 w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
                        <option value="">Chọn dự án / chi nhánh</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}" @selected(old('project_id') == $project->id)>{{ $project->name }}{{ $project->code ? ' · ' . $project->code : '' }}</option>
                        @endforeach
                    </select>
                </label>
            @else
                <label class="text-sm font-medium text-slate-700">Lý do / người thực hiện kiểm kê *
                    <input name="project_or_supplier_name" value="{{ old('project_or_supplier_name') }}" required maxlength="255" placeholder="Ví dụ: Kiểm kê định kỳ tháng 11" class="mt-1.5 w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
                </label>
            @endif
            <label class="text-sm font-medium text-slate-700">Ngày giao dịch *
                <input type="datetime-local" name="transaction_date" value="{{ old('transaction_date', now()->format('Y-m-d\TH:i')) }}" required class="mt-1.5 w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            </label>
            <label class="text-sm font-medium text-slate-700 md:col-span-2">Ghi chú
                <textarea name="note" rows="2" class="mt-1.5 w-full rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">{{ old('note') }}</textarea>
            </label>
        </section>

        <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-5 py-4">
                <div>
                    <h2 class="font-semibold text-slate-900">Vật tư trong phiếu</h2>
                    @if ($type === 'adjustment')
                        <p class="mt-1 text-xs text-slate-500">Nhập số dương để tăng tồn, số âm để giảm tồn.</p>
                    @else
                        <p class="mt-1 text-xs text-slate-500">Số lượng xuất sẽ được kiểm tra và chặn nếu vượt tồn khả dụng.</p>
                    @endif
                </div>
                <button id="add-item" type="button" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">＋ Thêm dòng vật tư</button>
            </div>
            <div id="items-container" class="space-y-4 p-5">
                @foreach ($items as $index => $item)
                    @php($selectedProduct = isset($item['product_id']) ? \App\Models\Product::find($item['product_id']) : null)
                    @php($serials = is_array($item['serial_numbers'] ?? null) ? implode("\n", $item['serial_numbers']) : ($item['serial_numbers'] ?? ''))
                    <div class="inventory-item rounded-lg border border-slate-200 bg-slate-50 p-4">
                        <div class="grid gap-4 md:grid-cols-2">
                            <label class="relative text-sm font-medium text-slate-700">Tìm vật tư theo SKU / tên / hãng *
                                <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $selectedProduct?->id }}" class="product-id">
                                <input type="search" value="{{ $selectedProduct ? $selectedProduct->sku . ' — ' . $selectedProduct->name : '' }}" autocomplete="off" placeholder="Nhập mã hoặc tên vật tư..." class="product-search mt-1.5 w-full rounded-lg border-slate-300 bg-white text-sm focus:border-blue-700 focus:ring-blue-700">
                                <div class="product-suggestions absolute z-20 mt-1 hidden max-h-60 w-full overflow-auto rounded-lg border border-slate-200 bg-white shadow-lg"></div>
                                @if ($selectedProduct)<span class="mt-1 block text-xs text-slate-500 product-stock">Tồn hiện tại: {{ number_format((float) $selectedProduct->stock_quantity, 3) }} {{ $selectedProduct->unit }}</span>@else<span class="mt-1 block text-xs text-slate-500 product-stock"></span>@endif
                            </label>
                            <div class="grid grid-cols-[1fr_1fr_auto] items-end gap-3">
                                <label class="text-sm font-medium text-slate-700">Số lượng *
                                    <input type="number" step="0.001" @if ($type !== 'adjustment') min="0.001" @endif name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] ?? '' }}" required class="mt-1.5 w-full rounded-lg border-slate-300 bg-white text-sm focus:border-blue-700 focus:ring-blue-700">
                                </label>
                                <label class="text-sm font-medium text-slate-700">Đơn giá
                                    <input type="number" min="0" step="0.01" name="items[{{ $index }}][unit_price]" value="{{ $item['unit_price'] ?? '' }}" class="mt-1.5 w-full rounded-lg border-slate-300 bg-white text-sm focus:border-blue-700 focus:ring-blue-700">
                                </label>
                                <button type="button" class="remove-item mb-0.5 rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-600 hover:bg-white" aria-label="Xóa dòng">Xóa</button>
                            </div>
                            <label class="text-sm font-medium text-slate-700 md:col-span-2">Serial Number / MAC (mỗi dòng một mã)
                                <textarea name="items[{{ $index }}][serial_numbers]" rows="2" placeholder="SN-001&#10;MAC-00:11:22..." class="mt-1.5 w-full rounded-lg border-slate-300 bg-white text-sm focus:border-blue-700 focus:ring-blue-700">{{ $serials }}</textarea>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            <template id="item-template">
                <div class="inventory-item rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="relative text-sm font-medium text-slate-700">Tìm vật tư theo SKU / tên / hãng *
                            <input type="hidden" class="product-id">
                            <input type="search" autocomplete="off" placeholder="Nhập mã hoặc tên vật tư..." class="product-search mt-1.5 w-full rounded-lg border-slate-300 bg-white text-sm focus:border-blue-700 focus:ring-blue-700">
                            <div class="product-suggestions absolute z-20 mt-1 hidden max-h-60 w-full overflow-auto rounded-lg border border-slate-200 bg-white shadow-lg"></div>
                            <span class="product-stock mt-1 block text-xs text-slate-500"></span>
                        </label>
                        <div class="grid grid-cols-[1fr_1fr_auto] items-end gap-3">
                            <label class="text-sm font-medium text-slate-700">Số lượng *
                                <input type="number" step="0.001" @if ($type !== 'adjustment') min="0.001" @endif required class="quantity-input mt-1.5 w-full rounded-lg border-slate-300 bg-white text-sm focus:border-blue-700 focus:ring-blue-700">
                            </label>
                            <label class="text-sm font-medium text-slate-700">Đơn giá
                                <input type="number" min="0" step="0.01" class="price-input mt-1.5 w-full rounded-lg border-slate-300 bg-white text-sm focus:border-blue-700 focus:ring-blue-700">
                            </label>
                            <button type="button" class="remove-item mb-0.5 rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-600 hover:bg-white" aria-label="Xóa dòng">Xóa</button>
                        </div>
                        <label class="text-sm font-medium text-slate-700 md:col-span-2">Serial Number / MAC (mỗi dòng một mã)
                            <textarea rows="2" placeholder="SN-001&#10;MAC-00:11:22..." class="serial-input mt-1.5 w-full rounded-lg border-slate-300 bg-white text-sm focus:border-blue-700 focus:ring-blue-700"></textarea>
                        </label>
                    </div>
                </div>
            </template>
            <div class="border-t border-slate-200 bg-slate-50 px-5 py-4 text-right">
                <button class="rounded-lg bg-blue-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">Lưu phiếu và cập nhật tồn kho</button>
            </div>
        </section>
    </form>
@endsection

@push('scripts')
<script>
(() => {
    const container = document.getElementById('items-container');
    const template = document.getElementById('item-template');
    const lookupUrl = @json(route('admin.products.lookup'));
    let nextIndex = {{ count($items) }};
    let timer;

    function bindRow(row) {
        const search = row.querySelector('.product-search');
        const idInput = row.querySelector('.product-id');
        const suggestions = row.querySelector('.product-suggestions');
        const stockLabel = row.querySelector('.product-stock');

        search.addEventListener('input', () => {
            idInput.value = '';
            stockLabel.textContent = '';
            clearTimeout(timer);
            timer = setTimeout(async () => {
                const url = new URL(lookupUrl, window.location.origin);
                url.searchParams.set('q', search.value);
                try {
                    const response = await fetch(url, {headers: {'Accept': 'application/json'}});
                    if (!response.ok) throw new Error('Không thể tải gợi ý vật tư.');
                    const products = await response.json();
                    suggestions.replaceChildren();
                    products.forEach((product) => {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'block w-full px-3 py-2 text-left text-sm hover:bg-blue-50';
                        button.textContent = `${product.sku} — ${product.name} · Tồn ${Number(product.stock_quantity).toLocaleString()} ${product.unit}`;
                        button.addEventListener('click', () => {
                            idInput.value = product.id;
                            search.value = `${product.sku} — ${product.name}`;
                            stockLabel.textContent = `Tồn hiện tại: ${Number(product.stock_quantity).toLocaleString()} ${product.unit}`;
                            suggestions.classList.add('hidden');
                        });
                        suggestions.append(button);
                    });
                    if (products.length === 0) {
                        const empty = document.createElement('p');
                        empty.className = 'px-3 py-2 text-sm text-slate-500';
                        empty.textContent = 'Không tìm thấy vật tư.';
                        suggestions.append(empty);
                    }
                    suggestions.classList.remove('hidden');
                } catch (error) {
                    suggestions.replaceChildren();
                    const message = document.createElement('p');
                    message.className = 'px-3 py-2 text-sm text-rose-700';
                    message.textContent = error instanceof Error ? error.message : 'Lỗi khi tải gợi ý vật tư.';
                    suggestions.append(message);
                    suggestions.classList.remove('hidden');
                }
            }, 180);
        });

        row.querySelector('.remove-item').addEventListener('click', () => {
            if (container.querySelectorAll('.inventory-item').length > 1) row.remove();
        });
    }

    container.querySelectorAll('.inventory-item').forEach(bindRow);
    document.getElementById('add-item').addEventListener('click', () => {
        const fragment = template.content.cloneNode(true);
        const row = fragment.querySelector('.inventory-item');
        row.querySelector('.product-id').name = `items[${nextIndex}][product_id]`;
        row.querySelector('.quantity-input').name = `items[${nextIndex}][quantity]`;
        row.querySelector('.price-input').name = `items[${nextIndex}][unit_price]`;
        row.querySelector('.serial-input').name = `items[${nextIndex}][serial_numbers]`;
        nextIndex++;
        container.append(fragment);
        bindRow(container.lastElementChild);
    });
})();
</script>
@endpush
