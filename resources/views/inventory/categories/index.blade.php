@extends('layouts.admin')

@section('title', 'Danh mục vật tư')

@section('content')
    <div class="mb-6">
        <p class="text-sm font-semibold text-blue-800">DỮ LIỆU NỀN</p>
        <h1 class="mt-1 text-2xl font-bold text-slate-950">Danh mục vật tư</h1>
    </div>
    <form method="POST" action="{{ route('admin.categories.store') }}" class="mb-6 grid gap-3 rounded-xl border border-slate-200 bg-white p-5 shadow-sm md:grid-cols-[1fr_2fr_auto]">
        @csrf
        <input name="name" required maxlength="150" placeholder="Tên danh mục" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <input name="description" maxlength="1000" placeholder="Mô tả" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <button class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Thêm danh mục</button>
    </form>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500"><tr><th class="px-5 py-3">Tên danh mục</th><th class="px-5 py-3">Mô tả</th><th class="px-5 py-3">Số mã vật tư</th><th class="px-5 py-3 text-right">Thao tác</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $category)
                        <tr>
                            <td colspan="3" class="p-0">
                                <form id="category-{{ $category->id }}" method="POST" action="{{ route('admin.categories.update', $category) }}" class="grid items-center gap-3 p-3 md:grid-cols-[1fr_2fr_auto]">
                                    @csrf @method('PUT')
                                    <input name="name" value="{{ $category->name }}" required maxlength="150" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
                                    <input name="description" value="{{ $category->description }}" maxlength="1000" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
                                    <span class="text-sm text-slate-600 md:text-right">{{ $category->products_count }} mã vật tư</span>
                                </form>
                            </td>
                            <td class="whitespace-nowrap px-5 py-3 text-right">
                                <button form="category-{{ $category->id }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">Lưu</button>
                                @if ($category->products_count === 0)
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="ml-1 inline" onsubmit="return confirm('Xóa danh mục này?')">
                                        @csrf @method('DELETE')
                                        <button class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">Xóa</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-10 text-center text-slate-500">Chưa có danh mục.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($categories->hasPages())<div class="border-t border-slate-200 px-5 py-4">{{ $categories->links() }}</div>@endif
    </div>
@endsection
