@extends('layouts.admin')

@section('title', 'Tổng quan kho')

@section('content')
    <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-blue-800">TỔNG QUAN</p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Kho vật tư mạng &amp; CCTV</h1>
            <p class="mt-1 text-sm text-slate-500">Tình hình tồn kho và luân chuyển vật tư.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.transactions.create', 'import') }}" class="rounded-lg bg-blue-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">＋ Nhập kho</a>
            <a href="{{ route('admin.transactions.create', 'export') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Xuất kho</a>
        </div>
    </div>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['Tổng mã vật tư', number_format($totalProducts), 'SKU đang được quản lý', 'text-blue-800'],
            ['Tổng số lượng tồn', number_format((float) $totalStockQuantity, 3), 'Tổng số lượng theo đơn vị', 'text-slate-900'],
            ['Cảnh báo dưới định mức', number_format($lowStockCount), 'Cần kiểm tra và bổ sung', 'text-amber-700'],
            ['Phiếu trong tháng', number_format($monthlyImportCount + $monthlyExportCount), number_format($monthlyImportCount) . ' nhập · ' . number_format($monthlyExportCount) . ' xuất', 'text-emerald-700'],
        ] as [$label, $value, $hint, $color])
            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                <p class="mt-3 text-3xl font-bold tracking-tight {{ $color }}">{{ $value }}</p>
                <p class="mt-2 text-xs text-slate-500">{{ $hint }}</p>
            </article>
        @endforeach
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-[1.4fr_1fr]">
        <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="font-semibold text-slate-900">Biến động nhập / xuất</h2>
                    <p class="mt-1 text-sm text-slate-500">Số phiếu trong 6 tháng gần nhất</p>
                </div>
                <div class="flex gap-4 text-xs font-medium">
                    <span class="inline-flex items-center gap-2 text-slate-600"><i class="h-2.5 w-2.5 rounded-sm bg-blue-700"></i>Nhập</span>
                    <span class="inline-flex items-center gap-2 text-slate-600"><i class="h-2.5 w-2.5 rounded-sm bg-amber-500"></i>Xuất</span>
                </div>
            </div>
            @php($maxCount = max(1, (int) $chart->max(fn ($point) => max($point['imports'], $point['exports']))))
            <div class="mt-6 grid h-52 grid-cols-6 items-end gap-3 border-b border-slate-200 pb-2 sm:gap-6">
                @foreach ($chart as $point)
                    <div class="flex h-full flex-col items-center justify-end gap-2">
                        <div class="flex h-full items-end gap-1">
                            <span title="Nhập: {{ $point['imports'] }}" class="w-4 rounded-t bg-blue-700 sm:w-6" style="height: {{ max(3, (int) round($point['imports'] / $maxCount * 100)) }}%"></span>
                            <span title="Xuất: {{ $point['exports'] }}" class="w-4 rounded-t bg-amber-500 sm:w-6" style="height: {{ max(3, (int) round($point['exports'] / $maxCount * 100)) }}%"></span>
                        </div>
                        <span class="text-[11px] text-slate-500">{{ $point['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <div>
                    <h2 class="font-semibold text-slate-900">Cần nhập bổ sung</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $lowStockCount }} mã dưới định mức</p>
                </div>
                <a href="{{ route('admin.products.index', ['stock' => 'low']) }}" class="text-sm font-semibold text-blue-800 hover:text-blue-950">Tất cả</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($lowStockProducts as $product)
                    <a href="{{ route('admin.products.show', $product) }}" class="flex items-center justify-between gap-4 px-5 py-3 hover:bg-slate-50">
                        <span class="min-w-0">
                            <span class="block truncate text-sm font-semibold text-slate-800">{{ $product->name }}</span>
                            <span class="mt-0.5 block text-xs text-slate-500">{{ $product->sku }} · {{ $product->location ?: 'Chưa xếp vị trí' }}</span>
                        </span>
                        <span class="shrink-0 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-800">
                            {{ number_format((float) $product->stock_quantity, 3) }} / {{ number_format((float) $product->min_stock_alert, 3) }} {{ $product->unit }}
                        </span>
                    </a>
                @empty
                    <p class="px-5 py-8 text-center text-sm text-slate-500">Không có vật tư nào dưới định mức.</p>
                @endforelse
            </div>
        </article>
    </section>

    <section class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
            <div>
                <h2 class="font-semibold text-slate-900">Giao dịch gần đây</h2>
                <p class="mt-1 text-sm text-slate-500">Các phiếu nhập, xuất và kiểm kê mới nhất</p>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="text-sm font-semibold text-blue-800 hover:text-blue-950">Xem lịch sử</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr><th class="px-5 py-3">Mã phiếu</th><th class="px-5 py-3">Loại</th><th class="px-5 py-3">Ngày</th><th class="px-5 py-3">Dự án / Nhà cung cấp</th><th class="px-5 py-3">Người thực hiện</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recentTransactions as $transaction)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3"><a class="font-semibold text-blue-800 hover:underline" href="{{ route('admin.transactions.show', $transaction) }}">{{ $transaction->transaction_code }}</a></td>
                            <td class="px-5 py-3">
                                @php($badge = ['import' => 'bg-emerald-100 text-emerald-800', 'export' => 'bg-blue-100 text-blue-800', 'adjustment' => 'bg-amber-100 text-amber-800'][$transaction->type])
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $badge }}">{{ ['import' => 'Nhập kho', 'export' => 'Xuất kho', 'adjustment' => 'Kiểm kê'][$transaction->type] }}</span>
                            </td>
                            <td class="px-5 py-3 text-slate-600">{{ $transaction->transaction_date->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-3 text-slate-600">{{ $transaction->project_or_supplier_name }}</td>
                            <td class="px-5 py-3 text-slate-600">{{ $transaction->user?->fullname ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center text-slate-500">Chưa có phiếu giao dịch.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
