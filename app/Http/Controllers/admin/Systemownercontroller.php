<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemOwnerController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('admin_role', '>', User::ROLE_CLIENT)->count(),
            'total_revenue' => (float) DB::table('bookings')
                ->join('services', 'services.id', '=', 'bookings.service_id')
                ->where('bookings.status', 'completed')
                ->sum('services.price'),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'bookings_today' => DB::table('bookings')->whereDate('booking_date', today())->count(),
            'pending_contact_messages' => DB::table('contact_messages')->count(),
        ];

        $subOwners = DB::table('sub_owners')->get();

        $topServices = DB::table('bookings')
            ->join('services', 'services.id', '=', 'bookings.service_id')
            ->select('services.name', DB::raw('COUNT(bookings.id) as total_bookings'))
            ->groupBy('services.name')
            ->orderByDesc('total_bookings')
            ->limit(5)
            ->get();

        $users = User::orderByDesc('admin_role')->paginate(15);

        return view('admin.system_owner.index', [
            'stats' => $stats,
            'users' => $users,
            'subOwners' => $subOwners,
            'topServices' => $topServices,
        ]);
    }

    /**
     * Chỉ Root Owner (định nghĩa trong .env) mới có quyền thăng chức Sub-Owner.
     */
    public function addSubOwner(Request $request)
    {
        if (! auth()->user()->isRootOwner()) {
            return back()->with('error', 'Chỉ Chủ Tiệm gốc (Root Owner) mới có quyền thăng chức Quản lý tối cao!');
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'note' => 'nullable|string|max:255',
        ], [
            'email.exists' => 'Email này không tồn tại trong hệ thống người dùng.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->isRootOwner()) {
            return back()->with('error', 'Người này đã là Chủ Tiệm gốc trong .env rồi.');
        }

        DB::table('sub_owners')->updateOrInsert(
            ['email' => strtolower($request->email)],
            ['note' => $request->note, 'created_at' => now(), 'updated_at' => now()]
        );

        return back()->with('success', 'Đã thăng chức Quản lý tối cao cho ' . $request->email);
    }

    public function removeSubOwner($id)
    {
        if (! auth()->user()->isRootOwner()) {
            return back()->with('error', 'Chỉ Chủ Tiệm gốc mới có quyền tước chức Quản lý tối cao!');
        }

        DB::table('sub_owners')->where('id', $id)->delete();

        return back()->with('success', 'Đã tước chức Quản lý tối cao thành công!');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'admin_role' => 'required|integer|in:0,1,2,3',
        ]);

        $newRole = (int) $request->input('admin_role');

        // Không cho tự tước quyền của chính mình.
        if ($user->id === auth()->id() && $newRole < User::ROLE_ADMIN) {
            return back()->with('error', 'Bạn không thể tự tước quyền quản trị của chính mình.');
        }

        // Chỉ Root/Sub Owner mới được cấp quyền Super Admin cho người khác.
        if (! auth()->user()->isRootOwner() && $newRole === User::ROLE_SUPERADMIN) {
            return back()->with('error', 'Chỉ Chủ Tiệm gốc mới được cấp quyền Quản lý tối cao.');
        }

        $user->admin_role = $newRole;
        $user->save();

        return back()->with('success', 'Đã cập nhật quyền hạn cho ' . ($user->fullname ?? $user->username ?? 'người dùng'));
    }
}