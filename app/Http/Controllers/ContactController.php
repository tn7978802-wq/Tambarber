<?php

namespace App\Http\Controllers;

use App\Mail\ContactSubmittedMail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Nhận góp ý / câu hỏi từ khách hàng qua form liên hệ.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->withErrors([
                'login' => 'Bạn cần đăng nhập trước khi gửi góp ý.',
            ]);
        }

        $data = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:1000'],
        ], [
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'message.required' => 'Vui lòng nhập nội dung liên hệ.',
        ]);

        $name = $user->fullname ?? $user->name ?? 'Khách hàng';
        $email = $user->email;
        $phone = $data['phone'];
        $message = $data['message'];

        $mailRecipient = config('mail.from.address', env('MAIL_FROM_ADDRESS', 'tn7410311@gmail.com'));

        try {
            DB::table('contact_messages')->insert([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'message' => $message,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $mail = new ContactSubmittedMail(
                $name,
                $email,
                $phone,
                $message
            );

            $mail->replyTo($email);

            Mail::to($mailRecipient)->send($mail);
        } catch (\Throwable $exception) {
            Log::warning('Không thể lưu hoặc gửi tin nhắn liên hệ: ' . $exception->getMessage());
        }

        return back()->with('success', 'Cảm ơn bạn đã liên hệ! Tiệm sẽ phản hồi sớm nhất có thể.');
    }
}