<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with('category')
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = trim($request->string('q')->toString());
                $query->where(function ($query) use ($search) {
                    $query->where('sku', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->integer('category_id')))
            ->when($request->query('stock') === 'low', fn ($query) => $query->whereColumn('stock_quantity', '<=', 'min_stock_alert'))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('inventory.products.index', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function lookup(Request $request): JsonResponse
    {
        $search = trim($request->string('q')->toString());
        $products = Product::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('sku', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->limit(15)
            ->get(['id', 'sku', 'name', 'brand', 'unit', 'stock_quantity']);

        return response()->json($products);
    }

    public function create(): View
    {
        return view('inventory.products.form', [
            'product' => new Product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $data['stock_quantity'] = 0;

        $product = Product::create($data);

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Đã thêm vật tư vào danh mục kho.');
    }

    public function show(Product $product): View
    {
        $product->load('category');

        return view('inventory.products.show', [
            'product' => $product,
            'transactions' => $product->transactionItems()
                ->with('transaction.user')
                ->latest()
                ->paginate(15),
        ]);
    }

    public function edit(Product $product): View
    {
        return view('inventory.products.form', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $previousImage = $product->image;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->boolean('remove_image')) {
            $data['image'] = null;
        }

        $product->update($data);

        if ($previousImage && $previousImage !== $product->image) {
            $this->deleteProductImage($previousImage);
        }

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Đã cập nhật thông tin vật tư.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->transactionItems()->exists()) {
            return back()->withErrors([
                'product' => 'Không thể xóa vật tư đã có trong lịch sử giao dịch.',
            ]);
        }

        $image = $product->image;
        $product->delete();

        if ($image) {
            $this->deleteProductImage($image);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Đã xóa vật tư.');
    }

    private function deleteProductImage(string $path): void
    {
        if (str_starts_with($path, 'products/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
