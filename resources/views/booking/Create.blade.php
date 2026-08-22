@extends('layouts.app')

@section('title', 'Đặt lịch - Barbershop')

@section('content')

    <h1>Đặt lịch cắt tóc</h1>

    {{-- Form phụ (GET): chọn barber + ngày để tải lại danh sách khung giờ còn trống. --}}
    <form action="{{ route('booking.create') }}" method="GET">
        <fieldset>
            <legend>1. Chọn Barber &amp; Ngày (để xem giờ còn trống)</legend>
            <select name="barber_id" onchange="this.form.submit()">
                <option value="">-- Chọn barber --</option>
                @foreach ($barbers as $barber)
                    <option value="{{ $barber->id }}" @selected((string) $selectedBarberId === (string) $barber->id)>
                        {{ $barber->name }} ({{ $barber->title }})
                    </option>
                @endforeach
            </select>
            <input type="date" name="date" value="{{ $selectedDate }}" min="{{ now()->toDateString() }}" onchange="this.form.submit()">
            <input type="hidden" name="service_id" value="{{ $selectedServiceId }}">
            <noscript><button type="submit">Cập nhật</button></noscript>
        </fieldset>
    </form>

    {{-- Form chính (POST): xác nhận đặt lịch. --}}
    <form action="{{ route('booking.store') }}" method="POST">
        @csrf

        <fieldset>
            <legend>2. Chọn dịch vụ</legend>
            <select name="service_id" required>
                <option value="">-- Chọn dịch vụ --</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}" @selected((string) $selectedServiceId === (string) $service->id)>
                        {{ $service->name }} - {{ number_format((float) $service->price, 0, ',', '.') }}đ
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset>
            <legend>3. Barber &amp; ngày đã chọn</legend>
            <input type="hidden" name="barber_id" value="{{ $selectedBarberId }}">
            <input type="hidden" name="booking_date" value="{{ $selectedDate }}">
            <p>
                Barber: {{ optional($barbers->firstWhere('id', (int) $selectedBarberId))->name ?? 'Chưa chọn (vui lòng chọn ở bước 1)' }}
                &middot; Ngày: {{ $selectedDate }}
            </p>
        </fieldset>

        <fieldset>
            <legend>4. Chọn giờ</legend>
            @foreach ($timeSlots as $slot)
                @php $isTaken = in_array($slot, $bookedSlots, true); @endphp
                <label>
                    <input type="radio" name="booking_time" value="{{ $slot }}" @disabled($isTaken) required>
                    {{ $slot }} @if($isTaken) (đã kín) @endif
                </label>
            @endforeach
        </fieldset>

        <fieldset>
            <legend>5. Thông tin liên hệ</legend>
            <label>Họ tên: <input type="text" name="customer_name" value="{{ old('customer_name') }}" required></label>
            <br>
            <label>Số điện thoại: <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required></label>
            <br>
            <label>Email (không bắt buộc): <input type="email" name="customer_email" value="{{ old('customer_email') }}"></label>
            <br>
            <label>Ghi chú: <textarea name="note">{{ old('note') }}</textarea></label>
        </fieldset>

        <button type="submit">Xác nhận đặt lịch</button>
    </form>

@endsection