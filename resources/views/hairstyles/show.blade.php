@extends('layouts.app')

@section('title', $hairstyle->name . ' - Tâm Barbershop')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-10">

    <!-- BACK BUTTON -->
    <div>
        <a href="{{ route('hairstyles.index') }}" 
           class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#8a641d] hover:text-[#f2d788] transition-colors">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            <span>Quay lại danh sách kiểu tóc</span>
        </a>
    </div>

    <!-- MAIN CONTENT CARD -->
    <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-6 sm:p-8 shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 items-start"
         style="box-shadow: 0 0 0 1px rgba(138,100,29,.25), 0 20px 40px -20px rgba(0,0,0,.9);">
        
        <!-- HAIRSTYLE IMAGE -->
        <div class="relative overflow-hidden rounded-[2px] border border-[#3c2c15] bg-[#0b0805] aspect-[4/5] group">
            <img src="{{ $hairstyle->image ?? '/images/fade-cut-closeup.jpg' }}" alt="{{ $hairstyle->name }}"
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0b0805]/80 via-transparent to-transparent"></div>
        </div>

        <!-- HAIRSTYLE INFO -->
        <div class="space-y-6">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Chi tiết kiểu tóc</span>
                <h1 class="font-['Bebas_Neue'] text-4xl sm:text-5xl tracking-wider text-[#f2d788] uppercase mt-1 leading-none">
                    {{ $hairstyle->name }}
                </h1>
            </div>

            <!-- Description -->
            <p class="text-xs sm:text-sm text-[#f4ecd8]/80 leading-relaxed">
                {{ $hairstyle->description }}
            </p>

            <!-- Metadata List -->
            <div class="space-y-3 border-y border-[#3c2c15] py-4 text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-[#6f6248] uppercase tracking-wider font-semibold flex items-center gap-1.5">
                        <i class="fa-solid fa-user-gear text-[11px] text-[#8a641d]"></i>
                        Phù hợp khuôn mặt
                    </span>
                    <span class="font-bold text-[#f4ecd8]">
                        {{ $hairstyle->suitable_face_shapes ?? 'Đang cập nhật' }}
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-[#6f6248] uppercase tracking-wider font-semibold flex items-center gap-1.5">
                        <i class="fa-solid fa-layer-group text-[11px] text-[#8a641d]"></i>
                        Độ khó tạo kiểu
                    </span>
                    <span class="font-bold text-[#f2d788] capitalize">
                        @switch($hairstyle->difficulty)
                            @case('easy') Dễ @break
                            @case('medium') Trung bình @break
                            @case('hard') Khó @break
                            @default {{ $hairstyle->difficulty }}
                        @endswitch
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-[#6f6248] uppercase tracking-wider font-semibold flex items-center gap-1.5">
                        <i class="fa-solid fa-tag text-[11px] text-[#8a641d]"></i>
                        Giá tham khảo
                    </span>
                    <span class="font-['Bebas_Neue'] text-xl tracking-wider text-[#f2d788]">
                        {{ $hairstyle->reference_price ? number_format((float) $hairstyle->reference_price, 0, ',', '.') . 'đ' : 'Liên hệ' }}
                    </span>
                </div>
            </div>

            <!-- Booking Action Button -->
            <div>
                <a href="{{ route('booking.create', ['hairstyle_id' => $hairstyle->id]) }}" 
                   class="inline-flex w-full items-center justify-center gap-2 rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] py-3 px-6 text-xs font-bold uppercase tracking-wider text-[#0b0805] shadow-lg transition-all hover:brightness-110 active:scale-[0.99]">
                    <i class="fa-solid fa-scissors"></i>
                    <span>Đặt lịch với kiểu tóc này</span>
                </a>
            </div>
        </div>
    </div>

    <!-- BARBER POLE LINE -->
    <div class="h-[2px] w-full bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>

    <!-- RELATED HAIRSTYLES SECTION -->
    <section class="space-y-6">
        <div class="border-b border-[#3c2c15] pb-3">
            <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Gợi ý cho bạn</span>
            <h2 class="font-['Bebas_Neue'] text-3xl tracking-wide text-[#f2d788] uppercase">
                Kiểu Tóc Liên Quan
            </h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach ($related as $item)
                <div class="group rounded-[2px] border border-[#3c2c15] bg-[#171008] p-3 transition-all hover:border-[#8a641d]">
                    <a href="{{ route('hairstyles.show', $item->slug) }}" class="block">
                        <div class="overflow-hidden rounded-[2px] mb-2.5 h-36 bg-[#0b0805] relative">
                            <img src="{{ $item->image ?? '/images/fade-cut-closeup.jpg' }}" alt="{{ $item->name }}"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>
                        <div class="font-semibold text-xs text-[#f4ecd8] group-hover:text-[#f2d788] transition-colors truncate text-center">
                            {{ $item->name }}
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

</div>
@endsection