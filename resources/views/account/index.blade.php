@extends('layouts.app')

@section('title', 'Tài khoản của tôi - Barbershop')

@section('content')

    <h1>Tài khoản của tôi</h1>

    <p>
        Xin chào, <strong>{{ auth()->user()->fullname }}</strong>
        ({{ auth()->user()->email }})
    </p>

    <h2>Lịch sử đặt lịch</h2>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Mã lịch hẹn</th>
                <th>Dịch vụ</th>
                <th>Barber</th>
                <th>Thời gian</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->service->name }}</td>
                    <td>{{ $booking->barber->name }}</td>
                    <td>{{ $booking->booking_time }} - {{ $booking->booking_date->format('d/m/Y') }}</td>
                    <td>{{ $booking->status }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Bạn chưa có lịch hẹn nào.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p><a href="{{ route('booking.create') }}">Đặt lịch mới &rarr;</a></p>

@endsection