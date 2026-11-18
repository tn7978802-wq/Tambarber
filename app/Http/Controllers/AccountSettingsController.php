<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AccountSettingsController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.settings.index', [
            'user' => $request->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'] !== '' ? $data['phone'] : null;
        $user->save();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Thông tin cá nhân đã được cập nhật thành công.');
    }
}
