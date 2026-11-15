@extends('layouts.admin')

@section('title', $transaction->transaction_code)

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <a href="{{ route('admin.transactions.index') }}" class="text-sm font-medium text-blue-800 hover:underline">← Lịch sử giao dịch</a>
            <p class="mt-3 text-sm font-semibold uppercase tracking-wide text-blue-800">{{ ['import' => 'Phiếu nhập kho', 'export' => 'Phiếu xuất kho thi công', 'adjustment' => 'Phiếu kiểm kê / điều chỉnh'][$transaction->type] }}</p>
            <h1 class="mt-1 font-mono text-2xl font-bold text-slate-950">{{ $transaction->transaction_code }}</h1>
        </div>
        <a href="{{ route('admin.transactions.print', $transaction) }}" target="_blank" class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">In phiếu</a>
    </div>
    <section class="grid gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm md:grid-cols-3">
        <div><p class="text-xs font-medium uppercase tracking-wide text-slate-500">Dự án / Nhà cung cấp</p><p class="mt-1 font-semibold text-slate-900">{{ $transaction->project_or_supplier_name }}</p></div>
        <div><p class="text-xs font-medium uppercase tracking-wide text-slate-500">Ngày giao dịch</p><p class="mt-1 font-semibold text-slate-900">{{ $transaction->transaction_date->format('d/m/Y H:i') }}</p></div>
        <div><p class="text-xs font-medium uppercase tracking-wide text-slate-500">Người thực hiện</p><p class="mt-1 font-semibold text-slate-900">{{ $transaction->user?->fullname ?? '—' }}</p></div>
        <div class="md:col-span-3"><p class="text-xs font-medium uppercase tracking-wide text-slate-500">Ghi chú</p><p class="mt-1 whitespace-pre-line text-sm text-slate-700">{{ $transaction->note ?: '—' }}</p></div>
    </section>

    <section class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4"><h2 class="font-semibold text-slate-900">Chi tiết vật tư</h2></div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[750px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500"><tr><th class="px-5 py-3">SKU</th><th class="px-5 py-3">Vật tư</th><th class="px-5 py-3">Số lượng</th><th class="px-5 py-3">Đơn giá</th><th class="px-5 py-3">Serial / MAC</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($transaction->items as $item)
                        <tr>
                            <td class="px-5 py-4 font-mono text-xs text-slate-600">{{ $item->product->sku }}</td>
                            <td class="px-5 py-4"><a href="{{ route('admin.products.show', $item->product) }}" class="font-semibold text-blue-800 hover:underline">{{ $item->product->name }}</a></td>
                            <td class="px-5 py-4 font-semibold text-slate-900">{{ number_format((float) $item->quantity, 3) }} {{ $item->product->unit }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $item->unit_price !== null ? number_format((float) $item->unit_price, 0, ',', '.') . ' đ' : '—' }}</td>
                            <td class="px-5 py-4 text-xs text-slate-600">{{ implode(', ', $item->serial_numbers ?? []) ?: '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
