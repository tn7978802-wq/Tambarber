<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\InventoryTransaction;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryExportController extends Controller
{
    public function products(Request $request)
    {
        $filters = $request->validate([
            'product_ids' => ['sometimes', 'array', 'max:500'],
            'product_ids.*' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'ids' => ['sometimes', 'array', 'max:500'],
            'ids.*' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'q' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'stock' => ['nullable', 'in:low'],
        ]);
        $selectedIds = $request->filled('product_ids')
            ? $filters['product_ids']
            : ($request->filled('ids') ? $filters['ids'] : []);

        return response()->streamDownload(function () use ($filters, $selectedIds) {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['SKU', 'Tên vật tư', 'Danh mục', 'Hãng', 'Đơn vị', 'Tồn kho', 'Định mức cảnh báo', 'Vị trí'], ';');

            Product::query()
                ->with('category')
                ->when($selectedIds !== [], fn ($query) => $query->whereIn('id', $selectedIds), function ($query) use ($filters) {
                    $query
                        ->when(isset($filters['q']) && $filters['q'] !== '', function ($query) use ($filters) {
                            $search = trim($filters['q']);
                            $query->where(function ($query) use ($search) {
                                $query->where('sku', 'like', "%{$search}%")
                                    ->orWhere('name', 'like', "%{$search}%")
                                    ->orWhere('brand', 'like', "%{$search}%");
                            });
                        })
                        ->when(isset($filters['category_id']) && $filters['category_id'] !== '', fn ($query) => $query->where('category_id', $filters['category_id']))
                        ->when(($filters['stock'] ?? null) === 'low', fn ($query) => $query->whereColumn('stock_quantity', '<=', 'min_stock_alert'));
                })
                ->orderBy('sku')
                ->chunk(200, function ($products) use ($output) {
                    foreach ($products as $product) {
                        fputcsv($output, [
                            $this->safeText($product->sku),
                            $this->safeText($product->name),
                            $this->safeText($product->category->name),
                            $this->safeText($product->brand),
                            $this->safeText($product->unit),
                            $product->stock_quantity,
                            $product->min_stock_alert,
                            $this->safeText($product->location),
                        ], ';');
                    }
                });

            fclose($output);
        }, 'ton-kho-'.now()->format('Ymd-His').'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function transactions(Request $request)
    {
        $filters = $request->validate([
            'transaction_ids' => ['sometimes', 'array', 'max:500'],
            'transaction_ids.*' => ['required', 'integer', 'distinct', 'exists:inventory_transactions,id'],
            'ids' => ['sometimes', 'array', 'max:500'],
            'ids.*' => ['required', 'integer', 'distinct', 'exists:inventory_transactions,id'],
            'q' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'in:import,export,adjustment'],
            'from' => ['nullable', 'date_format:Y-m-d'],
            'to' => $request->filled('from')
                ? ['nullable', 'date_format:Y-m-d', 'after_or_equal:from']
                : ['nullable', 'date_format:Y-m-d'],
        ]);
        $selectedIds = $request->filled('transaction_ids')
            ? $filters['transaction_ids']
            : ($request->filled('ids') ? $filters['ids'] : []);

        return response()->streamDownload(function () use ($filters, $selectedIds) {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, [
                'Mã phiếu',
                'Loại',
                'Ngày giao dịch',
                'Dự án/Nhà cung cấp',
                'Người thực hiện',
                'SKU',
                'Tên vật tư',
                'Số lượng',
                'Đơn vị',
                'Đơn giá',
                'Serial/MAC',
            ], ';');

            InventoryTransaction::query()
                ->with(['items.product', 'user'])
                ->when($selectedIds !== [], fn ($query) => $query->whereIn('id', $selectedIds), function ($query) use ($filters) {
                    $query
                        ->when(isset($filters['type']) && $filters['type'] !== '', fn ($query) => $query->where('type', $filters['type']))
                        ->when(isset($filters['q']) && $filters['q'] !== '', function ($query) use ($filters) {
                            $search = trim($filters['q']);
                            $query->where(function ($query) use ($search) {
                                $query->where('transaction_code', 'like', "%{$search}%")
                                    ->orWhere('project_or_supplier_name', 'like', "%{$search}%");
                            });
                        })
                        ->when(isset($filters['from']) && $filters['from'] !== '', fn ($query) => $query->whereDate('transaction_date', '>=', $filters['from']))
                        ->when(isset($filters['to']) && $filters['to'] !== '', fn ($query) => $query->whereDate('transaction_date', '<=', $filters['to']));
                })
                ->orderBy('transaction_date')
                ->chunk(100, function ($transactions) use ($output) {
                    foreach ($transactions as $transaction) {
                        foreach ($transaction->items as $item) {
                            fputcsv($output, [
                                $this->safeText($transaction->transaction_code),
                                $this->safeText($transaction->type),
                                $transaction->transaction_date->format('Y-m-d H:i:s'),
                                $this->safeText($transaction->project_or_supplier_name),
                                $this->safeText($transaction->user?->fullname),
                                $this->safeText($item->product->sku),
                                $this->safeText($item->product->name),
                                $item->quantity,
                                $this->safeText($item->product->unit),
                                $item->unit_price,
                                $this->safeText(implode(', ', $item->serial_numbers ?? [])),
                            ], ';');
                        }
                    }
                });

            fclose($output);
        }, 'lich-su-giao-dich-'.now()->format('Ymd-His').'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function safeText(?string $value): string
    {
        $value ??= '';

        return preg_match('/^[\s\x00-\x20]*[=+\-@]/u', $value) === 1 ? "'".$value : $value;
    }
}
