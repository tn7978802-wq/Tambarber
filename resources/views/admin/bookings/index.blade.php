@extends('layouts.admin')

@section('title', 'Quản lý Lịch hẹn')

@section('content')

    <span class="section-eyebrow">Quản trị</span>
    <h1>Quản lý Lịch hẹn</h1>
    <div class="pole-divider small" style="margin-left:0;"></div>

    <form method="GET" action="{{ route('admin.bookings.index') }}" class="filter-bar">
        <select class="px-3 py-2 border rounded text-sm w-full" name="status">
            <option value="">Tất cả trạng thái</option>
            @foreach (['pending' => 'Chờ xác nhận', 'confirmed' => 'Đã xác nhận', 'completed' => 'Hoàn thành', 'cancelled' => 'Đã huỷ'] as $value => $label)
                <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <input class="px-3 py-2 border rounded text-sm w-full" type="date" name="date" value="{{ $filters['date'] ?? '' }}">
        <button type="submit" class="btn btn-gold">Lọc</button>
    </form>

    <table class="data-table w-full bg-white rounded-lg overflow-hidden mb-4">
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
                    <td>{{ $booking->customer_name }}<br><span class="muted">{{ $booking->customer_phone }}</span></td>
                    <td>{{ $booking->service->name }}</td>
                    <td>{{ $booking->barber->name }}</td>
                    <td>{{ $booking->booking_time }} - {{ $booking->booking_date->format('d/m/Y') }}</td>
                    <td><span class="status-pill {{ $booking->status }}">{{ $booking->status }}</span></td>
                    <td>
                        @if ($booking->status === 'pending')
                            <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-sm btn-outline">Xác nhận</button>
                            </form>
                        @endif
                        @if ($booking->status === 'confirmed')
                            <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-sm btn-gold">Hoàn thành</button>
                            </form>
                        @endif
                        @if (in_array($booking->status, ['pending', 'confirmed']))
                            <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-sm btn-danger">Huỷ</button>
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
