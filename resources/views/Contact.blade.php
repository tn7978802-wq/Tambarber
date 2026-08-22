@extends('layouts.app')

@section('title', 'Liên hệ - Barbershop')

@section('content')

    <h1>Liên hệ</h1>

    <section>
        <h2>Thông tin liên hệ</h2>
        <ul>
            <li>Địa chỉ: 93/8A Lê Lợi,Hooc Môn,TPHCM</li>
            <li>Điện thoại: 0949146767 </li>
            <li>Giờ mở cửa: 08:00 - 20:00 (Tất cả các ngày trong tuần)</li>
        </ul>
        {{-- Vị trí đặt bản đồ Google Maps (nhúng iframe) --}}
        <div><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125373.55880388526!2d106.44279034335939!3d10.893402300000007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d52f5093ee55%3A0x925063b512a7a562!2sT%C3%82M%20BARBER%20SHOP!5e0!3m2!1svi!2s!4v1787395393636!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe></div>
    </section>

    <section>
        <h2>Gửi góp ý / câu hỏi</h2>
        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <label>Họ tên: <input type="text" name="name" value="{{ old('name') }}" required></label>
            <br>
            <label>Số điện thoại: <input type="text" name="phone" value="{{ old('phone') }}" required></label>
            <br>
            <label>Nội dung: <textarea name="message" required>{{ old('message') }}</textarea></label>
            <br>
            <button type="submit">Gửi liên hệ</button>
        </form>
    </section>

@endsection