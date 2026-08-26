<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Support\Traits\HandlesImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class AnnouncementController extends Controller
{
    use HandlesImageUpload;

    public function index(): View
        {
            $announcements = Announcement::with('user')
                ->withCount('comments')
                ->latestFirst()
                ->paginate(15);
            return view('announcements.index', compact('announcements'));
        }
    /**
     * Đăng trạng thái/sự kiện mới. Chỉ "Nội dung" là bắt buộc, ảnh và ngày sự kiện tuỳ chọn.
     */
    public function store(Request $request): RedirectResponse
        {
            $data = $request->validate([
                'title' => ['nullable', 'string', 'max:255'],
                'content' => ['required', 'string', 'max:2000'],
                'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,gif', 'max:5120'],
                'event_at' => ['nullable', 'date'],
                'is_pinned' => ['nullable', 'boolean'],
            ], [
                'content.required' => 'Vui lòng nhập nội dung trạng thái/sự kiện.',
            ]);
            $data['user_id'] = $request->user()->id;
            $data['is_pinned'] = $request->boolean('is_pinned');
            $data['image'] = $this->storeUploadedImage($request, 'image', 'uploads/announcements');
            Announcement::create($data);
            return back()->with('success', 'Đã đăng trạng thái/sự kiện mới.');
        }
    public function destroy(Announcement $announcement): RedirectResponse
        {
            $announcement->delete();
            return back()->with('success', 'Đã xoá trạng thái/sự kiện.');
        }
    public function show($id)
    {
        // Lấy announcement cùng bình luận gốc và các câu trả lời
        $announcement = Announcement::with(['comments' => function ($query) {
            $query->whereNull('parent_id')->with('replies');
        }])->findOrFail($id);

        return view('announcements.show', compact('announcement'));
    }

    public function storeComment(Request $request, Announcement $announcement)
    {
        $request->validate([
            'content' => 'required|string',
            'guest_name' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $announcement->comments()->create([
            'content' => $request->content,
            'guest_name' => auth()->check() ? null : $request->guest_name,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Đã thêm bình luận');
    }
}
