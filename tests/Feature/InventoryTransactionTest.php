<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\Project;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_increases_stock_and_saves_serial_numbers(): void
    {
        $user = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $product = $this->makeProduct(3);
        $supplier = Supplier::create(['name' => 'Nhà cung cấp kiểm thử']);

        $response = $this->actingAs($user)->post(route('admin.transactions.store'), [
            'type' => InventoryTransaction::TYPE_IMPORT,
            'supplier_id' => $supplier->id,
            'transaction_date' => now()->toDateString(),
            'items' => [[
                'product_id' => $product->id,
                'quantity' => 2,
                'serial_numbers' => "MAC-001\nMAC-002",
            ]],
        ]);

        $transaction = InventoryTransaction::firstOrFail();
        $response->assertRedirect(route('admin.transactions.show', $transaction));
        $this->assertSame(5.0, (float) $product->fresh()->stock_quantity);
        $this->assertSame('PN', substr($transaction->transaction_code, 0, 2));
        $this->assertSame(['MAC-001', 'MAC-002'], $transaction->items->first()->serial_numbers);
    }

    public function test_export_that_exceeds_stock_is_rejected_without_writing_a_transaction(): void
    {
        $user = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $product = $this->makeProduct(2);
        $project = Project::create(['name' => 'Dự án kiểm thử']);

        $response = $this->actingAs($user)->from('/admin/transactions/create/export')->post(
            route('admin.transactions.store'),
            [
                'type' => InventoryTransaction::TYPE_EXPORT,
                'project_id' => $project->id,
                'transaction_date' => now()->toDateString(),
                'items' => [[
                    'product_id' => $product->id,
                    'quantity' => 3,
                ]],
            ],
        );

        $response->assertRedirect('/admin/transactions/create/export');
        $response->assertSessionHasErrors('items.0.quantity');
        $this->assertSame(2.0, (float) $product->fresh()->stock_quantity);
        $this->assertDatabaseCount('inventory_transactions', 0);
    }

    public function test_malformed_transaction_rows_are_rejected_by_validation(): void
    {
        $user = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $response = $this->actingAs($user)->post(route('admin.transactions.store'), [
            'type' => InventoryTransaction::TYPE_ADJUSTMENT,
            'project_or_supplier_name' => 'Kiểm kê',
            'transaction_date' => now()->toDateString(),
            'items' => ['dòng không hợp lệ'],
        ]);

        $response->assertSessionHasErrors('items.0');
        $this->assertDatabaseCount('inventory_transactions', 0);
    }

    public function test_quantities_must_match_the_supported_decimal_precision(): void
    {
        $user = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $product = $this->makeProduct(0);
        $supplier = Supplier::create(['name' => 'Nhà cung cấp kiểm thử']);

        $response = $this->actingAs($user)->post(route('admin.transactions.store'), [
            'type' => InventoryTransaction::TYPE_IMPORT,
            'supplier_id' => $supplier->id,
            'transaction_date' => now()->toDateString(),
            'items' => [[
                'product_id' => $product->id,
                'quantity' => '0.0001',
            ]],
        ]);

        $response->assertSessionHasErrors('items.0.quantity');
        $this->assertSame(0.0, (float) $product->fresh()->stock_quantity);
        $this->assertDatabaseCount('inventory_transactions', 0);
    }

    private function makeProduct(float $stock): Product
    {
        $category = Category::create(['name' => 'Thiết bị kiểm thử']);

        return Product::create([
            'sku' => 'TEST-'.uniqid(),
            'name' => 'Thiết bị mẫu',
            'category_id' => $category->id,
            'unit' => 'Cái',
            'stock_quantity' => $stock,
            'min_stock_alert' => 1,
        ]);
    }
}
