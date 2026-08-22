@extends('layouts.app')

@section('title', 'Giới thiệu - Barbershop')

@section('content')

    <h1>Giới thiệu về nghề Barber</h1>

    <section>
        <h2>Nghề Barber là gì?</h2>
        <p>
            Barber là người thợ chuyên cắt tóc, tạo kiểu và cạo râu cho nam giới,
            kết hợp giữa kỹ thuật cắt gọt chính xác và gu thẩm mỹ để mang lại
            diện mạo phù hợp với từng khách hàng.
        </p>
    </section>

    <section>
        <h2>Công việc hằng ngày của một Barber</h2>
        <ul>
            <li>Tư vấn kiểu tóc phù hợp với khuôn mặt và phong cách khách hàng</li>
            <li>Cắt tóc, tạo kiểu, cạo râu, gội đầu massage</li>
            <li>Vệ sinh, bảo quản dụng cụ hành nghề</li>
            <li>Cập nhật xu hướng tóc mới</li>
        </ul>
    </section>

    <section>
        <h2>Kỹ năng cần có</h2>
        <ul>
            @foreach ($skills as $skill)
                <li>{{ $skill }}</li>
            @endforeach
        </ul>
    </section>

    <section>
        <h2>Lộ trình từ người mới đến Barber chuyên nghiệp</h2>
        <ol>
            @foreach ($careerPath as $stage)
                <li>
                    <strong>{{ $stage['step'] }}</strong>
                    <br>{{ $stage['description'] }}
                </li>
            @endforeach
        </ol>
    </section>

    <section>
        <h2>Đội ngũ Barber của chúng tôi</h2>
        <ul>
            @forelse ($barbers as $barber)
                <li>
                    <img src="{{ $barber->avatar ?? '/images/shop-working.jpg' }}" alt="{{ $barber->name }}" width="150">
                    <br>
                    <strong>{{ $barber->name }}</strong> - {{ $barber->title }}
                    ({{ $barber->years_experience }} năm kinh nghiệm)
                    <br>{{ $barber->bio }}
                </li>
            @empty
                <li>Thông tin đội ngũ đang được cập nhật.</li>
            @endforelse
        </ul>
    </section>

@endsection