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

    public function edit(WalkinSession $walkin)
    {
        $walkin->load(['barber', 'services']);
        $barbers = Barber::orderBy('name')->get();

        return view('admin.revenue.edit', compact('walkin', 'barbers'));
    }

    public function update(Request $request, WalkinSession $walkin)
    {
        $data = $request->validate([
            'barber_id' => ['required', 'exists:barbers,id'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'total_price' => ['required', 'numeric', 'min:0'],
            'started_at' => ['required', 'date'],
        ]);

        $walkin->barber_id = $data['barber_id'];
        $walkin->customer_name = $data['customer_name'];
        $walkin->started_at = $data['started_at'];
        $walkin->total_price = (float) $data['total_price'];
        $walkin->save();

        if ($walkin->services->isNotEmpty()) {
            $serviceCount = $walkin->services->count();
            $basePrice = $serviceCount > 0 ? round($walkin->total_price / $serviceCount, 2) : 0;

            foreach ($walkin->services as $service) {
                $walkin->services()->updateExistingPivot($service->id, ['price' => $basePrice]);
            }
        }

        return redirect()->route('admin.revenue.index')->with('success', 'Đã cập nhật doanh thu của bản ghi này.');
    }

    public function destroy(WalkinSession $walkin)
    {
        $walkin->services()->detach();
        $walkin->delete();

        return back()->with('success', 'Đã xoá bản ghi doanh thu.');
    }
}
