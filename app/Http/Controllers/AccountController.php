<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Trang "Tài khoản của tôi": hiển thị lịch sử đặt lịch của khách hàng đang đăng nhập
     * (bao gồm cả lịch đặt lúc chưa đăng nhập nếu trùng số điện thoại).
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $bookings = $user->bookings()
            ->with(['service', 'barber'])
            ->when($user->phone, function ($query) use ($user) {
                $query->orWhere(function ($phoneQuery) use ($user) {
                    $phoneQuery->where('customer_phone', $user->phone)
                        ->whereNull('user_id');
                });
            })
            ->orderByDesc('booking_date')
            ->get();

        return view('account.index', [
            'bookings' => $bookings,
        ]);
    }
}