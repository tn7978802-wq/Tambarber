<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Người dùng mới đăng ký</title>
</head>
<body style="margin:0; padding:40px 0; background-color:#0d0d0d; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; -webkit-font-smoothing:antialiased;">

    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px; margin:0 auto; background-color:#181512; border-radius:12px; border:1px solid #33281c; box-shadow:0 10px 30px rgba(0,0,0,0.5); overflow:hidden;">
        
        <!-- HEADER -->
        <tr>
            <td style="padding:32px 32px 24px 32px; background:linear-gradient(180deg, #241c13 0%, #181512 100%); text-align:center; border-bottom:1px solid #2e2317;">
                <h1 style="margin:0 0 8px 0; color:#d4a359; font-size:20px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px;">
                    TÂM BARBERSHOP
                </h1>
                <div style="width:40px; height:2px; background-color:#d4a359; margin:0 auto 16px auto;"></div>
                <h2 style="margin:0; color:#ffffff; font-size:18px; font-weight:600;">
                    Thông Báo: Người Dùng Mới
                </h2>
            </td>
        </tr>

        <!-- CONTENT -->
        <tr>
            <td style="padding:28px 32px;">
                <p style="margin:0 0 20px 0; color:#a69b8d; font-size:14px; line-height:1.6;">
                    Hệ thống vừa ghi nhận một tài khoản mới đăng ký và hoàn tất xác thực OTP thành công.
                </p>

                <!-- INFO BOX -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#0f0d0b; border:1px solid #282016; border-radius:8px; margin-bottom:24px;">
                    <tr>
                        <td style="padding:16px 20px; border-bottom:1px solid #1c1711;">
                            <span style="color:#7a6e60; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Họ và tên</span><br>
                            <strong style="color:#ffffff; font-size:15px; display:inline-block; margin-top:4px;">{{ $fullname }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 20px; border-bottom:1px solid #1c1711;">
                            <span style="color:#7a6e60; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Địa chỉ Email</span><br>
                            <strong style="color:#d4a359; font-size:15px; display:inline-block; margin-top:4px;">{{ $email }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 20px; border-bottom:1px solid #1c1711;">
                            <span style="color:#7a6e60; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Số điện thoại</span><br>
                            <strong style="color:#ffffff; font-size:15px; display:inline-block; margin-top:4px;">{{ $phone ?: 'Không cung cấp' }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 20px;">
                            <span style="color:#7a6e60; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Trạng thái tài khoản</span><br>
                            <span style="display:inline-block; margin-top:6px; padding:4px 10px; background-color:rgba(46, 125, 50, 0.2); border:1px solid #2e7d32; color:#81c784; border-radius:4px; font-size:12px; font-weight:600;">
                                ● ĐÃ XÁC THỰC OTP
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- FOOTER -->
        <tr>
            <td style="padding:20px 32px; background-color:#100e0c; border-top:1px solid #231b12; text-align:center;">
                <p style="margin:0; color:#5c5245; font-size:12px; line-height:1.5;">
                    Email này được gửi tự động từ hệ thống quản trị Tâm Barbershop Panel.<br>
                    © {{ date('Y') }} Tâm Barbershop. All rights reserved.
                </p>
            </td>
        </tr>

    </table>

</body>
</html>