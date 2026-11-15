@extends('layouts.admin')

@section('title', 'Nhà cung cấp')

@section('content')
    <div class="mb-6">
        <p class="text-sm font-semibold text-blue-800">ĐỐI TÁC</p>
        <h1 class="mt-1 text-2xl font-bold text-slate-950">Nhà cung cấp</h1>
    </div>
    <form method="POST" action="{{ route('admin.suppliers.store') }}" class="mb-6 grid gap-3 rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:grid-cols-2 lg:grid-cols-3">
        @csrf
        <input name="name" required placeholder="Tên nhà cung cấp *" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <input name="contact_person" placeholder="Người liên hệ" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <input name="phone" placeholder="Số điện thoại" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <input name="email" type="email" placeholder="Email" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <input name="address" placeholder="Địa chỉ" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <button class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Thêm nhà cung cấp</button>
    </form>

    <div class="space-y-4">
        @forelse ($suppliers as $supplier)
            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <form id="supplier-{{ $supplier->id }}" method="POST" action="{{ route('admin.suppliers.update', $supplier) }}" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @csrf @method('PUT')
                    <label class="text-xs font-medium text-slate-500">Tên nhà cung cấp<input name="name" value="{{ $supplier->name }}" required class="mt-1 block w-full rounded-lg border-slate-300 text-sm text-slate-900 focus:border-blue-700 focus:ring-blue-700"></label>
                    <label class="text-xs font-medium text-slate-500">Người liên hệ<input name="contact_person" value="{{ $supplier->contact_person }}" class="mt-1 block w-full rounded-lg border-slate-300 text-sm text-slate-900 focus:border-blue-700 focus:ring-blue-700"></label>
                    <label class="text-xs font-medium text-slate-500">Điện thoại<input name="phone" value="{{ $supplier->phone }}" class="mt-1 block w-full rounded-lg border-slate-300 text-sm text-slate-900 focus:border-blue-700 focus:ring-blue-700"></label>
                    <label class="text-xs font-medium text-slate-500">Email<input name="email" type="email" value="{{ $supplier->email }}" class="mt-1 block w-full rounded-lg border-slate-300 text-sm text-slate-900 focus:border-blue-700 focus:ring-blue-700"></label>
                    <label class="text-xs font-medium text-slate-500">Địa chỉ<input name="address" value="{{ $supplier->address }}" class="mt-1 block w-full rounded-lg border-slate-300 text-sm text-slate-900 focus:border-blue-700 focus:ring-blue-700"></label>
                    <label class="text-xs font-medium text-slate-500">Ghi chú<input name="notes" value="{{ $supplier->notes }}" class="mt-1 block w-full rounded-lg border-slate-300 text-sm text-slate-900 focus:border-blue-700 focus:ring-blue-700"></label>
                </form>
                <div class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-4">
                    <span class="text-xs text-slate-500">{{ $supplier->inventory_transactions_count }} phiếu nhập liên quan</span>
                    <div class="flex gap-2">
                        <button form="supplier-{{ $supplier->id }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lưu thay đổi</button>
                        <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier) }}" onsubmit="return confirm('Xóa nhà cung cấp này?')">
                            @csrf @method('DELETE')
                            <button class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-50">Xóa</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <p class="rounded-xl border border-slate-200 bg-white p-8 text-center text-sm text-slate-500">Chưa có nhà cung cấp.</p>
        @endforelse
    </div>
    @if ($suppliers->hasPages())<div class="mt-5">{{ $suppliers->links() }}</div>@endif
@endsection
