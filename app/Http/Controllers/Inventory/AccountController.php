<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\UserAccountRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->query('q', ''));

        return view('inventory.accounts.index', [
            'accounts' => User::query()
                ->withCount('inventoryTransactions')
                ->when($query !== '', function ($builder) use ($query): void {
                    $builder->where(function ($builder) use ($query): void {
                        $builder->where('fullname', 'like', "%{$query}%")
                            ->orWhere('email', 'like', "%{$query}%")
                            ->orWhere('phone', 'like', "%{$query}%");
                    });
                })
                ->orderByDesc('id')
                ->paginate(20)
                ->withQueryString(),
            'query' => $query,
        ]);
    }

    public function store(UserAccountRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()->route('admin.accounts.index')->with('success', 'Đã tạo tài khoản đăng nhập.');
    }

    public function edit(User $account): View
    {
        $this->authorizeAccountManagement($account);

        return view('inventory.accounts.edit', ['account' => $account]);
    }

    public function update(UserAccountRequest $request, User $account): RedirectResponse
    {
        $this->authorizeAccountManagement($account);

        if ($account->is($request->user()) && ! $request->boolean('is_active')) {
            return back()->withErrors([
                'account' => 'Không thể khóa tài khoản đang đăng nhập.',
            ])->withInput();
        }

        $attributes = $request->validated();
        if (blank($attributes['password'] ?? null)) {
            unset($attributes['password']);
        }

        $account->update($attributes);

        return redirect()->route('admin.accounts.index')->with('success', 'Đã cập nhật tài khoản.');
    }

    public function destroy(Request $request, User $account): RedirectResponse
    {
        $this->authorizeAccountManagement($account);

        if ($account->is($request->user())) {
            abort(403, 'Không thể xóa tài khoản đang đăng nhập.');
        }

        if ($account->inventoryTransactions()->exists()) {
            return back()->withErrors([
                'account' => 'Tài khoản đã tạo phiếu kho nên không thể xóa để bảo toàn lịch sử. Hãy khóa tài khoản thay thế.',
            ]);
        }

        $account->delete();

        return redirect()->route('admin.accounts.index')->with('success', 'Đã xóa tài khoản.');
    }

    private function authorizeAccountManagement(User $account): void
    {
        $actor = request()->user();
        $canManage = ! $account->isSystemOwner()
            && ($actor->isSystemOwner()
                || in_array($account->admin_role, [User::ROLE_GUEST, User::ROLE_CLIENT], true));

        abort_unless($canManage, 403, 'Bạn không có quyền quản lý tài khoản này.');
    }
}
