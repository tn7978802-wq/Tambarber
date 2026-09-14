@extends('layouts.app')

@section('title', $portfolio->title . ' - Tâm Barbershop')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('portfolio.index') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-[#f2d788] hover:text-[#f4ecd8]">
            <i class="fa-solid fa-arrow-left"></i>
            Quay lại thư viện
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="overflow-hidden rounded-[2px] border border-[#3c2c15] bg-[#0b0805] p-3 shadow-xl">
            <h2 class="mb-3 text-xs font-bold uppercase tracking-[0.18em] text-[#6f6248]">Ảnh sau khi thực hiện</h2>
            <img src="{{ $portfolio->image_after ? asset('storage/' . $portfolio->image_after) : ($portfolio->image_before ? asset('storage/' . $portfolio->image_before) : 'https://picsum.photos/800/800') }}"
                 alt="{{ $portfolio->title }}"
                 class="max-h-[620px] w-full rounded-[2px] object-contain bg-[#171008]">
        </div>

        <div class="space-y-5">
            <span class="inline-flex rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-[#0b0805]">
                {{ App\Models\PortfolioItem::CATEGORIES[$portfolio->category] ?? 'Khác' }}
            </span>

            <h1 class="font-['Bebas_Neue'] text-4xl tracking-wider text-[#f2d788] uppercase">
                {{ $portfolio->title }}
            </h1>

            @if ($portfolio->barber)
                <div class="flex items-center gap-3 rounded-[2px] border border-[#3c2c15] bg-[#0b0805] p-3 text-sm text-[#f4ecd8]">
                    <i class="fa-solid fa-user-check text-[#f2d788]"></i>
                    <span>Thực hiện bởi: <strong class="text-[#f2d788]">{{ $portfolio->barber->name }}</strong></span>
                </div>
            @endif

            @if ($portfolio->description)
                <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-4 text-sm leading-7 text-[#f4ecd8]/80">
                    {{ $portfolio->description }}
                </div>
            @endif

            @if ($portfolio->image_before)
                <div class="space-y-2">
                    <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-[#6f6248]">Ảnh trước khi thực hiện</h2>
                    <img src="{{ asset('storage/' . $portfolio->image_before) }}" alt="Ảnh trước khi thực hiện" class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] object-contain">
                </div>
            @endif
        </div>
    </div>

    @if ($related->isNotEmpty())
        <div class="mt-12">
            <h2 class="mb-5 text-xs font-bold uppercase tracking-[0.2em] text-[#6f6248]">Tác phẩm tương tự</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($related as $item)
                    <a href="{{ route('portfolio.show', $item) }}" class="group overflow-hidden rounded-[2px] border border-[#3c2c15] bg-[#171008] transition hover:border-[#8a641d]">
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ $item->image_after ? asset('storage/' . $item->image_after) : 'https://picsum.photos/800/800' }}"
                                 alt="{{ $item->title }}"
                                 class="h-full w-full object-contain transition duration-300 group-hover:scale-110">
                        </div>
                        <div class="p-3">
                            <div class="text-[10px] uppercase tracking-[0.18em] text-[#f2d788]">
                                {{ App\Models\PortfolioItem::CATEGORIES[$item->category] ?? 'Khác' }}
                            </div>
                            <div class="mt-2 text-base font-semibold text-[#f4ecd8]">{{ $item->title }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
