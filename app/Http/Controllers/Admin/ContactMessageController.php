<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        $messages = DB::table('contact_messages')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.contact.index', [
            'messages' => $messages,
        ]);
    }

    public function show(int $message): View
    {
        $contact = DB::table('contact_messages')->where('id', $message)->firstOrFail();

        return view('admin.contact.show', [
            'contact' => $contact,
        ]);
    }

    public function destroy(int $message): \Illuminate\Http\RedirectResponse
    {
        $deleted = DB::table('contact_messages')->where('id', $message)->delete();

        if ($deleted === 0) {
            return redirect()->route('admin.contact.index')->withErrors([
                'delete' => 'Tin nhắn không tồn tại hoặc đã được xóa trước đó.',
            ]);
        }

        return redirect()->route('admin.contact.index')->with('success', 'Đã xóa tin nhắn liên hệ thành công.');
    }
}
