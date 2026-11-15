<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\InventoryTransaction;
use App\Models\Supplier;
use Database\Seeders\InventorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class InventorySchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_models_persist_their_relationships(): void
    {
        $category = Category::create(['name' => 'Thiết bị mạng']);
        $product = $category->products()->create([
            'sku' => 'SW-001',
            'name' => 'Switch PoE',
            'brand' => 'Ruijie',
            'unit' => 'Cái',
            'stock_quantity' => 3,
            'min_stock_alert' => 1,
        ]);
        $supplier = Supplier::create(['name' => 'Nhà cung cấp mẫu']);
        $transaction = InventoryTransaction::create([
            'transaction_code' => 'PN-TEST0001',
            'type' => InventoryTransaction::TYPE_IMPORT,
            'project_or_supplier_name' => $supplier->name,
            'supplier_id' => $supplier->id,
            'transaction_date' => now(),
            'status' => 'completed',
        ]);
        $transaction->items()->create([
            'product_id' => $product->id,
            'quantity' => 2,
            'serial_numbers' => ['SN-001', 'SN-002'],
        ]);

        $this->assertSame($category->id, $product->fresh()->category->id);
        $this->assertSame($supplier->id, $transaction->fresh()->supplier->id);
        $this->assertSame(['SN-001', 'SN-002'], $transaction->fresh()->items->first()->serial_numbers);
        $this->assertFalse(Schema::hasTable('bookings'));
        $this->assertFalse(Schema::hasTable('barbers'));
    }

    public function test_inventory_seeder_removes_only_demo_products_and_transactions(): void
    {
        $category = Category::create(['name' => 'Thiết bị mạng']);
        $demoProduct = $category->products()->create([
            'sku' => 'SW-RG-001',
            'name' => 'Switch mẫu',
            'unit' => 'Cái',
        ]);
        $realProduct = $category->products()->create([
            'sku' => 'SW-REAL-001',
            'name' => 'Switch thực tế',
            'unit' => 'Cái',
        ]);

        foreach (['PN-DEMO0001', 'PX-DEMO0001'] as $code) {
            $transaction = InventoryTransaction::create([
                'transaction_code' => $code,
                'type' => $code === 'PN-DEMO0001'
                    ? InventoryTransaction::TYPE_IMPORT
                    : InventoryTransaction::TYPE_EXPORT,
                'project_or_supplier_name' => 'Dữ liệu mẫu',
                'transaction_date' => now(),
                'status' => 'completed',
            ]);
            $transaction->items()->create([
                'product_id' => $demoProduct->id,
                'quantity' => 1,
            ]);
        }

        $realTransaction = InventoryTransaction::create([
            'transaction_code' => 'PN-REAL0001',
            'type' => InventoryTransaction::TYPE_IMPORT,
            'project_or_supplier_name' => 'Nhà cung cấp thực tế',
            'transaction_date' => now(),
            'status' => 'completed',
        ]);
        $realTransaction->items()->create([
            'product_id' => $realProduct->id,
            'quantity' => 1,
        ]);

        app(InventorySeeder::class)->run();

        $this->assertDatabaseMissing('products', ['sku' => 'SW-RG-001']);
        $this->assertDatabaseHas('products', ['sku' => 'SW-REAL-001']);
        $this->assertDatabaseMissing('inventory_transactions', ['transaction_code' => 'PN-DEMO0001']);
        $this->assertDatabaseMissing('inventory_transactions', ['transaction_code' => 'PX-DEMO0001']);
        $this->assertDatabaseHas('inventory_transactions', ['transaction_code' => 'PN-REAL0001']);
    }

    public function test_inventory_seeder_preserves_demo_products_used_by_real_transactions(): void
    {
        $product = Category::create(['name' => 'Thiết bị mạng'])->products()->create([
            'sku' => 'SW-RG-001',
            'name' => 'Switch mẫu',
            'unit' => 'Cái',
        ]);
        $demoTransaction = InventoryTransaction::create([
            'transaction_code' => 'PN-DEMO0001',
            'type' => InventoryTransaction::TYPE_IMPORT,
            'project_or_supplier_name' => 'Dữ liệu mẫu',
            'transaction_date' => now(),
            'status' => 'completed',
        ]);
        $demoTransaction->items()->create(['product_id' => $product->id, 'quantity' => 1]);
        $realTransaction = InventoryTransaction::create([
            'transaction_code' => 'PN-REAL0001',
            'type' => InventoryTransaction::TYPE_IMPORT,
            'project_or_supplier_name' => 'Nhà cung cấp thực tế',
            'transaction_date' => now(),
            'status' => 'completed',
        ]);
        $realTransaction->items()->create(['product_id' => $product->id, 'quantity' => 1]);

        try {
            app(InventorySeeder::class)->run();
            $this->fail('Expected sample cleanup to preserve products referenced by real transactions.');
        } catch (\RuntimeException $exception) {
            $this->assertStringContainsString('phiếu giao dịch khác', $exception->getMessage());
        }

        $this->assertDatabaseHas('products', ['sku' => 'SW-RG-001']);
        $this->assertDatabaseHas('inventory_transactions', ['transaction_code' => 'PN-DEMO0001']);
        $this->assertDatabaseHas('inventory_transactions', ['transaction_code' => 'PN-REAL0001']);
    }
}
