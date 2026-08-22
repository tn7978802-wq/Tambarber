@extends('layouts.app')

@section('title', 'Tài khoản của tôi - Barbershop')

@section('content')

    <span class="section-eyebrow">Xin chào</span>
    <h1>Tài khoản của tôi</h1>
    <div class="pole-divider small" style="margin-left:0;"></div>

    <p>
        Xin chào, <strong class="eyebrow-gold">{{ auth()->user()->fullname }}</strong>
        ({{ auth()->user()->email }})
    </p>

    <h2>Lịch sử đặt lịch</h2>

    <table class="data-table">
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
                    <td><span class="status-pill {{ $booking->status }}">{{ $booking->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5">Bạn chưa có lịch hẹn nào.</td></tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('booking.create') }}" class="btn btn-gold">Đặt lịch mới &rarr;</a>

@endsection