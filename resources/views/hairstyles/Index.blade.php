@extends('layouts.app')

@section('title', 'Kiểu tóc - Barbershop')

@section('content')

    <h1>Các kiểu tóc</h1>

    <form action="{{ route('hairstyles.index') }}" method="GET">
        <input type="text" name="q" value="{{ $search }}" placeholder="Tìm kiểu tóc...">
        <select name="difficulty">
            <option value="">Tất cả độ khó</option>
            <option value="easy" @selected($difficulty === 'easy')>Dễ</option>
            <option value="medium" @selected($difficulty === 'medium')>Trung bình</option>
            <option value="hard" @selected($difficulty === 'hard')>Khó</option>
        </select>
        <button type="submit">Lọc</button>
    </form>

    <ul>
        @forelse ($hairstyles as $hairstyle)
            <li>
                <a href="{{ route('hairstyles.show', $hairstyle->slug) }}">
                    <img src="{{ $hairstyle->image ?? '/images/fade-cut-closeup.jpg' }}" alt="{{ $hairstyle->name }}" width="150">
                    <br>
                    <strong>{{ $hairstyle->name }}</strong>
                </a>
                <br>{{ \Illuminate\Support\Str::limit($hairstyle->description, 120) }}
                <br>Độ khó: {{ $hairstyle->difficulty }}
                @if ($hairstyle->reference_price)
                    &middot; Giá tham khảo: {{ number_format((float) $hairstyle->reference_price, 0, ',', '.') }}đ
                @endif
            </li>
        @empty
            <li>Không tìm thấy kiểu tóc phù hợp.</li>
        @endforelse
    </ul>

@endsection