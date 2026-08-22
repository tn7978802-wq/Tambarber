<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    // Khung giờ làm việc trong ngày, có thể chuyển sang cấu hình DB sau này.
    private const TIME_SLOTS = [
        '08:00', '09:00', '10:00', '11:00',
        '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00',
    ];

    /**
     * Hiển thị form đặt lịch: chọn dịch vụ -> barber -> ngày -> giờ.
     */
    public function create(Request $request): View
    {
        $services = Service::active()->orderBy('name')->get();
        $barbers = Barber::where('is_active', true)->orderBy('name')->get();

        $selectedServiceId = $request->query('service_id');
        $selectedBarberId = $request->query('barber_id');
        $selectedDate = $request->query('date', now()->toDateString());

        $bookedSlots = [];

        if ($selectedBarberId) {
            $bookedSlots = Booking::where('barber_id', $selectedBarberId)
                ->whereDate('booking_date', $selectedDate)
                ->whereIn('status', ['pending', 'confirmed'])
                ->pluck('booking_time')
                ->map(fn ($time) => substr((string) $time, 0, 5))
                ->all();
        }

        return view('booking.create', [
            'services' => $services,
            'barbers' => $barbers,
            'timeSlots' => self::TIME_SLOTS,
            'bookedSlots' => $bookedSlots,
            'selectedServiceId' => $selectedServiceId,
            'selectedBarberId' => $selectedBarberId,
            'selectedDate' => $selectedDate,
        ]);
    }

    /**
     * Lưu lịch hẹn: kiểm tra trùng khung giờ với barber đã chọn rồi tạo booking mới.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'min:3', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'service_id' => ['required', 'exists:services,id'],
            'barber_id' => ['required', 'exists:barbers,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'string'],
            'note' => ['nullable', 'string', 'max:500'],
        ], [
            'customer_name.required' => 'Vui lòng nhập họ tên.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'service_id.required' => 'Vui lòng chọn dịch vụ.',
            'barber_id.required' => 'Vui lòng chọn barber.',
            'booking_date.after_or_equal' => 'Ngày đặt lịch không được ở quá khứ.',
        ]);

        try {
            $booking = DB::transaction(function () use ($data) {
                $alreadyBooked = Booking::where('barber_id', $data['barber_id'])
                    ->whereDate('booking_date', $data['booking_date'])
                    ->where('booking_time', $data['booking_time'])
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->lockForUpdate()
                    ->exists();

                if ($alreadyBooked) {
                    throw ValidationException::withMessages([
                        'booking_time' => 'Khung giờ này vừa có khách khác đặt. Vui lòng chọn giờ khác.',
                    ]);
                }

                return Booking::create([
                    'booking_code' => $this->generateUniqueBookingCode(),
                    'customer_name' => $data['customer_name'],
                    'customer_phone' => $data['customer_phone'],
                    'customer_email' => $data['customer_email'] ?? null,
                    'service_id' => $data['service_id'],
                    'barber_id' => $data['barber_id'],
                    'booking_date' => $data['booking_date'],
                    'booking_time' => $data['booking_time'],
                    'note' => $data['note'] ?? null,
                    'status' => 'pending',
                ]);
            });
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput();
        }

        return redirect()
            ->route('booking.success', ['code' => $booking->booking_code])
            ->with('success', 'Đặt lịch thành công! Vui lòng chờ tiệm xác nhận qua điện thoại.');
    }

    /**
     * Trang xác nhận sau khi đặt lịch thành công.
     */
    public function success(string $code): View
    {
        $booking = Booking::with(['service', 'barber'])
            ->where('booking_code', $code)
            ->firstOrFail();

        return view('booking.success', [
            'booking' => $booking,
        ]);
    }

    /**
     * Sinh mã đặt lịch duy nhất, ví dụ BAR-AB12CD34.
     */
    private function generateUniqueBookingCode(): string
    {
        do {
            $code = 'BAR-' . strtoupper(Str::random(8));
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }
}