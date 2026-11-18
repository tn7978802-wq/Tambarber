<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionCsvExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_contains_only_selected_transactions_and_includes_utf8_bom(): void
    {
        $admin = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $category = Category::create(['name' => 'Thiết bị mạng']);
        $product = Product::create([
            'sku' => 'SW-CSV-001',
            'name' => 'Switch kiểm thử',
            'category_id' => $category->id,
            'unit' => 'Cái',
        ]);
        $selected = $this->createTransaction('PX-SELECTED-001', InventoryTransaction::TYPE_EXPORT, $product);
        $this->createTransaction('PN-OTHER-001', InventoryTransaction::TYPE_IMPORT, $product);

        $response = $this->actingAs($admin)->get(route('admin.exports.transactions', [
            'transaction_ids' => [$selected->id],
            'type' => InventoryTransaction::TYPE_IMPORT,
        ]));

        $response->assertOk()->assertDownload();
        $csv = $response->streamedContent();

        $this->assertStringStartsWith("\xEF\xBB\xBF", $csv);
        $this->assertStringContainsString('PX-SELECTED-001', $csv);
        $this->assertStringNotContainsString('PN-OTHER-001', $csv);
    }

    public function test_export_without_selected_ids_uses_search_type_and_date_filters(): void
    {
        $admin = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $category = Category::create(['name' => 'Thiết bị mạng']);
        $product = Product::create([
            'sku' => 'SW-CSV-002',
            'name' => 'Router kiểm thử',
            'category_id' => $category->id,
            'unit' => 'Cái',
        ]);
        $matching = $this->createTransaction('PN-FILTER-MATCH', InventoryTransaction::TYPE_IMPORT, $product, 'Nhà cung cấp A', now()->subDay());
        $this->createTransaction('PN-FILTER-OLD', InventoryTransaction::TYPE_IMPORT, $product, 'Nhà cung cấp A', now()->subDays(10));
        $this->createTransaction('PX-FILTER-TYPE', InventoryTransaction::TYPE_EXPORT, $product, 'Nhà cung cấp A', now()->subDay());
        $this->createTransaction('PN-FILTER-SEARCH', InventoryTransaction::TYPE_IMPORT, $product, 'Nhà cung cấp B', now()->subDay());
        $this->createTransaction('PN-FILTER-FUTURE', InventoryTransaction::TYPE_IMPORT, $product, 'Nhà cung cấp C', now()->addDay());

        $response = $this->actingAs($admin)->get(route('admin.exports.transactions', [
            'type' => InventoryTransaction::TYPE_IMPORT,
            'q' => 'Nhà cung cấp A',
            'from' => now()->subDays(2)->toDateString(),
            'to' => now()->toDateString(),
        ]));

        $response->assertOk();
        $csv = $response->streamedContent();

        $this->assertStringContainsString($matching->transaction_code, $csv);
        $this->assertStringNotContainsString('PN-FILTER-OLD', $csv);
        $this->assertStringNotContainsString('PX-FILTER-TYPE', $csv);
        $this->assertStringNotContainsString('PN-FILTER-SEARCH', $csv);

        $toOnlyResponse = $this->get(route('admin.exports.transactions', [
            'to' => now()->toDateString(),
        ]));
        $toOnlyResponse->assertOk();
        $this->assertStringNotContainsString('PN-FILTER-FUTURE', $toOnlyResponse->streamedContent());
    }

    public function test_transaction_history_shows_select_all_and_export_controls(): void
    {
        $admin = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $category = Category::create(['name' => 'Thiết bị mạng']);
        $product = Product::create([
            'sku' => 'SW-CSV-003',
            'name' => 'Switch hiển thị',
            'category_id' => $category->id,
            'unit' => 'Cái',
        ]);
        $transaction = $this->createTransaction('PN-VIEW-001', InventoryTransaction::TYPE_IMPORT, $product);

        $this->actingAs($admin)->get(route('admin.transactions.index'))
            ->assertOk()
            ->assertSee('transaction-export-form')
            ->assertSee('select-all-transactions')
            ->assertSee('name="transaction_ids[]"', false)
            ->assertSee('value="'.$transaction->id.'"', false)
            ->assertSee('nếu không chọn phiếu nào, CSV sẽ gồm toàn bộ kết quả theo bộ lọc hiện tại.');
    }

    private function createTransaction(
        string $code,
        string $type,
        Product $product,
        string $name = 'Dự án kiểm thử',
        ?\Illuminate\Support\Carbon $date = null,
    ): InventoryTransaction {
        $transaction = InventoryTransaction::create([
            'transaction_code' => $code,
            'type' => $type,
            'project_or_supplier_name' => $name,
            'transaction_date' => $date ?? now(),
            'status' => 'completed',
        ]);
        $transaction->items()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        return $transaction;
    }
}
