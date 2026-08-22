<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{
    /**
     * Gửi lại mã OTP khi đang ở trang xác nhận (reset thời gian 5 phút mới).
     */
    public function sendOtp(Request $request)
    {
        $email = Session::get('verify_email');

        if (! $email || ! Cache::has('register_data_' . $email)) {
            return redirect()->route('register')->with('error', 'Phiên đăng ký đã hết hạn hoặc không tồn tại. Vui lòng đăng ký lại.');
        }

        $userData = Cache::get('register_data_' . $email);
        $newOtpCode = rand(100000, 999999);
        $userData['otp'] = $newOtpCode;
        $userData['expires_at'] = time() + 300;

        Cache::put('register_data_' . $email, $userData, now()->addMinutes(5));

        try {
            Mail::send('emails.otp', ['otp' => $newOtpCode, 'userName' => $userData['fullname']], function ($message) use ($email) {
                $message->to($email)->subject('Mã Xác Thực OTP Của Bạn');
            });
        } catch (\Exception $e) {
            // bỏ qua lỗi mail, khách vẫn có thể xin gửi lại sau
        }

        return redirect()->route('otp.form')->with('success', 'Đã gửi lại mã OTP mới. Vui lòng kiểm tra email của bạn!');
    }

    /**
     * Hiển thị form nhập OTP kèm đồng hồ đếm ngược 5 phút.
     */
    public function showVerifyForm()
    {
        $email = Session::get('verify_email');

        if (! $email || ! Cache::has('register_data_' . $email)) {
            return redirect()->route('register')->with('error', 'Phiên xác thực đã hết hạn. Vui lòng đăng ký lại từ đầu.');
        }

        $userData = Cache::get('register_data_' . $email);
        $expiresAt = $userData['expires_at'] ?? (time() + 300);

        return view('auth.verify-otp', compact('expiresAt'));
    }

    /**
     * Kiểm tra OTP người dùng nhập, nếu đúng thì mới thực sự tạo tài khoản trong DB.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $email = Session::get('verify_email');

        if (! $email) {
            return redirect()->route('register')->with('error', 'Không tìm thấy phiên xác thực. Vui lòng đăng ký lại.');
        }

        $userData = Cache::get('register_data_' . $email);

        if (! $userData) {
            Session::forget('verify_email');

            return redirect()->route('register')->with('error', 'Mã OTP của bạn đã hết hạn (quá 5 phút). Vui lòng đăng ký lại.');
        }

        if ((string) $request->otp === (string) $userData['otp']) {
            if (User::where('email', $userData['email'])->exists()) {
                Cache::forget('register_data_' . $email);
                Session::forget('verify_email');

                return redirect()->route('login')->with('error', 'Email này đã được đăng ký thành công trước đó.');
            }

            $user = User::create([
                'fullname' => $userData['fullname'],
                'email' => $userData['email'],
                'phone' => $userData['phone'],
                'password' => $userData['password'],
                'admin_role' => $userData['admin_role'] ?? User::ROLE_CLIENT,
            ]);

            Cache::forget('register_data_' . $email);
            Session::forget('verify_email');

            Auth::login($user);

            return redirect()->to($user->isAdmin() ? route('admin.dashboard') : route('account.index'))
                ->with('success', 'Đăng ký và xác thực thành công! Chào mừng bạn đến với Barbershop.');
        }

        return back()->with('error', 'Mã OTP không chính xác. Vui lòng kiểm tra lại.');
    }
}