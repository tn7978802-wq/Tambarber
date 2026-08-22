@extends('layouts.app')

@section('title', 'Dịch vụ - Barbershop')

@section('content')

    <h1>Bảng giá dịch vụ</h1>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Dịch vụ</th>
                <th>Mô tả</th>
                <th>Thời gian</th>
                <th>Giá</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($services as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td>{{ $service->description }}</td>
                    <td>{{ $service->duration_minutes }} phút</td>
                    <td>{{ number_format((float) $service->price, 0, ',', '.') }}đ</td>
                    <td><a href="{{ route('booking.create', ['service_id' => $service->id]) }}">Đặt lịch</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Danh sách dịch vụ đang được cập nhật.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection