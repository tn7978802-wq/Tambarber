@extends('layouts.admin')

@section('title', $product->name)

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-blue-800 hover:underline">← Danh mục vật tư</a>
            <p class="mt-3 font-mono text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $product->sku }}</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-950">{{ $product->name }}</h1>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.products.edit', $product) }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Sửa thông tin</a>
            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Xóa vật tư này?')">
                @csrf @method('DELETE')
                <button class="rounded-lg border border-rose-200 bg-white px-4 py-2.5 text-sm font-semibold text-rose-700 hover:bg-rose-50">Xóa</button>
            </form>
        </div>
    </div>

    <div class="grid gap-5 md:grid-cols-3">
        <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm md:col-span-2">
            <h2 class="font-semibold text-slate-900">Thông tin vật tư</h2>
            @if ($product->image)
                <img src="{{ '/storage/' . ltrim($product->image, '/') }}" alt="Ảnh {{ $product->name }}" class="mt-4 max-h-80 w-full rounded-lg border border-slate-200 bg-slate-50 object-contain">
            @endif
            <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                @foreach (['Danh mục' => $product->category->name, 'Hãng' => $product->brand ?: '—', 'Đơn vị' => $product->unit, 'Vị trí' => $product->location ?: '—'] as $label => $value)
                    <div><dt class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $label }}</dt><dd class="mt-1 text-sm font-semibold text-slate-800">{{ $value }}</dd></div>
                @endforeach
                <div class="sm:col-span-2"><dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Mô tả</dt><dd class="mt-1 whitespace-pre-line text-sm text-slate-700">{{ $product->description ?: 'Chưa có mô tả.' }}</dd></div>
            </dl>
        </article>
        @php($isLow = (float) $product->stock_quantity <= (float) $product->min_stock_alert)
        <article class="rounded-xl border {{ $isLow ? 'border-amber-200 bg-amber-50' : 'border-slate-200 bg-white' }} p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-600">Tồn kho hiện tại</p>
            <p class="mt-2 text-3xl font-bold text-slate-950">{{ number_format((float) $product->stock_quantity, 3) }}</p>
            <p class="mt-1 text-sm text-slate-600">{{ $product->unit }} · cảnh báo ở {{ number_format((float) $product->min_stock_alert, 3) }}</p>
            <span class="mt-4 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $isLow ? 'bg-amber-200 text-amber-900' : 'bg-emerald-100 text-emerald-800' }}">{{ $isLow ? 'Sắp hết hàng' : 'Đủ tồn' }}</span>
        </article>
    </div>

    <section class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4"><h2 class="font-semibold text-slate-900">Lịch sử giao dịch vật tư</h2></div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[650px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500"><tr><th class="px-5 py-3">Phiếu</th><th class="px-5 py-3">Ngày</th><th class="px-5 py-3">Loại</th><th class="px-5 py-3">Số lượng</th><th class="px-5 py-3">Người thực hiện</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transactions as $item)
                        <tr>
                            <td class="px-5 py-3"><a class="font-semibold text-blue-800 hover:underline" href="{{ route('admin.transactions.show', $item->transaction) }}">{{ $item->transaction->transaction_code }}</a></td>
                            <td class="px-5 py-3 text-slate-600">{{ $item->transaction->transaction_date->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-3 text-slate-600">{{ ['import' => 'Nhập kho', 'export' => 'Xuất kho', 'adjustment' => 'Kiểm kê'][$item->transaction->type] }}</td>
                            <td class="px-5 py-3 font-semibold {{ $item->transaction->type === 'import' ? 'text-emerald-700' : ($item->transaction->type === 'export' ? 'text-blue-800' : 'text-amber-700') }}">{{ $item->transaction->type === 'export' ? '-' : ($item->transaction->type === 'import' ? '+' : '') }}{{ number_format((float) $item->quantity, 3) }} {{ $product->unit }}</td>
                            <td class="px-5 py-3 text-slate-600">{{ $item->transaction->user?->fullname ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center text-slate-500">Vật tư chưa có giao dịch.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($transactions->hasPages())<div class="border-t border-slate-200 px-5 py-4">{{ $transactions->links() }}</div>@endif
    </section>
@endsection
