<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin nhắn liên hệ mới</title>
</head>
<body style="margin:0; padding:0; background:#f7f3ed; font-family:Arial, Helvetica, sans-serif; color:#20170f;">
    <div style="max-width:640px; margin:32px auto; background:#ffffff; border:1px solid #e9dcc0; border-radius:10px; overflow:hidden;">
        <div style="background:linear-gradient(90deg, #171008 0%, #8a641d 100%); padding:20px 24px; color:#f4ecd8;">
            <h2 style="margin:0; font-size:24px; letter-spacing:0.04em;">Tin nhắn liên hệ mới</h2>
        </div>
        <div style="padding:24px;">
            <p style="margin:0 0 16px; font-size:15px; line-height:1.6;">
                Có một khách hàng vừa gửi câu hỏi / góp ý qua form liên hệ trên website.
            </p>

            <table role="presentation" cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; font-size:14px;">
                <tr>
                    <td style="padding:8px 0; width:120px; font-weight:bold; color:#3a2d1f;">Họ tên</td>
                    <td style="padding:8px 0; color:#20170f;">{{ $name }}</td>
                </tr>
                <tr>
                    <td style="padding:8px 0; width:120px; font-weight:bold; color:#3a2d1f;">Email</td>
                    <td style="padding:8px 0; color:#20170f;">{{ $email }}</td>
                </tr>
                <tr>
                    <td style="padding:8px 0; width:120px; font-weight:bold; color:#3a2d1f;">Số điện thoại</td>
                    <td style="padding:8px 0; color:#20170f;">{{ $phone }}</td>
                </tr>
                <tr>
                    <td style="padding:8px 0; width:120px; font-weight:bold; color:#3a2d1f; vertical-align:top;">Nội dung</td>
                    <td style="padding:8px 0; color:#20170f; line-height:1.7; white-space:pre-line;">{{ $message }}</td>
                </tr>
            </table>

            <div style="margin-top:24px; padding-top:16px; border-top:1px solid #e9dcc0; font-size:12px; color:#6b5847;">
                Gửi từ hệ thống TâmBarbershop Admin.
            </div>
        </div>
    </div>
</body>
</html>
