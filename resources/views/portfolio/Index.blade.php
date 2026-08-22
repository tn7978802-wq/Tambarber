@extends('layouts.app')

@section('title', 'Portfolio - Barbershop')

@section('content')

    <h1>Portfolio / Gallery</h1>

    <nav>
        <a href="{{ route('portfolio.index') }}" @if(!$selectedCategory) style="font-weight:bold;" @endif>Tất cả</a>
        @foreach ($categories as $category)
            |
            <a href="{{ route('portfolio.index', ['category' => $category]) }}"
               @if($selectedCategory === $category) style="font-weight:bold;" @endif>
                {{ $category }}
            </a>
        @endforeach
    </nav>

    <ul>
        @forelse ($portfolios as $item)
            <li>
                <img src="{{ $item->image }}" alt="{{ $item->title }}" width="250">
                <br>
                <strong>{{ $item->title }}</strong>
                @if ($item->hairstyle)
                    &middot; Kiểu tóc: {{ $item->hairstyle->name }}
                @endif
                @if ($item->barber)
                    &middot; Thực hiện bởi: {{ $item->barber->name }}
                @endif
            </li>
        @empty
            <li>Chưa có hình ảnh trong danh mục này.</li>
        @endforelse
    </ul>

@endsection