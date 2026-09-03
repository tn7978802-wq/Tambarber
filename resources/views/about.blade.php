@extends('layouts.app')

@section('title', 'Giới thiệu - Tâm Barbershop')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-12">

    <!-- HERO HEADER -->
    <div class="text-center max-w-2xl mx-auto">
        <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Câu chuyện của chúng tôi</span>
        <h1 class="font-['Bebas_Neue'] text-4xl sm:text-5xl tracking-wider text-[#f2d788] uppercase mb-2">
            Giới Thiệu Về Nghề Barber
        </h1>
        <p class="text-xs sm:text-sm text-[#f4ecd8]/70">
            Nơi tôn vinh nghệ thuật cắt tóc truyền thống kết hợp cùng phong cách hiện đại và sự tận tâm trong từng đường kéo.
        </p>
        
        <!-- Barber Pole Stripe Divider -->
        <div class="my-5 h-[2px] w-32 mx-auto bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>
    </div>

    <!-- NGHỀ BARBER LA GI? -->
    <section class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-6 sm:p-8 shadow-2xl relative overflow-hidden"
             style="box-shadow: 0 0 0 1px rgba(138,100,29,.25), 0 18px 40px -20px rgba(0,0,0,.8);">
        <div class="flex items-center gap-3 mb-3">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-[2px] border border-[#8a641d] bg-[#0b0805] text-[#f2d788]">
                <i class="fa-solid fa-scissors text-sm"></i>
            </div>
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">Nghề Barber là gì?</h2>
        </div>
        <p class="text-xs sm:text-sm text-[#f4ecd8]/90 leading-relaxed pl-11">
            Barber là người thợ chuyên cắt tóc, tạo kiểu và cạo râu cho nam giới, kết hợp giữa kỹ thuật cắt gọt chính xác và gu thẩm mỹ sắc bén để mang lại diện mạo chỉn chu, tự tin nhất cho từng khách hàng.
        </p>
    </section>

    <!-- GRID 2 CỘT: CÔNG VIỆC & KỸ NĂNG -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- CÔNG VIỆC HẰNG NGÀY -->
        <section class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-6 shadow-xl flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-4 border-b border-[#3c2c15] pb-3">
                    <i class="fa-solid fa-briefcase text-[#8a641d] text-lg"></i>
                    <h2 class="font-['Bebas_Neue'] text-xl tracking-wide text-[#f2d788] uppercase">
                        Công việc hằng ngày
                    </h2>
                </div>
                <ul class="space-y-3 text-xs text-[#f4ecd8]/80">
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-check text-[10px] text-[#8a641d] mt-0.5"></i>
                        <span>Tư vấn kiểu tóc phù hợp với khuôn mặt và phong cách riêng của khách hàng.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-check text-[10px] text-[#8a641d] mt-0.5"></i>
                        <span>Thực hiện cắt tóc, tạo kiểu, cạo râu và gội đầu massage thư giãn.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-check text-[10px] text-[#8a641d] mt-0.5"></i>
                        <span>Vệ sinh, khử trùng và bảo quản dụng cụ hành nghề chuyên nghiệp.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-check text-[10px] text-[#8a641d] mt-0.5"></i>
                        <span>Liên tục cập nhật các xu hướng tóc nam mới nhất trên thế giới.</span>
                    </li>
                </ul>
            </div>
        </section>

        <!-- KỸ NĂNG CẦN CÓ -->
        <section class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-6 shadow-xl flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-4 border-b border-[#3c2c15] pb-3">
                    <i class="fa-solid fa-award text-[#8a641d] text-lg"></i>
                    <h2 class="font-['Bebas_Neue'] text-xl tracking-wide text-[#f2d788] uppercase">
                        Kỹ năng cần có
                    </h2>
                </div>
                <ul class="space-y-3 text-xs text-[#f4ecd8]/80">
                    @foreach ($skills as $skill)
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-star text-[10px] text-[#f2d788] mt-0.5"></i>
                            <span>{{ $skill }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </div>

    <!-- BARBER POLE LINE -->
    <div class="h-[2px] w-full bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>

    <!-- LỘ TRÌNH THẮNG TIẾN -->
    <section class="space-y-6">
        <div class="border-b border-[#3c2c15] pb-3 text-center sm:text-left">
            <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Hành trình làm nghề</span>
            <h2 class="font-['Bebas_Neue'] text-3xl tracking-wide text-[#f2d788] uppercase">
                Lộ Trình Từng Bước Trở Thành Barber Chuyên Nghiệp
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($careerPath as $i => $stage)
                <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-5 shadow-lg flex items-start gap-4 transition-all hover:border-[#8a641d]">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[2px] border border-[#8a641d] bg-[#0b0805] font-['Bebas_Neue'] text-xl font-bold text-[#f2d788]">
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <div class="space-y-1">
                        <h3 class="font-bold text-sm text-[#f2d788] uppercase tracking-wide">
                            {{ $stage['step'] }}
                        </h3>
                        <p class="text-xs text-[#f4ecd8]/70 leading-relaxed">
                            {{ $stage['description'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- BARBER POLE LINE -->
    <div class="h-[2px] w-full bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>

    <!-- ĐỘI NGŨ BARBER -->
    <section class="space-y-6">
        <div class="border-b border-[#3c2c15] pb-3 text-center sm:text-left">
            <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Tay nghề xuất sắc</span>
            <h2 class="font-['Bebas_Neue'] text-3xl tracking-wide text-[#f2d788] uppercase">
                Đội Ngũ Barber Của Chúng Tôi
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($barbers as $barber)
                <div class="group rounded-[2px] border border-[#3c2c15] bg-[#171008] overflow-hidden shadow-xl transition-all duration-300 hover:border-[#8a641d] flex flex-col">
                    <!-- Barber Avatar -->
                    <div class="relative overflow-hidden h-64 bg-[#0b0805]">
                        <img src="{{ $barber->avatar ?? '/images/shop-working.jpg' }}" alt="{{ $barber->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#171008] via-transparent to-transparent opacity-90"></div>
                    </div>

                    <!-- Barber Details -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-3 -mt-6 relative z-10">
                        <div>
                            <h3 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] leading-tight">
                                {{ $barber->name }}
                            </h3>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6f6248] mt-0.5">
                                {{ $barber->title }} &middot; <span class="text-[#f4ecd8]">{{ $barber->years_experience }} năm kinh nghiệm</span>
                            </p>
                            <p class="text-xs text-[#f4ecd8]/70 mt-3 leading-relaxed line-clamp-3">
                                {{ $barber->bio }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-[#3c2c15]">
                            <a href="{{ route('booking.create', ['barber_id' => $barber->id]) }}" 
                               class="inline-flex w-full items-center justify-center gap-1.5 rounded-[2px] border border-[#8a641d] bg-[#0b0805] py-2 text-xs font-bold uppercase tracking-wider text-[#f2d788] transition-all hover:bg-gradient-to-b hover:from-[#f2d788] hover:via-[#cf9f3f] hover:to-[#8a641d] hover:text-[#0b0805] hover:border-transparent">
                                <span>Đặt lịch với {{ $barber->name }}</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-[#6f6248] rounded-[2px] border border-[#3c2c15] bg-[#171008]">
                    <i class="fa-solid fa-user-scissors text-3xl mb-2 block text-[#3c2c15]"></i>
                    <p class="text-xs">Thông tin đội ngũ đang được cập nhật.</p>
                </div>
            @endforelse
        </div>
    </section>

</div>
@endsection