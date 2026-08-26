<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Support\Traits\HandlesImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    use HandlesImageUpload;

    public function index(): View
    {
        $services = Service::orderBy('name')->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        Service::create($validated);

        return back()->with('success', 'Đã thêm dịch vụ mới.');
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $this->validated($request);

        if (! $validated['image']) {
            unset($validated['image']);
        }

        $service->update($validated);

        return back()->with('success', 'Đã cập nhật dịch vụ.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return back()->with('success', 'Đã xoá dịch vụ.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_minutes' => ['required', 'integer', 'min:5'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,gif', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['image'] = $this->storeUploadedImage($request, 'image', 'uploads/services');

        return $data;
    }
}
