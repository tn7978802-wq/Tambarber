<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="margin:0; padding:0; background-color:#0b0805; font-family:'Segoe UI', Arial, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#0b0805; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="480" cellpadding="0" cellspacing="0" style="background-color:#1f160b; border:1px solid #3c2c15; border-radius:6px; overflow:hidden;">
                    <tr>
                        <td style="height:6px; background-image:repeating-linear-gradient(-45deg, #7c1f22 0 10px, #f4ecd8 10px 20px, #171008 20px 30px);"></td>
                    </tr>
                    <tr>
                        <td style="padding:32px 32px 8px;">
                            <p style="margin:0 0 4px; font-size:12px; letter-spacing:2px; text-transform:uppercase; color:#a89a7c;">Tâm Barbershop</p>
                            <h2 style="margin:0 0 16px; color:#f2d788; font-family:Georgia, serif; letter-spacing:1px;">Xác thực tài khoản</h2>
                            <p style="margin:0 0 12px; color:#f4ecd8; font-size:15px;">Xin chào {{ $userName ?? '' }},</p>
                            <p style="margin:0 0 20px; color:#f4ecd8; font-size:15px;">Bạn vừa yêu cầu mã OTP để xác thực. Đây là mã của bạn:</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:0 32px 24px;">
                            <div style="display:inline-block; padding:14px 28px; border:1px solid #8a641d; border-radius:4px; background-color:#251b0e;">
                                <span style="font-size:30px; letter-spacing:8px; font-weight:bold; color:#f2d788;">{{ $otp }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 32px 28px;">
                            <p style="margin:0 0 4px; color:#a89a7c; font-size:13px;">Mã có hiệu lực trong 5 phút. Vui lòng không chia sẻ mã này với bất kỳ ai.</p>
                            <p style="margin:16px 0 0; color:#a89a7c; font-size:13px;">Trân trọng,<br>Đội ngũ Barbershop</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>