<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SupplierController extends Controller
{
    public function index(): View
    {
        return view('inventory.suppliers.index', [
            'suppliers' => Supplier::withCount('inventoryTransactions')->orderBy('name')->paginate(20),
        ]);
    }

    public function store(SupplierRequest $request): RedirectResponse
    {
        Supplier::create($request->validated());

        return back()->with('success', 'Đã thêm nhà cung cấp.');
    }

    public function update(SupplierRequest $request, Supplier $supplier): RedirectResponse
    {
        $supplier->update($request->validated());

        return back()->with('success', 'Đã cập nhật nhà cung cấp.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();

        return back()->with('success', 'Đã xóa nhà cung cấp. Các phiếu cũ vẫn được giữ lại.');
    }
}
