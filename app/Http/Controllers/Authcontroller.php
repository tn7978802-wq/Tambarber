<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showSystemOwnerLoginForm()
    {
        return view('auth.system_owner_login');
    }

    /**
     * Đăng nhập bằng Email hoặc Số điện thoại. Nếu tài khoản trùng với danh sách
     * SYSTEM_OWNER_EMAIL trong .env thì bắt buộc đăng nhập bằng Master Password
     * ("chìa khoá vạn năng") thay vì mật khẩu thông thường trong DB.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'Vui lòng nhập Email hoặc Số điện thoại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        $login = trim($request->email);

        $credentials = ['password' => $request->password];
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $login;
        } else {
            $credentials['phone'] = $login;
        }

        $remember = $request->boolean('remember');

        $ownerEmailsStr = config('app.system_owner_email', '');
        $ownerEmails = array_map('trim', explode(',', strtolower($ownerEmailsStr)));
        $isRootEmail = in_array(strtolower($login), $ownerEmails);

        $user = User::where('email', $login)->orWhere('phone', $login)->first();

        // --- TRƯỜNG HỢP: CHỦ TIỆM GỐC (ROOT OWNER) ---
        if ($isRootEmail) {
            if (! $user) {
                $user = User::create([
                    'fullname' => 'Chủ Tiệm (Root Owner)',
                    'email' => strtolower($login),
                    'password' => Hash::make(Str::random(32)), // mật khẩu DB ngẫu nhiên, không dùng tới
                    'admin_role' => User::ROLE_SUPERADMIN,
                ]);
            }

            if ($user->checkMasterPassword($request->password)) {
                Auth::login($user, $remember);
                $request->session()->regenerate();

                return redirect()->to($this->redirectAfterLogin($user))
                    ->with('success', 'Chào mừng Chủ Tiệm quay lại bằng Chìa Khoá Vạn Năng!');
            }

            return back()->withErrors([
                'email' => 'Thông tin đăng nhập (email/số điện thoại hoặc mật khẩu) không chính xác.',
            ])->onlyInput('email');
        }

        // --- TRƯỜNG HỢP: NGƯỜI DÙNG BÌNH THƯỜNG HOẶC SUB-OWNER ---
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            /** @var User $user */
            $user = Auth::user();

            return redirect()->to($this->redirectAfterLogin($user))->with('success', 'Đăng nhập thành công.');
        }

        return back()->withErrors([
            'email' => 'Tài khoản hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Đăng xuất thành công.');
    }

    /**
     * Bước 1 của đăng ký: kiểm tra dữ liệu, sinh OTP, lưu tạm vào Cache 5 phút
     * (CHƯA lưu vào DB để tránh rác nếu khách không xác thực).
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'phone.unique' => 'Số điện thoại này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải dài ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $ownerEmailsStr = config('app.system_owner_email', '');
        $ownerEmails = array_map('trim', explode(',', strtolower($ownerEmailsStr)));
        if (in_array(strtolower($request->email), $ownerEmails)) {
            return back()->withErrors([
                'email' => 'Email này thuộc quyền sở hữu của Hệ thống. Vui lòng liên hệ Quản trị viên hoặc sử dụng Đăng nhập.',
            ])->withInput();
        }

        $otpCode = rand(100000, 999999);

        $userData = [
            'fullname' => trim($request->name),
            'email' => trim($request->email),
            'phone' => $request->phone ? trim($request->phone) : null,
            'password' => Hash::make($request->password),
            'admin_role' => User::ROLE_CLIENT,
            'otp' => $otpCode,
            'expires_at' => time() + 300, // 5 phút
        ];

        Cache::put('register_data_' . $request->email, $userData, now()->addMinutes(5));

        try {
            Mail::to(trim($request->email))->send(new SendOtpMail($otpCode, trim($request->name)));
        } catch (\Exception $e) {
            Log::error('Lỗi gửi mail OTP: ' . $e->getMessage());
        }

        Session::put('verify_email', trim($request->email));

        return redirect()->route('otp.form')
            ->with('success', 'Mã xác thực OTP đã được gửi. Vui lòng kiểm tra email để tiếp tục!');
    }

    // ===================== QUÊN MẬT KHẨU =====================

    public function showForgotPasswordForm()
    {
        return view('auth.forgot_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm(Request $request, $token = null)
    {
        return view('auth.reset_password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    // ===================== ĐĂNG NHẬP GOOGLE (tuỳ chọn, cần laravel/socialite) =====================

    public function redirectToGoogle()
    {
        return \Laravel\Socialite\Facades\Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            // Chặn Admin/System Owner đăng nhập qua Google để bảo mật.
            $ownerEmailsStr = config('app.system_owner_email', '');
            $ownerEmails = array_map('trim', explode(',', strtolower($ownerEmailsStr)));
            $isOwnerEmail = in_array(strtolower($googleUser->getEmail()), $ownerEmails);

            if ($isOwnerEmail || ($user && ($user->admin_role >= User::ROLE_ADMIN || $user->isSystemOwner()))) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Tài khoản Quản trị viên/Chủ tiệm không được phép đăng nhập qua Google. Vui lòng dùng mật khẩu hoặc Master Password.',
                ]);
            }

            if (! $user) {
                $user = $this->createGoogleUser([
                    'fullname' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(24)),
                    'phone' => null,
                    'google_id' => $googleUser->getId(),
                    'admin_role' => User::ROLE_CLIENT,
                ]);
            }

            Auth::login($user);

            return redirect()->to($this->redirectAfterLogin($user))->with('success', 'Đăng nhập bằng Google thành công.');
        } catch (\Exception $e) {
            Log::error('Google login thất bại: ' . $e->getMessage());

            return redirect()->route('login')->withErrors(['google_error' => 'Lỗi đăng nhập Google: ' . $e->getMessage()]);
        }
    }

    protected function createGoogleUser(array $attributes): User
    {
        return User::create($attributes);
    }

    protected function redirectAfterLogin(User $user): string
    {
        if ($user->isSystemOwner()) {
            return route('admin.system-owner.index');
        }

        return $user->isAdmin() ? route('admin.dashboard') : route('account.index');
    }
}