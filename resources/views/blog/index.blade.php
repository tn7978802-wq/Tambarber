@extends('layouts.app')

@section('title', 'Blog - Barbershop')

@section('content')
<div class="container py-8">
    
    <!-- Hero Header -->
    <div class="mb-10 text-center">
        <span class="section-eyebrow">Góc Chia Sẻ</span>
        <h1 class="text-4xl md:text-5xl font-['Bebas_Neue'] text-[#f2d788] tracking-wider uppercase mb-2">
            Blog &amp; Kiến Thức
        </h1>
        <p class="text-sm text-[#6f6248] max-w-lg mx-auto">
            Bí quyết chăm sóc tóc, tạo kiểu chuẩn nam tính và cập nhật các xu hướng barber mới nhất từ chuyên gia.
        </p>
        <div class="pole-divider small my-4"></div>
    </div>

    <!-- Main Grid -->
    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 list-none p-0">
        @forelse ($posts as $post)
            <li class="group flex flex-col bg-[#171008] border border-[#3c2c15] border-l-4 border-l-[#8a641d] rounded-[2px] overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-l-[#f2d788] hover:shadow-[0_10px_25px_-10px_rgba(207,159,63,0.3)]">
                
                <!-- Image Thumbnail -->
                <a href="{{ route('blog.show', $post->slug) }}" class="relative aspect-[16/9] overflow-hidden bg-[#0b0805]">
                    @if(!empty($post->thumbnail))
                        <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <!-- Fallback / Pattern Background -->
                        <div class="w-full h-full flex items-center justify-center bg-[radial-gradient(#3c2c15_1px,transparent_1px)] [background-size:16px_16px] text-[#8a641d]">
                            <i class="fa-solid fa-[#0b0805] fa-newspaper text-3xl opacity-40"></i>
                        </div>
                    @endif
                    
                    @if($post->category)
                        <span class="absolute top-3 left-3 bg-[#0b0805]/90 border border-[#8a641d] text-[#f2d788] text-[10px] uppercase tracking-widest font-semibold px-2.5 py-1 rounded-[2px] backdrop-blur-sm">
                            {{ $post->category }}
                        </span>
                    @endif
                </a>

                <!-- Content Body -->
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <!-- Title -->
                        <h3 class="font-['Bebas_Neue'] text-xl tracking-wide text-[#f4ecd8] group-hover:text-[#f2d788] transition-colors line-clamp-2 leading-snug mb-2">
                            <a href="{{ route('blog.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        
                        <!-- Excerpt -->
                        <p class="text-xs text-[#6f6248] line-clamp-3 leading-relaxed mb-4">
                            {{ $post->excerpt ?? 'Đang cập nhật nội dung...' }}
                        </p>
                    </div>

                    <!-- Meta Footer -->
                    <div class="pt-3 border-t border-[#3c2c15] flex items-center justify-between text-[11px] text-[#6f6248]">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-[#8a641d]"></i>
                            {{ $post->publish_at ? $post->publish_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}
                        </span>
                        
                        <a href="{{ route('blog.show', $post->slug) }}" class="text-[#8a641d] group-hover:text-[#f2d788] font-bold uppercase tracking-wider transition-colors inline-flex items-center gap-1">
                            Đọc tiếp &rarr;
                        </a>
                    </div>
                </div>

            </li>
        @empty
            <li class="col-span-full py-16 text-center bg-[#171008] border border-[#3c2c15] rounded-[2px]">
                <p class="text-base text-[#6f6248]">Chưa có bài viết nào được xuất bản.</p>
            </li>
        @endforelse
    </ul>

    <!-- Pagination -->
    @if($posts instanceof \Illuminate\Pagination\LengthAwarePaginator && $posts->hasPages())
        <div class="mt-10 flex justify-center">
            <div class="custom-pagination">
                {{ $posts->links() }}
            </div>
        </div>
    @endif

</div>
@endsection