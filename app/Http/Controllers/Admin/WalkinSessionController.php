<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Service;
use App\Models\WalkinSession;
use Illuminate\Http\Request;

class WalkinSessionController extends Controller
{
    /**
     * Trang "Doanh thu khách vãng lai": form bắt đầu phiên mới
     * + danh sách các phiên đang thực hiện.
     */
    public function index()
    {
        $barbers  = Barber::orderBy('name')->get();
        $services = Service::orderBy('name')->get();

        $activeSessions = WalkinSession::with(['barber', 'services'])
            ->where('status', 'in_progress')
            ->orderByDesc('started_at')
            ->get();

        return view('admin.walkin.index', compact('barbers', 'services', 'activeSessions'));
    }

    /**
     * Bấm "Bắt đầu làm": chọn barber + 1 hoặc nhiều dịch vụ.
     * started_at luôn lấy now() từ server, không nhận input từ client.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'barber_id'       => ['required', 'exists:barbers,id'],
            'service_ids'     => ['required', 'array', 'min:1'],
            'service_ids.*'   => ['exists:services,id'],
            'customer_name'   => ['nullable', 'string', 'max:255'],
        ]);

        $services = Service::whereIn('id', $data['service_ids'])->get();

        $session = WalkinSession::create([
            'barber_id'     => $data['barber_id'],
            'source'        => 'walkin',
            'status'        => 'in_progress',
            'customer_name' => $data['customer_name'] ?? null,
            'started_at'    => now(),
            'total_price'   => $services->sum('price'),
            'created_by'    => auth()->id(),
        ]);

        $session->services()->sync(
            $services->mapWithKeys(fn ($s) => [$s->id => ['price' => $s->price]])
        );

        return back()->with(
            'success',
            'Đã bắt đầu làm. Giờ bắt đầu: ' . $session->started_at->format('H:i - d/m/Y')
        );
    }

    /**
     * Bấm "Hoàn thành": chốt completed_at = now(), đưa vào doanh thu.
     */
    public function complete(WalkinSession $walkin)
    {
        abort_unless($walkin->status === 'in_progress', 404);

        $walkin->update([
            'completed_at' => now(),
            'status'       => 'completed',
        ]);

        return back()->with('success', 'Đã hoàn thành. Doanh thu đã được ghi nhận.');
    }

    /**
     * Bấm "Hủy": khách không làm nữa, không tính vào doanh thu.
     */
    public function cancel(WalkinSession $walkin)
    {
        abort_unless($walkin->status === 'in_progress', 404);

        $walkin->update(['status' => 'cancelled']);

        return back()->with('success', 'Đã hủy phiên làm việc.');
    }
}
