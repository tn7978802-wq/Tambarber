<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hairstyle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HairstyleController extends Controller
{
    public function index(): View
    {
        $hairstyles = Hairstyle::orderBy('name')->paginate(15);

        return view('admin.hairstyles.index', compact('hairstyles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        Hairstyle::create($data);

        return back()->with('success', 'Đã thêm kiểu tóc mới.');
    }

    public function update(Request $request, Hairstyle $hairstyle): RedirectResponse
    {
        $data = $this->validated($request);

        $hairstyle->update($data);

        return back()->with('success', 'Đã cập nhật kiểu tóc.');
    }

    public function destroy(Hairstyle $hairstyle): RedirectResponse
    {
        $hairstyle->delete();

        return back()->with('success', 'Đã xoá kiểu tóc.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'suitable_face_shapes' => ['nullable', 'string', 'max:255'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'reference_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        return $data;
    }
}