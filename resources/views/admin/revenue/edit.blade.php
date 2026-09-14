@extends('layouts.admin')

@section('title', 'Sửa doanh thu - Tâm Barbershop Admin')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl">
        <div class="flex items-center justify-between gap-4 border-b border-[#3c2c15] pb-4 mb-6">
            <div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-[#a8342f] text-sm"></i>
                    <h1 class="font-['Bebas_Neue'] text-3xl tracking-widest text-[#f2d788] uppercase">Sửa doanh thu</h1>
                </div>
                <p class="mt-2 text-xs text-[#f4ecd8]/70">Chỉnh sửa thông tin và tổng doanh thu của bản ghi đã hoàn thành.</p>
            </div>
            <a href="{{ route('admin.revenue.index') }}" class="inline-flex items-center gap-2 rounded-[2px] border border-[#3c2c15] bg-[#070503] px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-[#f4ecd8] hover:border-[#a8342f] hover:text-[#f2d788]">
                <i class="fa-solid fa-arrow-left text-[9px]"></i>
                Quay lại
            </a>
        </div>

        <form action="{{ route('admin.revenue.update', $walkin) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label for="customer_name" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">Khách hàng</label>
                    <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $walkin->customer_name) }}" class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none">
                </div>

                <div class="space-y-1.5">
                    <label for="barber_id" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">Barber</label>
                    <select id="barber_id" name="barber_id" class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none">
                        @foreach ($barbers as $barber)
                            <option value="{{ $barber->id }}" @selected(old('barber_id', $walkin->barber_id) == $barber->id)>
                                {{ $barber->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label for="started_at" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">Thời gian bắt đầu</label>
                    <input type="datetime-local" id="started_at" name="started_at" value="{{ old('started_at', optional($walkin->started_at)->format('Y-m-d\TH:i')) }}" class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none">
                </div>

                <div class="space-y-1.5">
                    <label for="total_price" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">Tổng doanh thu (VND)</label>
                    <input type="number" id="total_price" name="total_price" min="0" step="1000" value="{{ old('total_price', (float) ($walkin->total_price ?? 0)) }}" class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">Dịch vụ</label>
                <div class="rounded-[2px] border border-[#3c2c15] bg-[#070503] p-3 text-xs text-[#f4ecd8]/80">
                    @forelse ($walkin->services as $service)
                        <div class="flex items-center justify-between gap-3 py-1.5 border-b border-[#3c2c15] last:border-0">
                            <span>{{ $service->name }}</span>
                            <span class="font-mono text-[#f2d788]">{{ number_format((float) ($service->pivot->price ?? 0)) }}đ</span>
                        </div>
                    @empty
                        <div class="text-[#6f6248] italic">Không có dịch vụ nào được ghi nhận cho bản ghi này.</div>
                    @endforelse
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-[#3c2c15]">
                <a href="{{ route('admin.revenue.index') }}" class="inline-flex items-center gap-2 rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2 text-[10px] font-bold uppercase tracking-wider text-[#f4ecd8] hover:border-[#a8342f] hover:text-[#f2d788]">
                    <i class="fa-solid fa-xmark text-[9px]"></i>
                    Huỷ
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-[2px] border border-[#f2d788]/60 bg-gradient-to-r from-[#7c1f22] via-[#cf9f3f] to-[#8a641d] px-5 py-2.5 text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8] shadow-[0_0_15px_rgba(124,31,34,0.4)] hover:brightness-125">
                    <i class="fa-solid fa-floppy-disk text-[9px]"></i>
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
