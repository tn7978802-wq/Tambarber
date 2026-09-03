@extends('layouts.app')

@section('title', 'Giới thiệu - Barbershop')

@section('content')

    <span class="section-eyebrow">Câu chuyện của chúng tôi</span>
    <h1>Giới thiệu về nghề Barber</h1>
    <div class="pole-divider small" style="margin-left:0;"></div>

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
        <ol class="stage-list">
            @foreach ($careerPath as $i => $stage)
                <li>
                    <span class="stage-badge">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <div>
                        <strong>{{ $stage['step'] }}</strong>
                        {{ $stage['description'] }}
                    </div>
                </li>
            @endforeach
        </ol>
    </section>

    <section>
        <h2>Đội ngũ Barber của chúng tôi</h2>
        <ul class="team-grid">
            @forelse ($barbers as $barber)
                <li class="team-card">
                    <img src="{{ $barber->avatar ?? '/images/shop-working.jpg' }}" alt="{{ $barber->name }}">
                    <strong>{{ $barber->name }}</strong>
                    <p class="role">{{ $barber->title }} &middot; {{ $barber->years_experience }} năm kinh nghiệm</p>
                    <p>{{ $barber->bio }}</p>
                </li>
            @empty
                <li>Thông tin đội ngũ đang được cập nhật.</li>
            @endforelse
        </ul>
    </section>

@endsection