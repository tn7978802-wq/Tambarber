<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\CategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('inventory.categories.index', [
            'categories' => Category::withCount('products')->orderBy('name')->paginate(20),
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return back()->with('success', 'Đã tạo danh mục.');
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return back()->with('success', 'Đã cập nhật danh mục.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return back()->withErrors([
                'category' => 'Không thể xóa danh mục đang có vật tư.',
            ]);
        }

        $category->delete();

        return back()->with('success', 'Đã xóa danh mục.');
    }
}
