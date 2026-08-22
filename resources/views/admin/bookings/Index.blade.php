@extends('layouts.admin')

@section('title', 'Quản lý Lịch hẹn')

@section('content')

    <h1>Quản lý Lịch hẹn</h1>

    <form method="GET" action="{{ route('admin.bookings.index') }}">
        <select name="status">
            <option value="">Tất cả trạng thái</option>
            @foreach (['pending' => 'Chờ xác nhận', 'confirmed' => 'Đã xác nhận', 'completed' => 'Hoàn thành', 'cancelled' => 'Đã huỷ'] as $value => $label)
                <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <input type="date" name="date" value="{{ $filters['date'] ?? '' }}">
        <button type="submit">Lọc</button>
    </form>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Mã</th>
                <th>Khách hàng</th>
                <th>Dịch vụ</th>
                <th>Barber</th>
                <th>Thời gian</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->customer_name }}<br>{{ $booking->customer_phone }}</td>
                    <td>{{ $booking->service->name }}</td>
                    <td>{{ $booking->barber->name }}</td>
                    <td>{{ $booking->booking_time }} - {{ $booking->booking_date->format('d/m/Y') }}</td>
                    <td>{{ $booking->status }}</td>
                    <td>
                        @if ($booking->status === 'pending')
                            <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" style="display:inline">
                                @csrf @method('PUT')
                                <button type="submit">Xác nhận</button>
                            </form>
                        @endif
                        @if ($booking->status === 'confirmed')
                            <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST" style="display:inline">
                                @csrf @method('PUT')
                                <button type="submit">Hoàn thành</button>
                            </form>
                        @endif
                        @if (in_array($booking->status, ['pending', 'confirmed']))
                            <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" style="display:inline">
                                @csrf @method('PUT')
                                <button type="submit">Huỷ</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">Chưa có lịch hẹn nào.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $bookings->links() }}

@endsection