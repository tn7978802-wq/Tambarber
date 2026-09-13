<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\WalkinSession;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RevenueReportController extends Controller
{
    /**
     * Bảng doanh thu theo Barber, đặt bên dưới phần Tổng quan.
     * Gộp cả khách vãng lai (source=walkin) và khách đặt lịch
     * online đã bấm "Hoàn thành" (source=online), sắp xếp theo
     * thời gian (giờ + ngày), không theo tên barber.
     */
    public function index(Request $request)
    {
        $period   = $request->get('period', 'day'); // day | month | year
        $date     = $request->get('date', now()->format('Y-m-d'));
        $barberId = $request->get('barber_id', 'all');

        $carbon = Carbon::parse($date);

        $query = WalkinSession::with(['barber', 'services'])
            ->completed()
            ->forBarber($barberId);

        match ($period) {
            'month' => $query->forMonth($carbon->year, $carbon->month),
            'year'  => $query->forYear($carbon->year),
            default => $query->forDay($carbon->toDateString()),
        };

        $rows  = $query->orderBy('started_at')->get();
        $total = $rows->sum('total_price');

        $barbers = Barber::orderBy('name')->get();

        return view('admin.revenue.index', compact('rows', 'total', 'barbers', 'period', 'date', 'barberId'));
    }
}
