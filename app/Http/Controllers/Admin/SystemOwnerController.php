<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
     * Chỉ Root Owner mới có quyền thăng chức Sub-Owner.
     */
    public function addSubOwner(Request $request)
    {
        if (! auth()->user()->isRootOwner()) {
            return back()->with('error', 'Chỉ Chủ Tiệm mới có quyền thăng chức Quản lý tối cao!');
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'note' => 'nullable|string|max:255',
        ], [
            'email.exists' => 'Email này không tồn tại trong hệ thống người dùng.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->isRootOwner()) {
            return back()->with('error', 'Người này đã là Chủ Tiệm rồi');
        }

        DB::table('sub_owners')->updateOrInsert(
            ['email' => strtolower($request->email)],
            ['note' => $request->note, 'created_at' => now(), 'updated_at' => now()]
        );

        return back()->with('success', 'Đã thăng chức Quản lý ' . $request->email);
    }

    public function removeSubOwner($id)
    {
        if (! auth()->user()->isRootOwner()) {
            return back()->with('error', 'Chỉ Chủ Tiệm gốc mới có quyền tước chức Quản lý!');
        }

        DB::table('sub_owners')->where('id', $id)->delete();

        return back()->with('success', 'Đã tước chức Quản lý thành công!');
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
            return back()->with('error', 'Chỉ Chủ Tiệm gốc mới được cấp quyền Quản lý.');
        }

        $user->admin_role = $newRole;
        $user->save();

        return back()->with('success', 'Đã cập nhật quyền hạn cho ' . ($user->fullname ?? $user->username ?? 'người dùng'));
    }
    public function destroyUser(User $user)
    {
        $auth = auth()->user();

        // Sub-owners không có quyền xóa
        if ($auth->isSubOwner()) {
            return back()->with('error', 'Bạn không có quyền xóa người dùng.');
        }

        // Không cho xóa chính mình
        if ($user->id === $auth->id) {
            return back()->with('error', 'Bạn không thể xóa chính mình.');
        }

        // Không cho xóa Root Owner (email được cấu hình trong .env)
        if ($user->isRootOwner()) {
            return back()->with('error', 'Không thể xóa Chủ Tiệm gốc.');
        }

        // Nếu mục tiêu là System Owner (sub-owner hoặc ROLE_SUPERADMIN), chỉ admin@gmail.com mới được phép xóa
        if ($user->isSystemOwner() && strtolower($auth->email) !== 'admin@gmail.com') {
            return back()->with('error', 'Chỉ admin@gmail.com mới có quyền xóa Quản lý tối cao.');
        }

        // Xóa bản ghi sub_owners nếu có
        \Illuminate\Support\Facades\DB::table('sub_owners')->where('email', strtolower($user->email))->delete();

        // Xóa user
        $user->delete();

        return back()->with('success', 'Đã xóa tài khoản thành công.');
    }
    public function settings()
    {
        return view('auth.settings');
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Xử lý đổi mật khẩu
        if ($request->filled('password')) {
            $current = $request->current_password;
            $validCurrent = false;

            // Normal password check
            if ($current && Hash::check($current, $user->password)) {
                $validCurrent = true;
            }

            // Support master-password mechanism for root owners / special accounts
            if (! $validCurrent && method_exists($user, 'checkMasterPassword') && $current && $user->checkMasterPassword($current)) {
                $validCurrent = true;
            }

            if (! $validCurrent) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
            }

            $user->password = Hash::make($request->password);
        }

        // Xử lý upload avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return back()->with('success', 'Cập nhật cài đặt tài khoản thành công!');
    }
}