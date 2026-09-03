@extends('layouts.app')

@section('title', 'Portfolio - Tâm Barbershop')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    <!-- HERO HEADER -->
    <div class="mb-10 text-center">
        <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Bộ sưu tập thực tế</span>
        <h1 class="font-['Bebas_Neue'] text-4xl sm:text-5xl tracking-wider text-[#f2d788] uppercase mb-2">
            Thư Viện Tác Phẩm
        </h1>
        <p class="text-xs sm:text-sm text-[#f4ecd8]/70 max-w-lg mx-auto">
            Tổng hợp các kiểu tóc &amp; tác phẩm ấn tượng được thực hiện trực tiếp bởi đội ngũ Barber chuyên nghiệp.
        </p>
        
        <!-- Barber Pole Stripe Divider -->
        <div class="my-5 h-[2px] w-32 mx-auto bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>
    </div>

    <!-- CATEGORY FILTER NAV -->
    <div class="mb-8 flex items-center justify-center flex-wrap gap-2">
        <a href="{{ route('portfolio.index') }}" 
           class="rounded-[2px] border px-4 py-2 text-xs font-bold uppercase tracking-wider transition-all {{ !$selectedCategory ? 'border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] text-[#0b0805] shadow-md' : 'border-[#3c2c15] bg-[#171008] text-[#f4ecd8] hover:border-[#8a641d] hover:text-[#f2d788]' }}">
            Tất cả
        </a>

        @foreach ($categories as $category)
            <a href="{{ route('portfolio.index', ['category' => $category]) }}"
               class="rounded-[2px] border px-4 py-2 text-xs font-bold uppercase tracking-wider transition-all {{ $selectedCategory === $category ? 'border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] text-[#0b0805] shadow-md' : 'border-[#3c2c15] bg-[#171008] text-[#f4ecd8] hover:border-[#8a641d] hover:text-[#f2d788]' }}">
                {{ $category }}
            </a>
        @endforeach
    </div>

    <!-- PORTFOLIO GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($portfolios as $item)
            <div class="group rounded-[2px] border border-[#3c2c15] bg-[#171008] overflow-hidden shadow-xl transition-all duration-300 hover:border-[#8a641d] flex flex-col justify-between"
                 style="box-shadow: 0 0 0 1px rgba(138,100,29,.15), 0 10px 25px -10px rgba(0,0,0,.8);">
                
                <div>
                    <!-- Image Card -->
                    <div class="relative overflow-hidden aspect-square bg-[#0b0805]">
                        <img src="{{ $item->image }}" alt="{{ $item->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#171008] via-transparent to-transparent opacity-80"></div>
                    </div>

                    <!-- Content Details -->
                    <div class="p-4 space-y-2">
                        <h3 class="font-['Bebas_Neue'] text-xl tracking-wide text-[#f2d788] leading-tight group-hover:text-[#f4ecd8] transition-colors">
                            {{ $item->title }}
                        </h3>

                        <div class="space-y-1 text-xs text-[#6f6248]">
                            @if ($item->hairstyle)
                                <p class="flex items-center gap-1.5 text-[#f4ecd8]/80">
                                    <i class="fa-solid fa-scissors text-[10px] text-[#8a641d]"></i>
                                    <span>Kiểu tóc: <strong class="text-[#f4ecd8]">{{ $item->hairstyle->name }}</strong></span>
                                </p>
                            @endif

                            @if ($item->barber)
                                <p class="flex items-center gap-1.5 text-[#f4ecd8]/80">
                                    <i class="fa-solid fa-user-check text-[10px] text-[#8a641d]"></i>
                                    <span>Thực hiện bởi: <strong class="text-[#f2d788]">{{ $item->barber->name }}</strong></span>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card Footer Decor -->
                <div class="px-4 pb-3">
                    <div class="h-[1px] w-full bg-[#3c2c15]"></div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-[#6f6248] rounded-[2px] border border-[#3c2c15] bg-[#171008]">
                <i class="fa-regular fa-images text-4xl mb-3 block text-[#3c2c15]"></i>
                <p class="text-xs">Chưa có hình ảnh nào trong danh mục này.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection