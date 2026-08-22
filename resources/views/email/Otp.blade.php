<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <div>
        <h2>Xác thực tài khoản Barbershop</h2>
        <p>Xin chào {{ $userName ?? '' }},</p>
        <p>Bạn vừa yêu cầu mã OTP để xác thực. Đây là mã của bạn:</p>
        <p><strong style="font-size:28px;letter-spacing:4px;">{{ $otp }}</strong></p>
        <p>Mã có hiệu lực trong 5 phút. Vui lòng không chia sẻ mã này với bất kỳ ai.</p>
        <p>Trân trọng,<br>Đội ngũ Barbershop</p>
    </div>
</body>
</html> 