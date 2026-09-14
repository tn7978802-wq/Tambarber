@extends('layouts.admin') {{-- hoặc layout admin của bạn --}}

@section('title', 'Thư viện tác phẩm - Tâm Barbershop Admin')

@section('content')
@php
    // Ensure selected category variable exists (comes from query param 'danh-muc')
    $selectedCategory = request()->query('danh-muc') ?? null;
@endphp
<div class="max-w-9xl mx-auto space-y-8 py-4">

    <!-- HEADER SECTION & TIÊU ĐỀ -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
         style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                        <i class="fa-solid fa-images text-xs"></i>
                    </span>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a8342f]">Quản lý nội dung</span>
                        <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase leading-tight">
                            Thư Viện Tác Phẩm
                        </h1>
                    </div>
                </div>
                <p class="text-xs text-[#f4ecd8]/70">
                    Quản lý bộ sưu tập ảnh Portfolio hiển thị ở trang công khai cho khách hàng tham khảo.
                </p>
            </div>

            <!-- Nút + Thêm tác phẩm -->
            <div>
                <a href="{{ route('admin.portfolio.create') }}" 
                   class="inline-flex items-center gap-2 rounded-[2px] border border-[#f2d788]/50 bg-gradient-to-r from-[#7c1f22] to-[#8a641d] px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-[#f2d788] shadow-[0_0_15px_rgba(168,52,47,0.4)] hover:brightness-125 transition-all">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Thêm tác phẩm</span>
                </a>
            </div>
        </div>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- MAIN CARD WRAPPER CONTAINING CATEGORIES & GRID -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-6">
        
        <!-- BỘ LỌC CATEGORY -->
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-[#3c2c15] pb-5">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-filter text-xs text-[#a8342f]"></i>
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">Lọc theo danh mục:</span>
            </div>

            <div class="flex items-center flex-wrap gap-2">
                <a href="{{ route('admin.portfolio.index') }}" 
                   class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider rounded-[2px] transition-all border {{ !request('danh-muc') ? 'bg-gradient-to-r from-[#7c1f22] to-[#8a641d] text-[#f2d788] border-[#f2d788]/50 shadow-[0_0_10px_rgba(168,52,47,0.4)]' : 'border-[#3c2c15] bg-[#070503] text-[#f4ecd8]/60 hover:text-[#f2d788] hover:bg-[#171008] hover:border-[#8a641d]' }}">
                    Tất cả
                </a>

                @foreach ($categories as $key => $name)
                    <a href="{{ route('admin.portfolio.index', ['danh-muc' => $key]) }}" 
                       class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider rounded-[2px] transition-all border {{ (request('danh-muc') === (string)$key) ? 'bg-gradient-to-r from-[#7c1f22] to-[#8a641d] text-[#f2d788] border-[#f2d788]/50 shadow-[0_0_10px_rgba(168,52,47,0.4)]' : 'border-[#3c2c15] bg-[#070503] text-[#f4ecd8]/60 hover:text-[#f2d788] hover:bg-[#171008] hover:border-[#8a641d]' }}">
                        {{ $name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- PORTFOLIO GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($items as $item)
                <div class="group rounded-[4px] border border-[#3c2c15] bg-[#070503] overflow-hidden shadow-lg transition-all duration-300 hover:border-[#a8342f]/50 flex flex-col justify-between">
                    
                    <div>
                        <!-- Image Card -->
                        <div class="relative overflow-hidden aspect-square bg-[#0b0805]">
                            <img src="{{ $item->image_after ? asset('storage/' . $item->image_after) : ($item->image_before ? asset('storage/' . $item->image_before) : 'https://picsum.photos/800/800') }}" alt="{{ $item->title }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#070503] via-transparent to-transparent opacity-80"></div>
                            
                            <!-- Badge Category -->
                            <span class="absolute top-2 left-2 bg-[#070503]/90 text-[#f2d788] border border-[#8a641d]/40 px-2.5 py-0.5 text-[10px] uppercase font-bold tracking-wider rounded-[2px] backdrop-blur-sm">
                                {{ $item->categoryLabel() }}
                            </span>
                        </div>

                        <!-- Details -->
                        <div class="p-4 space-y-2">
                            <h3 class="font-['Bebas_Neue'] text-xl tracking-wide text-[#f2d788] leading-tight group-hover:text-[#fff5d6] transition-colors">
                                {{ $item->title }}
                            </h3>

                            <div class="space-y-1.5 text-xs">
                                @if ($item->hairstyle)
                                    <p class="flex items-center gap-1.5 text-[#f4ecd8]/80">
                                        <i class="fa-solid fa-scissors text-[10px] text-[#a8342f]"></i>
                                        <span>Kiểu tóc: <strong class="text-[#f4ecd8]">{{ $item->hairstyle->name }}</strong></span>
                                    </p>
                                @endif

                                @if ($item->barber)
                                    <p class="flex items-center gap-1.5 text-[#f4ecd8]/80">
                                        <i class="fa-solid fa-user-check text-[10px] text-[#a8342f]"></i>
                                        <span>Thực hiện: <strong class="text-[#f2d788]">{{ $item->barber->name }}</strong></span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-4 pt-0 space-y-3">
                        <div class="h-[1px] w-full bg-[#3c2c15]/60"></div>
                        <div class="flex items-center justify-end gap-2 text-xs">
                            <a href="{{ route('admin.portfolio.edit', $item->id) }}" 
                               class="px-3 py-1 rounded-[2px] border border-[#3c2c15] bg-[#110d07] text-[#f4ecd8]/80 hover:border-[#8a641d] hover:text-[#f2d788] transition-all flex items-center gap-1">
                                <i class="fa-regular fa-pen-to-square text-[11px]"></i> Sửa
                            </a>
                            
                            <form action="{{ route('admin.portfolio.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa tác phẩm này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 rounded-[2px] border border-red-900/50 bg-red-950/30 text-red-400 hover:bg-red-900/50 hover:text-red-200 transition-all flex items-center gap-1">
                                    <i class="fa-regular fa-trash-can text-[11px]"></i> Xóa
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            @empty
                <!-- Màn hình danh sách trống -->
                <div class="col-span-full py-16 text-center text-[#6f6248] rounded-[2px] border border-[#3c2c15]/60 bg-[#070503]">
                    <i class="fa-solid fa-images text-3xl mb-3 block text-[#3c2c15]"></i>
                    <p class="text-xs text-[#f4ecd8]/70">Chưa có tác phẩm nào trong danh mục này.</p>
                    <a href="{{ route('admin.portfolio.create') }}" class="inline-block mt-3 text-xs font-bold text-[#f2d788] hover:text-[#fff5d6] hover:underline">
                        + Thêm tác phẩm mới ngay
                    </a>
                </div>
            @endforelse
        </div>

        @if($items->hasPages())
            <div class="pt-4 border-t border-[#3c2c15]">
                {{ $items->links() }}
            </div>
        @endif

    </div>

</div>
@endsection