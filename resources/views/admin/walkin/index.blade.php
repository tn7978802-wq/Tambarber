@extends('layouts.admin')

@section('title', 'quản lý - Tâm Barbershop Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4">

    <!-- HEADER SECTION -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
         style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex items-center gap-3 mb-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                <i class="fa-solid fa-scissors text-xs"></i>
            </span>
            <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase">
                Quản lý lượt khách Walk-in
            </h1>
        </div>
        <p class="text-xs text-[#f4ecd8]/70 pl-11">
            Ghi nhận lượt khách đến trực tiếp cửa hàng và quản lý tiền thu chi từ các dịch vụ.
        </p>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- NOTIFICATION ALERT -->
    @if (session('success'))
        <div class="rounded-[4px] border border-emerald-500/40 bg-emerald-950/40 px-4 py-3 text-xs font-semibold text-emerald-400 flex items-center gap-2 shadow-lg">
            <i class="fa-solid fa-circle-check text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- FORM BẮT ĐẦU PHIÊN MỚI CARD -->
        <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl relative overflow-hidden space-y-5 transition-all duration-300 hover:border-[#a8342f]/50">
            <div class="flex items-center gap-2 border-b border-[#3c2c15] pb-3">
                <i class="fa-solid fa-user-plus text-[#a8342f] text-sm"></i>
                <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">
                    Bắt Đầu Phiên Làm Việc Mới
                </h2>
            </div>

            <form method="POST" action="{{ route('admin.walkin.store') }}" class="space-y-4">
                @csrf

                <!-- Select Barber -->
                <div class="space-y-1.5">
                    <label for="barber_id" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Chọn Barber <span class="text-[#a8342f]">*</span>
                    </label>
                    <select id="barber_id" name="barber_id" required
                            class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                        <option value="">-- Chọn thợ cắt tóc --</option>
                        @foreach ($barbers ?? [] as $barber)
                            <option value="{{ $barber->id }}">{{ $barber->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Services (Multiple Checkboxes) -->
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Dịch vụ <span class="text-[#6f6248] font-normal">(Có thể chọn nhiều)</span>
                    </label>
                    <div class="space-y-2 max-h-56 overflow-y-auto rounded-[2px] border border-[#3c2c15] bg-[#070503] p-3 divide-y divide-[#3c2c15]/50">
                        @forelse ($services ?? [] as $service)
                            <label class="flex items-center justify-between gap-3 text-xs text-[#f4ecd8] pt-2 first:pt-0 cursor-pointer hover:text-[#f2d788] transition-colors">
                                <span class="flex items-center gap-2.5">
                                    <input type="checkbox" name="service_ids[]" value="{{ $service->id }}"
                                           class="h-4 w-4 rounded-[2px] border-[#3c2c15] bg-[#110d07] text-[#a8342f] focus:ring-0 focus:ring-offset-0 accent-[#a8342f]">
                                    <span class="font-semibold">{{ $service->name }}</span>
                                </span>
                                <span class="font-mono text-[11px] text-[#f2d788] font-bold">{{ number_format($service->price) }}đ</span>
                            </label>
                        @empty
                            <p class="text-xs text-[#6f6248] italic text-center py-2">Chưa có dịch vụ nào.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Customer Name -->
                <div class="space-y-1.5">
                    <label for="customer_name" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Tên khách hàng <span class="text-[#6f6248] font-normal">(Không bắt buộc)</span>
                    </label>
                    <input type="text" id="customer_name" name="customer_name"
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all"
                           placeholder="Ví dụ: Anh Bình, Chú Cường...">
                </div>

                <!-- Note -->
                <p class="text-[11px] text-[#6f6248] italic leading-relaxed pt-1">
                    <i class="fa-solid fa-clock-rotate-left mr-1 text-[#a8342f]"></i>
                    Giờ và ngày bắt đầu sẽ được hệ thống tự động ghi nhận theo thời gian thực của máy chủ ngay khi bấm nút bên dưới.
                </p>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center gap-2 rounded-[2px] border border-[#f2d788]/60 bg-gradient-to-r from-[#7c1f22] via-[#cf9f3f] to-[#8a641d] px-6 py-2.5 text-xs font-bold uppercase tracking-[0.15em] text-[#f4ecd8] shadow-[0_0_15px_rgba(124,31,34,0.4)] transition-all hover:brightness-125 hover:shadow-[0_0_25px_rgba(168,52,47,0.6)] active:scale-[0.98]">
                        <i class="fa-solid fa-play text-[10px]"></i>
                        <span>Bắt Đầu Làm</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- DANH SÁCH ĐANG THỰC HIỆN CARD -->
        <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl relative overflow-hidden space-y-5">
            <div class="flex items-center justify-between border-b border-[#3c2c15] pb-3">
                <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase flex items-center gap-2">
                    <i class="fa-solid fa-spinner text-xs text-[#a8342f] animate-spin"></i>
                    Đang Thực Hiện
                </h2>
                <span class="rounded-[2px] border border-[#8a641d]/40 bg-[#070503] px-2.5 py-0.5 text-[11px] font-bold text-[#f2d788]">
                    {{ count($activeSessions ?? []) }} phiên
                </span>
            </div>

            @if (($activeSessions ?? collect())->isEmpty())
                <div class="py-12 text-center text-[#6f6248] italic space-y-2">
                    <i class="fa-regular fa-clock text-3xl block text-[#3c2c15]"></i>
                    <p class="text-xs">Hiện chưa có khách nào đang được phục vụ.</p>
                </div>
            @else
                <div class="space-y-4 max-h-[500px] overflow-y-auto pr-1">
                    @foreach ($activeSessions as $session)
                        <div class="rounded-[2px] border border-[#3c2c15] bg-[#070503] p-4 flex flex-col gap-3.5 hover:border-[#8a641d] transition-all">
                            <!-- Header Info -->
                            <div class="flex items-start justify-between gap-3">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-user-tie text-xs text-[#a8342f]"></i>
                                        <p class="font-bold text-[#f2d788] text-sm">{{ optional($session->barber)->name ?? 'N/A' }}</p>
                                    </div>
                                    <p class="text-xs text-[#f4ecd8]/80 font-medium pl-4">
                                        {{ $session->services_label ?: 'Chưa ghi nhận dịch vụ' }}
                                    </p>
                                    @if ($session->customer_name)
                                        <p class="text-[11px] text-[#6f6248] pl-4 flex items-center gap-1">
                                            <i class="fa-regular fa-user text-[10px]"></i>
                                            Khách: <span class="text-[#f4ecd8]/90 font-semibold">{{ $session->customer_name }}</span>
                                        </p>
                                    @endif
                                </div>

                                <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-amber-500/40 bg-amber-950/40 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-300 whitespace-nowrap">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                    Đang làm
                                </span>
                            </div>

                            <!-- Time & Price -->
                            <div class="flex items-center justify-between text-xs pt-2 border-t border-[#3c2c15]/60 text-[#f4ecd8]/80">
                                <span class="font-mono text-[11px] text-[#6f6248]">
                                    <i class="fa-regular fa-clock mr-1"></i>
                                    {{ optional($session->started_at)->format('H:i - d/m/Y') ?? '—' }}
                                </span>
                                <span class="font-mono font-bold text-sm text-[#f2d788]">
                                    {{ number_format($session->total_price ?? 0) }}đ
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-3 pt-1">
                                <form method="POST" action="{{ route('admin.walkin.complete', $session) }}" class="flex-1">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center gap-1.5 rounded-[2px] border border-emerald-500/40 bg-emerald-950/60 hover:bg-emerald-800 text-emerald-300 text-[11px] font-bold uppercase tracking-wider py-1.5 transition-colors">
                                        <i class="fa-solid fa-check text-[10px]"></i>
                                        <span>Hoàn thành</span>
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.walkin.cancel', $session) }}" class="flex-1"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn hủy phiên làm việc này?');">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center gap-1.5 rounded-[2px] border border-red-500/40 bg-red-950/60 hover:bg-red-800 text-red-300 text-[11px] font-bold uppercase tracking-wider py-1.5 transition-colors">
                                        <i class="fa-solid fa-xmark text-[10px]"></i>
                                        <span>Hủy</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>
@endsection