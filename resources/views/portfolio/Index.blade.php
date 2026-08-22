@extends('layouts.app')

@section('title', 'Portfolio - Barbershop')

@section('content')

    <span class="section-eyebrow">Thư viện ảnh</span>
    <h1>Portfolio / Gallery</h1>
    <div class="pole-divider small" style="margin-left:0;"></div>

    <nav class="main-nav" style="margin-bottom:1.75rem;">
        <a href="{{ route('portfolio.index') }}" @class(['is-active' => !$selectedCategory])>Tất cả</a>
        @foreach ($categories as $category)
            <a href="{{ route('portfolio.index', ['category' => $category]) }}"
               @class(['is-active' => $selectedCategory === $category])>
                {{ $category }}
            </a>
        @endforeach
    </nav>

    <ul class="card-grid">
        @forelse ($portfolios as $item)
            <li class="card">
                <img src="{{ $item->image }}" alt="{{ $item->title }}">
                <h3>{{ $item->title }}</h3>
                @if ($item->hairstyle)
                    <p class="meta">Kiểu tóc: {{ $item->hairstyle->name }}</p>
                @endif
                @if ($item->barber)
                    <p class="meta">Thực hiện bởi: {{ $item->barber->name }}</p>
                @endif
            </li>
        @empty
            <li class="card">Chưa có hình ảnh trong danh mục này.</li>
        @endforelse
    </ul>

@endsection