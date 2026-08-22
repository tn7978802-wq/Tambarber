@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <h1>Dashboard</h1>

    <nav>
        @foreach (['day' => 'Ngày', 'week' => 'Tuần', 'month' => 'Tháng'] as $key => $label)
            <a href="{{ route('admin.dashboard', ['range' => $key]) }}"
               @if($dashboardFilter === $key) style="font-weight:bold;" @endif>
                {{ $label }}
            </a>
        @endforeach
    </nav>

    <h2>Tổng quan ({{ $dashboardFilterLabel }})</h2>
    <ul>
        @foreach ($summaryMetrics as $metric)
            <li>
                <strong>{{ $metric['label'] }}:</strong> {{ $metric['value'] }}
                @if ($metric['delta'])
                    ({{ $metric['delta']['text'] }} so với kỳ trước)
                @endif
            </li>
        @endforeach
    </ul>

    <h2>Dịch vụ được đặt nhiều nhất</h2>
    <ol>
        @forelse ($topServices as $item)
            <li>{{ $item->label }} - {{ $item->value }} lượt</li>
        @empty
            <li>Chưa có dữ liệu.</li>
        @endforelse
    </ol>

    <h2>Barber đông khách nhất</h2>
    <ol>
        @forelse ($topBarbers as $item)
            <li>{{ $item->label }} - {{ $item->value }} lượt</li>
        @empty
            <li>Chưa có dữ liệu.</li>
        @endforelse
    </ol>

    <h2>Khung giờ đặt lịch phổ biến</h2>
    <ul>
        @foreach ($hourDistribution as $slot)
            <li>{{ $slot->label }}: {{ $slot->total }} lượt</li>
        @endforeach
    </ul>

    <h2>Lịch hẹn sắp tới</h2>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Mã</th>
                <th>Khách hàng</th>
                <th>Dịch vụ</th>
                <th>Barber</th>
                <th>Thời gian</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($upcomingBookings as $booking)
                <tr>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->customer_name }}</td>
                    <td>{{ $booking->service_name }}</td>
                    <td>{{ $booking->barber_name }}</td>
                    <td>{{ $booking->booking_time }} - {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</td>
                    <td>{{ $booking->status }}</td>
                </tr>
            @empty
                <tr><td colspan="6">Không có lịch hẹn sắp tới.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p><a href="{{ route('admin.bookings.index') }}">Xem toàn bộ lịch hẹn &rarr;</a></p>

@endsection