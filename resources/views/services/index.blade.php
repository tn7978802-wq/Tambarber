@extends('layouts.app')

@section('title', 'Dịch vụ - Tâm Barbershop')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

    <!-- HERO HEADER -->
    <div class="mb-10 text-center">
        <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Bảng giá niêm yết</span>
        <h1 class="font-['Bebas_Neue'] text-4xl sm:text-5xl tracking-wider text-[#f2d788] uppercase mb-2">
            Dịch Vụ &amp; Bảng Giá
        </h1>
        <p class="text-xs sm:text-sm text-[#f4ecd8]/70 max-w-lg mx-auto">
            Trải nghiệm dịch vụ chăm sóc tóc và râu chuyên nghiệp với tay nghề cao cùng không gian thư giãn đẳng cấp.
        </p>
        
        <!-- Barber Pole Stripe Divider -->
        <div class="my-5 h-[2px] w-32 mx-auto bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>
    </div>

    <!-- SERVICES TABLE CONTAINER -->
    <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] shadow-2xl overflow-hidden"
         style="box-shadow: 0 0 0 1px rgba(138,100,29,.25), 0 18px 40px -20px rgba(0,0,0,.8);">
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#f4ecd8]">
                <!-- Table Header -->
                <thead class="border-b border-[#3c2c15] bg-[#251b0e] font-['Bebas_Neue'] text-sm sm:text-base tracking-wider text-[#f2d788] uppercase">
                    <tr>
                        <th class="px-5 py-4 min-w-[180px]">Dịch vụ</th>
                        <th class="px-5 py-4 min-w-[250px]">Mô tả</th>
                        <th class="px-5 py-4 text-center min-w-[110px]">Thời gian</th>
                        <th class="px-5 py-4 text-right min-w-[130px]">Giá dịch vụ</th>
                        <th class="px-5 py-4 text-center min-w-[120px]">Thao tác</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-[#3c2c15]">
                    @forelse ($services as $service)
                        <tr class="transition-colors hover:bg-[#251b0e]/70 group">
                            <!-- Service Name -->
                            <td class="px-5 py-4 font-bold text-[#f4ecd8] group-hover:text-[#f2d788] transition-colors">
                                <div class="flex items-center gap-2.5">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-[2px] border border-[#8a641d]/50 bg-[#0b0805] text-[#8a641d] group-hover:border-[#f2d788] group-hover:text-[#f2d788] transition-all">
                                        <i class="fa-solid fa-scissors text-xs"></i>
                                    </div>
                                    <span class="text-sm font-semibold tracking-wide">{{ $service->name }}</span>
                                </div>
                            </td>

                            <!-- Description -->
                            <td class="px-5 py-4 text-[#f4ecd8]/70 text-xs leading-relaxed">
                                {{ $service->description ?? 'Đang cập nhật mô tả dịch vụ...' }}
                            </td>

                            <!-- Duration -->
                            <td class="px-5 py-4 text-center text-[#6f6248] font-medium whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 bg-[#0b0805] px-2.5 py-1 rounded-[2px] border border-[#3c2c15]">
                                    <i class="fa-regular fa-clock text-[#8a641d]"></i>
                                    <span>{{ $service->duration_minutes }} phút</span>
                                </span>
                            </td>

                            <!-- Price -->
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <span class="font-['Bebas_Neue'] text-xl tracking-wider text-[#f2d788]">
                                    {{ number_format((float) $service->price, 0, ',', '.') }}đ
                                </span>
                            </td>

                            <!-- Booking CTA Button -->
                            <td class="px-5 py-4 text-center whitespace-nowrap">
                                <a href="{{ route('booking.create', ['service_id' => $service->id]) }}" 
                                   class="inline-flex items-center justify-center gap-1.5 rounded-[2px] border border-[#8a641d] bg-[#0b0805] px-3.5 py-1.5 text-[11px] font-bold uppercase tracking-wider text-[#f2d788] transition-all hover:bg-gradient-to-b hover:from-[#f2d788] hover:via-[#cf9f3f] hover:to-[#8a641d] hover:text-[#0b0805] hover:border-transparent active:scale-[0.98]">
                                    <span>Đặt lịch</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-[#6f6248]">
                                <i class="fa-solid fa-scissors text-3xl mb-2 block text-[#3c2c15]"></i>
                                <p class="text-xs">Danh sách dịch vụ đang được cập nhật.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- FOOTER NOTE -->
    <div class="mt-8 text-center text-xs text-[#6f6248]">
        <p class="flex items-center justify-center gap-2">
            <i class="fa-solid fa-circle-info text-[#8a641d]"></i>
            Giá trên đã bao gồm tư vấn kiểu tóc phù hợp và sấy tạo kiểu hoàn thiện.
        </p>
    </div>

</div>
@endsection