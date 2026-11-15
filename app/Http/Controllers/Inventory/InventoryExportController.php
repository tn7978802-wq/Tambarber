<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\InventoryTransaction;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryExportController extends Controller
{
    public function products()
    {
        return response()->streamDownload(function () {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['SKU', 'Tên vật tư', 'Danh mục', 'Hãng', 'Đơn vị', 'Tồn kho', 'Định mức cảnh báo', 'Vị trí'], ';');

            Product::with('category')->orderBy('sku')->chunk(200, function ($products) use ($output) {
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
        $type = $request->query('type');

        return response()->streamDownload(function () use ($type) {
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
                ->when(in_array($type, [
                    InventoryTransaction::TYPE_IMPORT,
                    InventoryTransaction::TYPE_EXPORT,
                    InventoryTransaction::TYPE_ADJUSTMENT,
                ], true), fn ($query) => $query->where('type', $type))
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
