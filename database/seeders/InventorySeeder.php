<?php

namespace Database\Seeders;

use App\Models\InventoryTransaction;
use App\Models\InventoryTransactionItem;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class InventorySeeder extends Seeder
{
    private const DEMO_PRODUCT_SKUS = [
        'SW-RG-001',
        'RT-CB-001',
        'SFP-1G-001',
        'CB-CAT6-001',
        'CB-FO-001',
        'CAM-CP-001',
        'NVR-CP-001',
        'RJ45-CAT6-001',
        'TIE-200-001',
        'LBL-BR-001',
    ];

    private const DEMO_TRANSACTION_CODES = [
        'PN-DEMO0001',
        'PX-DEMO0001',
    ];

    public function run(): void
    {
        $removed = DB::transaction(function (): array {
            $transactionIds = InventoryTransaction::whereIn('transaction_code', self::DEMO_TRANSACTION_CODES)
                ->pluck('id');
            $productIds = Product::whereIn('sku', self::DEMO_PRODUCT_SKUS)->pluck('id');

            $hasNonDemoHistory = InventoryTransactionItem::query()
                ->whereIn('product_id', $productIds)
                ->whereNotIn('transaction_id', $transactionIds)
                ->exists();

            if ($hasNonDemoHistory) {
                throw new RuntimeException(
                    'Không thể xóa vật tư mẫu vì có phiếu giao dịch khác đang tham chiếu đến chúng.',
                );
            }

            $transactions = InventoryTransaction::whereIn('id', $transactionIds)->delete();
            $products = Product::whereIn('id', $productIds)->delete();

            return compact('transactions', 'products');
        });

        if ($this->command !== null) {
            $this->command->info(
                "Đã xóa {$removed['transactions']} phiếu mẫu và {$removed['products']} vật tư mẫu.",
            );
        }
    }
}
