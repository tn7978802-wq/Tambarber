@extends('layouts.app')

@section('title', $post->title . ' - Barbershop')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 space-y-8">

    <!-- BACK BUTTON -->
    <div>
        <a href="{{ route('blog.index') }}" 
           class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-[#cf9f3f] hover:text-[#f2d788] transition-colors">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            <span>Quay lại Blog</span>
        </a>
    </div>

    <!-- ARTICLE HEADER -->
    <header class="space-y-4 text-center sm:text-left border-b border-[#3c2c15]/60 pb-8">
        @if($post->category)
            <span class="inline-block px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-[#f2d788] bg-[#171008] border border-[#8a641d]/40 rounded-[2px]">
                {{ $post->category }}
            </span>
        @endif

        <h1 class="font-['Bebas_Neue'] text-3xl sm:text-5xl tracking-wide text-[#f4ecd8] leading-tight">
            {{ $post->title }}
        </h1>

        <div class="flex items-center justify-center sm:justify-start gap-4 text-xs text-[#6f6248] font-medium">
            <span class="flex items-center gap-1.5">
                <i class="fa-regular fa-calendar text-[#a8342f]"></i>
                {{ $post->publish_at?->format('d/m/Y') }}
            </span>
            <span>•</span>
            <span class="flex items-center gap-1.5">
                <i class="fa-regular fa-clock text-[#a8342f]"></i>
                Tâm Barbershop Editorial
            </span>
        </div>
    </header>

    <!-- FEATURED THUMBNAIL -->
    @if ($post->thumbnail)
        <div class="relative overflow-hidden rounded-[4px] border border-[#3c2c15] shadow-2xl">
            <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" class="w-full max-h-[480px] object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#070503] via-transparent to-transparent opacity-40"></div>
        </div>
    @endif

    <!-- MAIN ARTICLE CONTENT -->
    <article class="prose prose-invert max-w-none text-[#f4ecd8]/90 text-sm sm:text-base leading-relaxed space-y-4 font-light tracking-wide">
        {!! nl2br(e($post->content)) !!}
    </article>

    <!-- VINTAGE DIVIDER -->
    <div class="relative py-6 flex items-center justify-center">
        <div class="grow h-[1px] bg-gradient-to-r from-transparent via-[#3c2c15] to-transparent"></div>
        <span class="px-4 text-[#8a641d] text-xs"><i class="fa-solid fa-scissors"></i></span>
        <div class="grow h-[1px] bg-gradient-to-r from-transparent via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- RELATED POSTS SECTION -->
    @if($related->isNotEmpty())
        <section class="space-y-6 pt-4">
            <div class="flex items-center gap-3">
                <span class="h-2 w-2 bg-[#a8342f] rounded-full"></span>
                <h2 class="font-['Bebas_Neue'] text-2xl tracking-widest text-[#f2d788] uppercase">
                    Bài Viết Liên Quan
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($related as $item)
                    <a href="{{ route('blog.show', $item->slug) }}" 
                       class="group rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-4 flex flex-col justify-between hover:border-[#8a641d] transition-all hover:-translate-y-1 shadow-lg">
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#a8342f]">
                                {{ $item->category ?? 'Tin tức' }}
                            </span>
                            <h3 class="font-semibold text-sm text-[#f4ecd8] group-hover:text-[#f2d788] transition-colors line-clamp-2 leading-snug">
                                {{ $item->title }}
                            </h3>
                        </div>
                        <div class="pt-4 mt-auto flex items-center justify-between text-[11px] text-[#6f6248] font-medium">
                            <span>Đọc tiếp</span>
                            <i class="fa-solid fa-chevron-right text-[9px] group-hover:translate-x-1 transition-transform text-[#f2d788]"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

</div>
@endsection