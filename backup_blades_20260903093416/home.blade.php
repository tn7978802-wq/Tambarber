@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <span class="section-eyebrow">Tổng quan vận hành</span>
    <h1>Dashboard</h1>
    <div class="pole-divider small" style="margin-left:0;"></div>

    <nav class="filter-bar">
        @foreach (['day' => 'Ngày', 'week' => 'Tuần', 'month' => 'Tháng'] as $key => $label)
            <a href="{{ route('admin.dashboard', ['range' => $key]) }}"
               class="btn btn-sm @if($dashboardFilter === $key) btn-gold @else btn-outline @endif">
                {{ $label }}
            </a>
        @endforeach
    </nav>

    <h2>Tổng quan ({{ $dashboardFilterLabel }})</h2>
    <ul class="metric-grid">
        @foreach ($summaryMetrics as $metric)
            <li class="metric-card">
                <span class="metric-label">{{ $metric['label'] }}</span>
                <span class="metric-value">{{ $metric['value'] }}</span>
                @if ($metric['delta'])
                    <div class="metric-delta">{{ $metric['delta']['text'] }} so với kỳ trước</div>
                @endif
            </li>
        @endforeach
    </ul>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem;">
        <section>
            <h2>Dịch vụ được đặt nhiều nhất</h2>
            <ol class="ranked-list">
                @forelse ($topServices as $item)
                    <li><span>{{ $item->label }}</span> <strong>{{ $item->value }} lượt</strong></li>
                @empty
                    <li>Chưa có dữ liệu.</li>
                @endforelse
            </ol>
        </section>

        <section>
            <h2>Barber đông khách nhất</h2>
            <ol class="ranked-list">
                @forelse ($topBarbers as $item)
                    <li><span>{{ $item->label }}</span> <strong>{{ $item->value }} lượt</strong></li>
                @empty
                    <li>Chưa có dữ liệu.</li>
                @endforelse
            </ol>
        </section>
    </div>

    <section>
        <h2>Khung giờ đặt lịch phổ biến</h2>
        <ul class="ranked-list">
            @foreach ($hourDistribution as $slot)
                <li><span>{{ $slot->label }}</span> <strong>{{ $slot->total }} lượt</strong></li>
            @endforeach
        </ul>
    </section>

    <section>
        <h2>Lịch hẹn sắp tới</h2>
        <table class="data-table w-full bg-white rounded-lg overflow-hidden mb-4">
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
                        <td><span class="status-pill {{ $booking->status }}">{{ $booking->status }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="6">Không có lịch hẹn sắp tới.</td></tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('admin.bookings.index') }}">Xem toàn bộ lịch hẹn &rarr;</a>
        <p><a href="{{ route('admin.barbers.index') }}">Quản lý Barber &rarr;</a></p>
        <p><a href="{{ route('admin.announcements.index') }}">Đăng Trạng thái &amp; Sự kiện &rarr;</a></p>
    </section>

@endsection