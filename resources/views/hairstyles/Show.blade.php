@extends('layouts.app')

@section('title', $hairstyle->name . ' - Barbershop')

@section('content')

    <a href="{{ route('hairstyles.index') }}">&larr; Quay lại danh sách kiểu tóc</a>

    <h1>{{ $hairstyle->name }}</h1>

    <img src="{{ $hairstyle->image ?? '/images/fade-cut-closeup.jpg' }}" alt="{{ $hairstyle->name }}" width="400">

    <p>{{ $hairstyle->description }}</p>

    <ul>
        <li><strong>Phù hợp khuôn mặt:</strong> {{ $hairstyle->suitable_face_shapes ?? 'Đang cập nhật' }}</li>
        <li><strong>Độ khó:</strong> {{ $hairstyle->difficulty }}</li>
        <li>
            <strong>Giá tham khảo:</strong>
            {{ $hairstyle->reference_price ? number_format((float) $hairstyle->reference_price, 0, ',', '.') . 'đ' : 'Liên hệ' }}
        </li>
    </ul>

    <a href="{{ route('booking.create') }}">Đặt lịch với kiểu tóc này &rarr;</a>

    <hr>

    <h2>Kiểu tóc liên quan</h2>
    <ul>
        @foreach ($related as $item)
            <li>
                <a href="{{ route('hairstyles.show', $item->slug) }}">{{ $item->name }}</a>
            </li>
        @endforeach
    </ul>

@endsection