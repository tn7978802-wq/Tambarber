@extends('layouts.app')

@section('title', 'Kiểu tóc - Tâm Barbershop')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">

    <!-- HERO HEADER -->
    <div class="text-center max-w-2xl mx-auto">
        <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Khám phá phong cách</span>
        <h1 class="font-['Bebas_Neue'] text-4xl sm:text-5xl tracking-wider text-[#f2d788] uppercase mb-2">
            Bộ Sưu Tập Kiểu Tóc
        </h1>
        <p class="text-xs sm:text-sm text-[#f4ecd8]/70">
            Lựa chọn kiểu tóc định hình phong cách cá nhân và tôn vinh diện mạo của bạn.
        </p>
        
        <!-- Barber Pole Stripe Divider -->
        <div class="my-5 h-[2px] w-32 mx-auto bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>
    </div>

    <!-- FILTER & SEARCH FORM -->
    <form action="{{ route('hairstyles.index') }}" method="GET" 
          class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-4 sm:p-6 shadow-xl flex flex-col sm:flex-row gap-4 items-end"
          style="box-shadow: 0 0 0 1px rgba(138,100,29,.2), 0 10px 25px -10px rgba(0,0,0,.8);">
        
        <!-- Search Input -->
        <div class="flex-1 w-full space-y-1.5">
            <label for="q" class="text-[11px] font-bold uppercase tracking-wider text-[#6f6248] block">
                Tìm kiếm
            </label>
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-xs text-[#6f6248]"></i>
                <input type="text" id="q" name="q" value="{{ $search }}" placeholder="Nhập tên kiểu tóc..."
                       class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] pl-9 pr-3 py-2.5 text-xs text-[#f4ecd8] placeholder-[#6f6248] focus:border-[#8a641d] focus:outline-none transition-colors">
            </div>
        </div>

        <!-- Difficulty Select -->
        <div class="w-full sm:w-48 space-y-1.5">
            <label for="difficulty" class="text-[11px] font-bold uppercase tracking-wider text-[#6f6248] block">
                Độ khó tạo kiểu
            </label>
            <select id="difficulty" name="difficulty" 
                    class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3 py-2.5 text-xs text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none transition-colors">
                <option value="">Tất cả độ khó</option>
                <option value="easy" @selected($difficulty === 'easy')>Dễ</option>
                <option value="medium" @selected($difficulty === 'medium')>Trung bình</option>
                <option value="hard" @selected($difficulty === 'hard')>Khó</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full sm:w-auto shrink-0 inline-flex items-center justify-center gap-2 rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-[#0b0805] shadow-lg transition-all hover:brightness-110 active:scale-[0.99]">
            <i class="fa-solid fa-filter text-[10px]"></i>
            <span>Lọc kết quả</span>
        </button>
    </form>

    <!-- HAIRSTYLES GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($hairstyles as $hairstyle)
            <div class="group rounded-[2px] border border-[#3c2c15] bg-[#171008] overflow-hidden shadow-xl transition-all duration-300 hover:border-[#8a641d] flex flex-col justify-between"
                 style="box-shadow: 0 0 0 1px rgba(138,100,29,.15), 0 10px 25px -10px rgba(0,0,0,.8);">
                
                <div>
                    <!-- Image Link -->
                    <a href="{{ route('hairstyles.show', $hairstyle->slug) }}" class="block relative overflow-hidden aspect-[4/3] bg-[#0b0805]">
                        <img src="{{ $hairstyle->image ?? '/images/fade-cut-closeup.jpg' }}" alt="{{ $hairstyle->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#171008] via-transparent to-transparent opacity-80"></div>
                        
                        <!-- Difficulty Badge -->
                        <span class="absolute top-2.5 right-2.5 rounded-[2px] border border-[#3c2c15] bg-[#0b0805]/90 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-[#f2d788] backdrop-blur-sm">
                            @switch($hairstyle->difficulty)
                                @case('easy') Dễ @break
                                @case('medium') Trung bình @break
                                @case('hard') Khó @break
                                @default {{ $hairstyle->difficulty }}
                            @endswitch
                        </span>
                    </a>

                    <!-- Details -->
                    <div class="p-4 space-y-2">
                        <h3 class="font-['Bebas_Neue'] text-xl tracking-wide text-[#f2d788] leading-tight">
                            <a href="{{ route('hairstyles.show', $hairstyle->slug) }}" class="hover:text-[#f4ecd8] transition-colors">
                                {{ $hairstyle->name }}
                            </a>
                        </h3>

                        <p class="text-xs text-[#6f6248] leading-relaxed line-clamp-2">
                            {{ \Illuminate\Support\Str::limit($hairstyle->description, 120) }}
                        </p>
                    </div>
                </div>

                <!-- Footer / Price -->
                <div class="p-4 pt-0 flex items-center justify-between border-t border-[#3c2c15]/50 mt-2">
                    <span class="text-[10px] uppercase font-bold text-[#6f6248]">Giá tham khảo</span>
                    @if ($hairstyle->reference_price)
                        <span class="font-['Bebas_Neue'] text-lg tracking-wider text-[#f2d788]">
                            {{ number_format((float) $hairstyle->reference_price, 0, ',', '.') }}đ
                        </span>
                    @else
                        <span class="text-xs text-[#6f6248] italic">Liên hệ</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-[#6f6248] rounded-[2px] border border-[#3c2c15] bg-[#171008]">
                <i class="fa-solid fa-[#8a641d] fa-scissors text-3xl mb-3 block text-[#3c2c15]"></i>
                <p class="text-xs">Không tìm thấy kiểu tóc phù hợp với yêu cầu tìm kiếm.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection