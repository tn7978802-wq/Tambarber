<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Support\Traits\HandlesImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BarberController extends Controller
{
    use HandlesImageUpload;

    public function index(): View
    {
        $barbers = Barber::orderByDesc('id')->paginate(15);

        return view('admin.barbers.index', compact('barbers'));
    }

    /**
     * Thêm barber mới. Chỉ "name" là bắt buộc, mọi thông tin khác đều tuỳ chọn.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        Barber::create($data);

        return back()->with('success', 'Đã thêm barber mới.');
    }

    public function update(Request $request, Barber $barber): RedirectResponse
    {
        $data = $this->validated($request, $barber);

        if (! $data['avatar']) {
            unset($data['avatar']);
        }

        $barber->update($data);

        return back()->with('success', 'Đã cập nhật thông tin barber.');
    }

    public function destroy(Barber $barber): RedirectResponse
    {
        $barber->delete();

        return back()->with('success', 'Đã xoá barber.');
    }

    private function validated(Request $request, ?Barber $barber = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,gif', 'max:5120'],
            'years_experience' => ['nullable', 'integer', 'min:0', 'max:80'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Tự sinh slug từ tên; nếu trùng thì gắn thêm số phía sau để đảm bảo duy nhất.
        $baseSlug = Str::slug($data['name']);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Barber::where('slug', $slug)
                ->when($barber, fn ($query) => $query->where('id', '!=', $barber->id))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $data['slug'] = $slug;
        $data['is_active'] = $request->boolean('is_active', true);
        $data['years_experience'] = $data['years_experience'] ?? 0;
        $data['avatar'] = $this->storeUploadedImage($request, 'avatar', 'uploads/barbers');

        return $data;
    }
}
