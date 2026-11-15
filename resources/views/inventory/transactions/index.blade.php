@extends('layouts.admin')

@section('title', 'Lịch sử giao dịch')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-blue-800">NHẬP · XUẤT · KIỂM KÊ</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-950">Lịch sử giao dịch</h1>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.exports.transactions', request()->only('type')) }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Xuất CSV</a>
            <a href="{{ route('admin.transactions.create', 'import') }}" class="rounded-lg bg-blue-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">＋ Tạo phiếu</a>
        </div>
    </div>

    <form method="GET" class="mb-5 grid gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:grid-cols-[1fr_180px_160px_160px_auto]">
        <input name="q" value="{{ request('q') }}" placeholder="Mã phiếu hoặc công trình..." class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <select name="type" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
            <option value="">Tất cả loại phiếu</option>
            @foreach (['import' => 'Nhập kho', 'export' => 'Xuất kho', 'adjustment' => 'Kiểm kê'] as $value => $label)
                <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <input type="date" name="from" value="{{ request('from') }}" aria-label="Từ ngày" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <input type="date" name="to" value="{{ request('to') }}" aria-label="Đến ngày" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <button class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Lọc</button>
    </form>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500"><tr><th class="px-5 py-3">Mã phiếu</th><th class="px-5 py-3">Loại phiếu</th><th class="px-5 py-3">Ngày giao dịch</th><th class="px-5 py-3">Dự án / Nhà cung cấp</th><th class="px-5 py-3">Người thực hiện</th><th class="px-5 py-3">Trạng thái</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4"><a href="{{ route('admin.transactions.show', $transaction) }}" class="font-mono text-xs font-semibold text-blue-800 hover:underline">{{ $transaction->transaction_code }}</a></td>
                            <td class="px-5 py-4">
                                @php($badge = ['import' => 'bg-emerald-100 text-emerald-800', 'export' => 'bg-blue-100 text-blue-800', 'adjustment' => 'bg-amber-100 text-amber-800'][$transaction->type])
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $badge }}">{{ ['import' => 'Nhập kho', 'export' => 'Xuất kho', 'adjustment' => 'Kiểm kê'][$transaction->type] }}</span>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $transaction->transaction_date->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-4 text-slate-700">{{ $transaction->project_or_supplier_name }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $transaction->user?->fullname ?? '—' }}</td>
                            <td class="px-5 py-4"><span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800">{{ $transaction->status === 'completed' ? 'Hoàn tất' : $transaction->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-slate-500">Không có phiếu giao dịch phù hợp.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($transactions->hasPages())<div class="border-t border-slate-200 px-5 py-4">{{ $transactions->links() }}</div>@endif
    </div>
@endsection
