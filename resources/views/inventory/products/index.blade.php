@extends('layouts.admin')

@section('title', 'Danh mục vật tư')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-blue-800">DANH MỤC KHO</p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Vật tư &amp; thiết bị</h1>
            <p class="mt-1 text-sm text-slate-500">Tìm theo SKU, tên thiết bị hoặc hãng; tồn kho chỉ thay đổi qua phiếu giao dịch.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.exports.products') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Xuất CSV</a>
            <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-blue-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">＋ Thêm vật tư</a>
        </div>
    </div>

    <form method="GET" class="mb-5 grid gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-[1fr_240px_auto_auto]">
        <input name="q" value="{{ request('q') }}" placeholder="Tìm SKU, tên hoặc hãng..." class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <select name="category_id" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            <option value="">Tất cả danh mục</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        <button class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Lọc</button>
        <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">Xóa lọc</a>
    </form>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr><th class="px-5 py-3">Mã SKU</th><th class="px-5 py-3">Vật tư</th><th class="px-5 py-3">Danh mục / Hãng</th><th class="px-5 py-3">Vị trí</th><th class="px-5 py-3 text-right">Tồn kho</th><th class="px-5 py-3">Trạng thái</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        @php($lowStock = (float) $product->stock_quantity <= (float) $product->min_stock_alert)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4 font-mono text-xs font-semibold text-slate-700">{{ $product->sku }}</td>
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.products.show', $product) }}" class="font-semibold text-blue-800 hover:underline">{{ $product->name }}</a>
                                <p class="mt-1 text-xs text-slate-500">{{ $product->brand ?: 'Chưa xác định hãng' }}</p>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $product->category->name }}<span class="mt-1 block text-xs text-slate-400">{{ $product->brand ?: '—' }}</span></td>
                            <td class="px-5 py-4 text-slate-600">{{ $product->location ?: '—' }}</td>
                            <td class="px-5 py-4 text-right font-semibold text-slate-900">{{ number_format((float) $product->stock_quantity, 3) }} <span class="font-normal text-slate-500">{{ $product->unit }}</span></td>
                            <td class="px-5 py-4">
                                @if ($lowStock)
                                    <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-800">Sắp hết hàng</span>
                                @else
                                    <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800">Đủ tồn</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-slate-500">Không tìm thấy vật tư phù hợp.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($products->hasPages())
            <div class="border-t border-slate-200 px-5 py-4">{{ $products->links() }}</div>
        @endif
    </div>
@endsection
