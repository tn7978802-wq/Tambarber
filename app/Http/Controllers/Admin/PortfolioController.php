<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $items = PortfolioItem::query()
            ->category($request->query('danh-muc'))
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = PortfolioItem::CATEGORIES;

        return view('admin.portfolio.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = PortfolioItem::CATEGORIES;
        $barbers = Barber::orderBy('name')->get();

        return view('admin.portfolio.create', compact('categories', 'barbers'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $data['image_after'] = $request->file('image_after')->store('portfolio', 'public');

        if ($request->hasFile('image_before')) {
            $data['image_before'] = $request->file('image_before')->store('portfolio', 'public');
        }

        PortfolioItem::create($data);

        return redirect()
            ->route('admin.portfolio.index')
            ->with('success', 'Đã thêm tác phẩm vào thư viện.');
    }

    public function edit(PortfolioItem $portfolio)
    {
        $categories = PortfolioItem::CATEGORIES;
        $barbers = Barber::orderBy('name')->get();

        return view('admin.portfolio.edit', [
            'item' => $portfolio,
            'categories' => $categories,
            'barbers' => $barbers,
        ]);
    }

    public function update(Request $request, PortfolioItem $portfolio)
    {
        $data = $this->validated($request, updating: true);

        if ($request->hasFile('image_after')) {
            if ($portfolio->image_after) {
                Storage::disk('public')->delete($portfolio->image_after);
            }
            $data['image_after'] = $request->file('image_after')->store('portfolio', 'public');
        }

        if ($request->hasFile('image_before')) {
            if ($portfolio->image_before) {
                Storage::disk('public')->delete($portfolio->image_before);
            }
            $data['image_before'] = $request->file('image_before')->store('portfolio', 'public');
        }

        $portfolio->update($data);

        return redirect()
            ->route('admin.portfolio.index')
            ->with('success', 'Đã cập nhật tác phẩm.');
    }

    public function destroy(PortfolioItem $portfolio)
    {
        Storage::disk('public')->delete(array_filter([
            $portfolio->image_after,
            $portfolio->image_before,
        ]));

        $portfolio->delete();

        return back()->with('success', 'Đã xoá tác phẩm khỏi thư viện.');
    }

    private function validated(Request $request, bool $updating = false): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category' => ['required', 'string', 'in:' . implode(',', array_keys(PortfolioItem::CATEGORIES))],
            'barber_id' => ['nullable', 'exists:barbers,id'],
            'is_featured' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image_after' => [$updating ? 'nullable' : 'required', 'image', 'max:4096'],
            'image_before' => ['nullable', 'image', 'max:4096'],
        ]);
    }
}
