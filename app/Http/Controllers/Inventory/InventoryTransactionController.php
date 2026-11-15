<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreInventoryTransactionRequest;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\Project;
use App\Models\Supplier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class InventoryTransactionController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->query('type');
        $transactions = InventoryTransaction::with('user')
            ->when(
                in_array($type, [
                    InventoryTransaction::TYPE_IMPORT,
                    InventoryTransaction::TYPE_EXPORT,
                    InventoryTransaction::TYPE_ADJUSTMENT,
                ], true),
                fn ($query) => $query->where('type', $type),
            )
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = trim($request->string('q')->toString());
                $query->where(function ($query) use ($search) {
                    $query->where('transaction_code', 'like', "%{$search}%")
                        ->orWhere('project_or_supplier_name', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('from'), fn ($query) => $query->whereDate('transaction_date', '>=', $request->query('from')))
            ->when($request->filled('to'), fn ($query) => $query->whereDate('transaction_date', '<=', $request->query('to')))
            ->latest('transaction_date')
            ->paginate(20)
            ->withQueryString();

        return view('inventory.transactions.index', compact('transactions', 'type'));
    }

    public function create(string $type): View
    {
        abort_unless(in_array($type, [
            InventoryTransaction::TYPE_IMPORT,
            InventoryTransaction::TYPE_EXPORT,
            InventoryTransaction::TYPE_ADJUSTMENT,
        ], true), 404);

        return view('inventory.transactions.form', [
            'type' => $type,
            'suppliers' => Supplier::orderBy('name')->get(),
            'projects' => Project::orderBy('name')->get(),
        ]);
    }

    public function store(StoreInventoryTransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $transaction = DB::transaction(function () use ($data, $request) {
            $type = $data['type'];
            $supplier = $type === InventoryTransaction::TYPE_IMPORT
                ? Supplier::findOrFail($data['supplier_id'])
                : null;
            $project = $type === InventoryTransaction::TYPE_EXPORT
                ? Project::findOrFail($data['project_id'])
                : null;
            $ids = collect($data['items'])->pluck('product_id')->sort()->values();
            $products = Product::query()
                ->whereIn('id', $ids)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $partnerName = $supplier?->name
                ?? $project?->name
                ?? $data['project_or_supplier_name'];

            $transaction = InventoryTransaction::create([
                'transaction_code' => $this->makeTransactionCode($type),
                'type' => $type,
                'project_or_supplier_name' => $partnerName,
                'supplier_id' => $supplier?->id,
                'project_id' => $project?->id,
                'user_id' => $request->user()->id,
                'transaction_date' => $data['transaction_date'],
                'note' => $data['note'] ?? null,
                'status' => 'completed',
            ]);

            foreach ($data['items'] as $index => $item) {
                $product = $products->get($item['product_id']);
                if (! $product) {
                    throw ValidationException::withMessages([
                        "items.{$index}.product_id" => 'Vật tư không còn tồn tại.',
                    ]);
                }

                $quantity = (float) $item['quantity'];
                $currentStock = (float) $product->stock_quantity;
                $newStock = match ($type) {
                    InventoryTransaction::TYPE_IMPORT => round($currentStock + $quantity, 3),
                    InventoryTransaction::TYPE_EXPORT => round($currentStock - $quantity, 3),
                    InventoryTransaction::TYPE_ADJUSTMENT => round($currentStock + $quantity, 3),
                };

                if ($type === InventoryTransaction::TYPE_EXPORT && $quantity > $currentStock) {
                    throw ValidationException::withMessages([
                        "items.{$index}.quantity" => "Vật tư {$product->sku} chỉ còn {$product->stock_quantity} {$product->unit}.",
                    ]);
                }

                if ($newStock < 0) {
                    throw ValidationException::withMessages([
                        "items.{$index}.quantity" => "Điều chỉnh sẽ làm tồn kho {$product->sku} âm.",
                    ]);
                }

                $product->stock_quantity = $newStock;
                $product->save();

                $transaction->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $item['unit_price'] ?? null,
                    'serial_numbers' => $item['serial_numbers'] ?? null,
                ]);
            }

            return $transaction;
        }, 3);

        return redirect()->route('admin.transactions.show', $transaction)
            ->with('success', 'Đã lưu phiếu và cập nhật tồn kho.');
    }

    public function show(InventoryTransaction $transaction): View
    {
        $transaction->load(['items.product.category', 'supplier', 'project', 'user']);

        return view('inventory.transactions.show', compact('transaction'));
    }

    public function print(InventoryTransaction $transaction): View
    {
        $transaction->load(['items.product.category', 'supplier', 'project', 'user']);

        return view('inventory.transactions.print', compact('transaction'));
    }

    private function makeTransactionCode(string $type): string
    {
        $prefix = match ($type) {
            InventoryTransaction::TYPE_IMPORT => 'PN',
            InventoryTransaction::TYPE_EXPORT => 'PX',
            InventoryTransaction::TYPE_ADJUSTMENT => 'KK',
        };

        return $prefix.'-'.now()->format('Ymd').'-'.Str::upper(Str::random(5));
    }
}
