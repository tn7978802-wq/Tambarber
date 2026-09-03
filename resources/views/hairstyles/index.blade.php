@extends('layouts.app')

@section('title', 'Kiểu tóc - Barbershop')

@section('content')

    <span class="section-eyebrow">Khám phá</span>
    <h1>Các kiểu tóc</h1>
    <div class="pole-divider small" style="margin-left:0;"></div>

    <form action="{{ route('hairstyles.index') }}" method="GET" style="display:flex; gap:.75rem; flex-wrap:wrap; align-items:flex-end; margin-bottom:2rem;">
        <label style="flex:1; min-width:220px; margin-bottom:0;">Tìm kiếm
            <input class="px-3 py-2 border rounded text-sm w-full" type="text" name="q" value="{{ $search }}" placeholder="Tìm kiểu tóc...">
        </label>
        <label style="margin-bottom:0;">Độ khó
            <select class="px-3 py-2 border rounded text-sm w-full" name="difficulty">
                <option value="">Tất cả độ khó</option>
                <option value="easy" @selected($difficulty === 'easy')>Dễ</option>
                <option value="medium" @selected($difficulty === 'medium')>Trung bình</option>
                <option value="hard" @selected($difficulty === 'hard')>Khó</option>
            </select>
        </label>
        <button type="submit" class="btn btn-gold">Lọc</button>
    </form>

    <ul class="card-grid">
        @forelse ($hairstyles as $hairstyle)
            <li class="card">
                <a href="{{ route('hairstyles.show', $hairstyle->slug) }}">
                    <img src="{{ $hairstyle->image ?? '/images/fade-cut-closeup.jpg' }}" alt="{{ $hairstyle->name }}">
                    <h3>{{ $hairstyle->name }}</h3>
                </a>
                <p>{{ \Illuminate\Support\Str::limit($hairstyle->description, 120) }}</p>
                <p class="meta">Độ khó: {{ $hairstyle->difficulty }}</p>
                @if ($hairstyle->reference_price)
                    <p class="price">{{ number_format((float) $hairstyle->reference_price, 0, ',', '.') }}đ</p>
                @endif
            </li>
        @empty
            <li class="card">Không tìm thấy kiểu tóc phù hợp.</li>
        @endforelse
    </ul>

@endsection
