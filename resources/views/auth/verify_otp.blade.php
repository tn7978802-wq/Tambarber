@extends('layouts.app')

@section('title', 'Xác thực OTP - Barbershop')

@section('content')

    <h1>Xác thực OTP</h1>

    <p>Vui lòng nhập mã 6 số chúng tôi vừa gửi đến email của bạn.</p>
    <p>Thời gian còn lại: <span id="countdown">05:00</span></p>

    <form action="{{ route('otp.verify') }}" method="POST">
        @csrf
        <label>Mã OTP:
            <input type="text" name="otp" maxlength="6" required autofocus>
        </label>
        <br>
        <button type="submit">Xác thực</button>
    </form>

    <p>Chưa nhận được mã? <a href="{{ route('otp.send') }}">Gửi lại OTP</a></p>

    <script>
        (function () {
            var expiresAt = {{ $expiresAt }};
            var el = document.getElementById('countdown');

            function tick() {
                var now = Math.floor(Date.now() / 1000);
                var left = expiresAt - now;

                if (left <= 0) {
                    el.textContent = '00:00';
                    return;
                }

                var m = Math.floor(left / 60).toString().padStart(2, '0');
                var s = (left % 60).toString().padStart(2, '0');
                el.textContent = m + ':' + s;
                setTimeout(tick, 1000);
            }

            tick();
        })();
    </script>

@endsection