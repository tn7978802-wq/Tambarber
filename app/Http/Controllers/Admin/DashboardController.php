<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $range = in_array($request->query('range'), ['day', 'week', 'month'], true)
            ? $request->query('range')
            : 'day';

        [$currentStart, $currentEnd, $previousStart, $previousEnd] = $this->resolveRangeWindow($range);

        $summary = $this->buildSummaryMetrics($currentStart, $currentEnd, $previousStart, $previousEnd);
        $topServices = $this->topServices($currentStart, $currentEnd);
        $topBarbers = $this->topBarbers($currentStart, $currentEnd);
        $hourDistribution = $this->bookingHourDistribution($currentStart, $currentEnd);
        $upcomingBookings = $this->upcomingBookings();

        return view('admin.home', [
            'dashboardFilter' => $range,
            'dashboardFilterLabel' => $this->rangeLabel($range),
            'summaryMetrics' => $summary,
            'topServices' => $topServices,
            'topBarbers' => $topBarbers,
            'hourDistribution' => $hourDistribution,
            'upcomingBookings' => $upcomingBookings,
        ]);
    }

    private function resolveRangeWindow(string $range): array
    {
        $now = now();

        return match ($range) {
            'week' => [
                $now->copy()->startOfWeek(), $now->copy()->endOfWeek(),
                $now->copy()->subWeek()->startOfWeek(), $now->copy()->subWeek()->endOfWeek(),
            ],
            'month' => [
                $now->copy()->startOfMonth(), $now->copy()->endOfMonth(),
                $now->copy()->subMonthNoOverflow()->startOfMonth(), $now->copy()->subMonthNoOverflow()->endOfMonth(),
            ],
            default => [
                $now->copy()->startOfDay(), $now->copy()->endOfDay(),
                $now->copy()->subDay()->startOfDay(), $now->copy()->subDay()->endOfDay(),
            ],
        };
    }

    private function buildSummaryMetrics(Carbon $currentStart, Carbon $currentEnd, Carbon $previousStart, Carbon $previousEnd): array
    {
        $currentRevenue = $this->bookingRevenue($currentStart, $currentEnd);
        $previousRevenue = $this->bookingRevenue($previousStart, $previousEnd);

        $currentBookings = $this->bookingCount($currentStart, $currentEnd);
        $previousBookings = $this->bookingCount($previousStart, $previousEnd);

        $currentCustomers = $this->newCustomers($currentStart, $currentEnd);
        $previousCustomers = $this->newCustomers($previousStart, $previousEnd);

        $currentActiveBarbers = (int) DB::table('barbers')->where('is_active', true)->count();

        return [
            [
                'label' => 'Doanh thu (lịch đã hoàn thành)',
                'value' => number_format($currentRevenue, 0, ',', '.') . 'đ',
                'delta' => $this->deltaPayload($currentRevenue, $previousRevenue),
            ],
            [
                'label' => 'Lịch hẹn',
                'value' => number_format($currentBookings),
                'delta' => $this->deltaPayload($currentBookings, $previousBookings),
            ],
            [
                'label' => 'Khách hàng mới',
                'value' => number_format($currentCustomers),
                'delta' => $this->deltaPayload($currentCustomers, $previousCustomers),
            ],
            [
                'label' => 'Barber đang hoạt động',
                'value' => number_format($currentActiveBarbers),
                'delta' => null,
            ],
        ];
    }

    private function bookingRevenue(Carbon $start, Carbon $end): float
    {
        return (float) DB::table('bookings')
            ->join('services', 'services.id', '=', 'bookings.service_id')
            ->where('bookings.status', 'completed')
            ->whereBetween('bookings.booking_date', [$start->toDateString(), $end->toDateString()])
            ->sum('services.price');
    }

    private function bookingCount(Carbon $start, Carbon $end): int
    {
        return (int) DB::table('bookings')
            ->whereBetween('booking_date', [$start->toDateString(), $end->toDateString()])
            ->count();
    }

    private function newCustomers(Carbon $start, Carbon $end): int
    {
        return (int) DB::table('users')
            ->where('admin_role', \App\Models\User::ROLE_CLIENT)
            ->whereBetween('created_at', [$start, $end])
            ->count();
    }

    private function topServices(Carbon $start, Carbon $end): Collection
    {
        $rows = DB::table('bookings')
            ->join('services', 'services.id', '=', 'bookings.service_id')
            ->whereBetween('bookings.booking_date', [$start->toDateString(), $end->toDateString()])
            ->groupBy('services.name')
            ->orderByDesc(DB::raw('COUNT(bookings.id)'))
            ->selectRaw('services.name, COUNT(bookings.id) as total')
            ->limit(5)
            ->get();

        return $this->normalizeTopList($rows);
    }

    private function topBarbers(Carbon $start, Carbon $end): Collection
    {
        $rows = DB::table('bookings')
            ->join('barbers', 'barbers.id', '=', 'bookings.barber_id')
            ->whereBetween('bookings.booking_date', [$start->toDateString(), $end->toDateString()])
            ->groupBy('barbers.name')
            ->orderByDesc(DB::raw('COUNT(bookings.id)'))
            ->selectRaw('barbers.name, COUNT(bookings.id) as total')
            ->limit(5)
            ->get();

        return $this->normalizeTopList($rows);
    }

    private function normalizeTopList(Collection $rows): Collection
    {
        $max = max((int) ($rows->max('total') ?? 0), 1);

        return $rows->values()->map(function ($row, $index) use ($max) {
            return (object) [
                'rank' => $index + 1,
                'label' => $row->name,
                'value' => (int) $row->total,
                'width' => round(((int) $row->total / $max) * 100, 1),
            ];
        });
    }

    private function bookingHourDistribution(Carbon $start, Carbon $end): Collection
    {
        $rows = DB::table('bookings')
            ->whereBetween('booking_date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('booking_time, COUNT(*) as total')
            ->groupBy('booking_time')
            ->orderBy('booking_time')
            ->get()
            ->keyBy('booking_time');

        $max = max((int) ($rows->max('total') ?? 0), 1);

        $slots = ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'];

        return collect($slots)->map(function ($slot) use ($rows, $max) {
            $total = (int) ($rows[$slot]->total ?? 0);

            return (object) [
                'label' => $slot,
                'total' => $total,
                'width' => max(round(($total / $max) * 100, 1), $total > 0 ? 10 : 0),
            ];
        });
    }

    private function upcomingBookings(): Collection
    {
        return DB::table('bookings')
            ->join('services', 'services.id', '=', 'bookings.service_id')
            ->join('barbers', 'barbers.id', '=', 'bookings.barber_id')
            ->whereIn('bookings.status', ['pending', 'confirmed'])
            ->where('bookings.booking_date', '>=', now()->toDateString())
            ->orderBy('bookings.booking_date')
            ->orderBy('bookings.booking_time')
            ->select([
                'bookings.booking_code',
                'bookings.customer_name',
                'bookings.booking_date',
                'bookings.booking_time',
                'bookings.status',
                'services.name as service_name',
                'barbers.name as barber_name',
            ])
            ->limit(10)
            ->get();
    }

    private function deltaPayload(float|int $current, float|int $previous): array
    {
        if ((float) $previous === 0.0) {
            if ((float) $current === 0.0) {
                return ['text' => '0%', 'tone' => 'neutral'];
            }

            return ['text' => '+100%', 'tone' => 'up'];
        }

        $delta = round((($current - $previous) / $previous) * 100, 1);

        return [
            'text' => ($delta > 0 ? '+' : '') . number_format($delta, 1) . '%',
            'tone' => $delta > 0 ? 'up' : ($delta < 0 ? 'down' : 'neutral'),
        ];
    }

    private function rangeLabel(string $range): string
    {
        return match ($range) {
            'week' => 'Tuần',
            'month' => 'Tháng',
            default => 'Ngày',
        };
    }
}