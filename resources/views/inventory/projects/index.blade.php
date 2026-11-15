@extends('layouts.admin')

@section('title', 'Dự án và chi nhánh')

@section('content')
    <div class="mb-6">
        <p class="text-sm font-semibold text-blue-800">ĐIỂM SỬ DỤNG VẬT TƯ</p>
        <h1 class="mt-1 text-2xl font-bold text-slate-950">Dự án &amp; chi nhánh</h1>
    </div>
    <form method="POST" action="{{ route('admin.projects.store') }}" class="mb-6 grid gap-3 rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:grid-cols-2 lg:grid-cols-3">
        @csrf
        <input name="name" required placeholder="Tên dự án / chi nhánh *" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <input name="code" placeholder="Mã dự án" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <input name="location" placeholder="Địa điểm" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <input name="contact_person" placeholder="Người phụ trách" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <input name="phone" placeholder="Điện thoại" class="rounded-lg border-slate-300 text-sm focus:border-blue-700 focus:ring-blue-700">
        <button class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Thêm dự án</button>
    </form>

    <div class="space-y-4">
        @forelse ($projects as $project)
            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <form id="project-{{ $project->id }}" method="POST" action="{{ route('admin.projects.update', $project) }}" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @csrf @method('PUT')
                    <label class="text-xs font-medium text-slate-500">Tên<input name="name" value="{{ $project->name }}" required class="mt-1 block w-full rounded-lg border-slate-300 text-sm text-slate-900 focus:border-blue-700 focus:ring-blue-700"></label>
                    <label class="text-xs font-medium text-slate-500">Mã<input name="code" value="{{ $project->code }}" class="mt-1 block w-full rounded-lg border-slate-300 text-sm text-slate-900 focus:border-blue-700 focus:ring-blue-700"></label>
                    <label class="text-xs font-medium text-slate-500">Địa điểm<input name="location" value="{{ $project->location }}" class="mt-1 block w-full rounded-lg border-slate-300 text-sm text-slate-900 focus:border-blue-700 focus:ring-blue-700"></label>
                    <label class="text-xs font-medium text-slate-500">Người phụ trách<input name="contact_person" value="{{ $project->contact_person }}" class="mt-1 block w-full rounded-lg border-slate-300 text-sm text-slate-900 focus:border-blue-700 focus:ring-blue-700"></label>
                    <label class="text-xs font-medium text-slate-500">Điện thoại<input name="phone" value="{{ $project->phone }}" class="mt-1 block w-full rounded-lg border-slate-300 text-sm text-slate-900 focus:border-blue-700 focus:ring-blue-700"></label>
                    <label class="text-xs font-medium text-slate-500">Ghi chú<input name="notes" value="{{ $project->notes }}" class="mt-1 block w-full rounded-lg border-slate-300 text-sm text-slate-900 focus:border-blue-700 focus:ring-blue-700"></label>
                </form>
                <div class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-4">
                    <span class="text-xs text-slate-500">{{ $project->inventory_transactions_count }} phiếu xuất liên quan</span>
                    <div class="flex gap-2">
                        <button form="project-{{ $project->id }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lưu thay đổi</button>
                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Xóa dự án này?')">
                            @csrf @method('DELETE')
                            <button class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-50">Xóa</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <p class="rounded-xl border border-slate-200 bg-white p-8 text-center text-sm text-slate-500">Chưa có dự án hoặc chi nhánh.</p>
        @endforelse
    </div>
    @if ($projects->hasPages())<div class="mt-5">{{ $projects->links() }}</div>@endif
@endsection
