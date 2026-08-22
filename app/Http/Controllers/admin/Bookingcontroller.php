<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Danh sách lịch hẹn, hỗ trợ lọc theo trạng thái và ngày.
     */
    public function index(Request $request): View
    {
        $query = Booking::with(['service', 'barber'])->latest('booking_date');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->date);
        }

        $bookings = $query->paginate(20)->withQueryString();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'filters' => $request->only(['status', 'date']),
        ]);
    }

    /**
     * Xác nhận lịch hẹn (pending -> confirmed).
     */
    public function confirm(Booking $booking): RedirectResponse
    {
        $booking->update(['status' => 'confirmed']);

        return back()->with('success', "Đã xác nhận lịch hẹn {$booking->booking_code}.");
    }

    /**
     * Đánh dấu đã hoàn thành sau khi khách cắt xong.
     */
    public function complete(Booking $booking): RedirectResponse
    {
        $booking->update(['status' => 'completed']);

        return back()->with('success', "Đã hoàn thành lịch hẹn {$booking->booking_code}.");
    }

    /**
     * Huỷ lịch hẹn.
     */
    public function cancel(Booking $booking): RedirectResponse
    {
        $booking->update(['status' => 'cancelled']);

        return back()->with('success', "Đã huỷ lịch hẹn {$booking->booking_code}.");
    }
}