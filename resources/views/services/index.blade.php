@extends('layouts.app')

@section('title', 'Dịch vụ - Barbershop')

@section('content')

    <span class="section-eyebrow">Bảng giá dịch vụ</span>
    <h1>Bảng giá dịch vụ</h1>
    <div class="pole-divider small" style="margin-left:0;"></div>

    <table class="price-table">
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
                    <td><strong>{{ $service->name }}</strong></td>
                    <td>{{ $service->description }}</td>
                    <td>{{ $service->duration_minutes }} phút</td>
                    <td class="price">{{ number_format((float) $service->price, 0, ',', '.') }}đ</td>
                    <td><a href="{{ route('booking.create', ['service_id' => $service->id]) }}" class="btn btn-outline">Đặt lịch</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Danh sách dịch vụ đang được cập nhật.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection