<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact');
    }

    /**
     * Nhận góp ý / câu hỏi từ khách hàng qua form liên hệ.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:1000'],
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'message.required' => 'Vui lòng nhập nội dung liên hệ.',
        ]);

        try {
            DB::table('contact_messages')->insert([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'message' => $data['message'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Không thể lưu tin nhắn liên hệ: ' . $exception->getMessage());
        }

        return back()->with('success', 'Cảm ơn bạn đã liên hệ! Tiệm sẽ phản hồi sớm nhất có thể.');
    }
}