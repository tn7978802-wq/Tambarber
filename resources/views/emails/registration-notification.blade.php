<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Người dùng mới đăng ký</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:30px;">

    <div style="
        max-width:600px;
        margin:auto;
        background:#ffffff;
        padding:30px;
        border-radius:10px;
        box-shadow:0 2px 10px rgba(0,0,0,0.1);
    ">

        <h2 style="color:#8a641d;">
            Có người dùng mới đăng ký
        </h2>

        <p>
            Một tài khoản vừa được đăng ký và xác thực OTP thành công.
        </p>

        <hr>

        <p>
            <strong>Họ tên:</strong>
            {{ $fullname }}
        </p>

        <p>
            <strong>Email:</strong>
            {{ $email }}
        </p>

        <p>
            <strong>Số điện thoại:</strong>
            {{ $phone ?: 'Không cung cấp' }}
        </p>

        <hr>

        <p>
            <strong>Trạng thái:</strong>
            <span style="color:green;">Đã xác thực OTP</span>
        </p>

        <p style="color:#777;">
            Email này được gửi tự động từ hệ thống Tâm Barbershop.
        </p>

    </div>

</body>
</html>