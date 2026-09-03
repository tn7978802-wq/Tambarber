@extends('layouts.app')

@section('title', 'Đặt lịch - Barbershop')

@section('content')

    <span class="section-eyebrow">5 bước nhanh gọn</span>
    <h1>Đặt lịch cắt tóc</h1>
    <div class="pole-divider small" style="margin-left:0;"></div>

    {{-- Form phụ (GET): chọn barber + ngày để tải lại danh sách khung giờ còn trống. --}}
    <form action="{{ route('booking.create') }}" method="GET">
        <fieldset>
            <legend><span class="stage-badge" style="width:1.9rem;height:1.9rem;font-size:.95rem;display:inline-flex;vertical-align:middle;margin-right:.4rem;">01</span>Chọn Barber &amp; Ngày (để xem giờ còn trống)</legend>
            <div style="display:flex; gap:1rem; flex-wrap:wrap;">
                <select name="barber_id" onchange="this.form.submit()" style="flex:1; min-width:220px;">
                    <option value="">-- Chọn barber --</option>
                    @foreach ($barbers as $barber)
                        <option value="{{ $barber->id }}" @selected((string) $selectedBarberId === (string) $barber->id)>
                            {{ $barber->name }} ({{ $barber->title }})
                        </option>
                    @endforeach
                </select>
                <input type="date" name="date" value="{{ $selectedDate }}" min="{{ now()->toDateString() }}" onchange="this.form.submit()" style="flex:1; min-width:180px;">
                <input type="hidden" name="service_id" value="{{ $selectedServiceId }}">
                <noscript><button type="submit" class="btn btn-outline">Cập nhật</button></noscript>
            </div>
        </fieldset>
    </form>

    {{-- Form chính (POST): xác nhận đặt lịch. --}}
    <form action="{{ route('booking.store') }}" method="POST">
        @csrf

        <fieldset>
            <legend><span class="stage-badge" style="width:1.9rem;height:1.9rem;font-size:.95rem;display:inline-flex;vertical-align:middle;margin-right:.4rem;">02</span>Chọn dịch vụ</legend>
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
            <legend><span class="stage-badge" style="width:1.9rem;height:1.9rem;font-size:.95rem;display:inline-flex;vertical-align:middle;margin-right:.4rem;">03</span>Barber &amp; ngày đã chọn</legend>
            <input type="hidden" name="barber_id" value="{{ $selectedBarberId }}">
            <input type="hidden" name="booking_date" value="{{ $selectedDate }}">
            <p>
                Barber: <strong class="eyebrow-gold">{{ optional($barbers->firstWhere('id', (int) $selectedBarberId))->name ?? 'Chưa chọn (vui lòng chọn ở bước 1)' }}</strong>
                &middot; Ngày: <strong class="eyebrow-gold">{{ $selectedDate }}</strong>
            </p>
        </fieldset>

        <fieldset>
            <legend><span class="stage-badge" style="width:1.9rem;height:1.9rem;font-size:.95rem;display:inline-flex;vertical-align:middle;margin-right:.4rem;">04</span>Chọn giờ</legend>
            @foreach ($timeSlots as $slot)
                @php $isTaken = in_array($slot, $bookedSlots, true); @endphp
                <label class="radio-slot">
                    <input type="radio" name="booking_time" value="{{ $slot }}" @disabled($isTaken) required>
                    <span>{{ $slot }} @if($isTaken) (đã kín) @endif</span>
                </label>
            @endforeach
        </fieldset>

        <fieldset>
            <legend><span class="stage-badge" style="width:1.9rem;height:1.9rem;font-size:.95rem;display:inline-flex;vertical-align:middle;margin-right:.4rem;">05</span>Thông tin liên hệ</legend>
            <label>Họ tên
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required>
            </label>
            <label>Số điện thoại
                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required>
            </label>
            <label>Email (không bắt buộc)
                <input type="email" name="customer_email" value="{{ old('customer_email') }}">
            </label>
            <label>Ghi chú
                <textarea name="note">{{ old('note') }}</textarea>
            </label>
        </fieldset>

        <button type="submit" class="btn btn-gold btn-block">Xác nhận đặt lịch</button>
    </form>

@endsection