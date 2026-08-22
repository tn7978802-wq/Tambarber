@extends('layouts.app')

@section('title', $hairstyle->name . ' - Barbershop')

@section('content')

    <p><a href="{{ route('hairstyles.index') }}">&larr; Quay lại danh sách kiểu tóc</a></p>

    <div class="hero">
        <div>
            <span class="section-eyebrow">Kiểu tóc</span>
            <h1>{{ $hairstyle->name }}</h1>
            <p>{{ $hairstyle->description }}</p>
            <ul>
                <li><strong>Phù hợp khuôn mặt:</strong> {{ $hairstyle->suitable_face_shapes ?? 'Đang cập nhật' }}</li>
                <li><strong>Độ khó:</strong> {{ $hairstyle->difficulty }}</li>
                <li>
                    <strong>Giá tham khảo:</strong>
                    {{ $hairstyle->reference_price ? number_format((float) $hairstyle->reference_price, 0, ',', '.') . 'đ' : 'Liên hệ' }}
                </li>
            </ul>
            <a href="{{ route('booking.create') }}" class="btn btn-gold">Đặt lịch với kiểu tóc này &rarr;</a>
        </div>
        <img src="{{ $hairstyle->image ?? '/images/fade-cut-closeup.jpg' }}" alt="{{ $hairstyle->name }}">
    </div>

    <div class="pole-divider"></div>

    <section>
        <h2>Kiểu tóc liên quan</h2>
        <ul class="card-grid">
            @foreach ($related as $item)
                <li class="card">
                    <a href="{{ route('hairstyles.show', $item->slug) }}"><h3>{{ $item->name }}</h3></a>
                </li>
            @endforeach
        </ul>
    </section>

@endsection