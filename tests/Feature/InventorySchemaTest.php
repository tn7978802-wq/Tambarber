<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\Supplier;
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

    public function test_inventory_seeder_is_repeatable_without_resetting_existing_stock(): void
    {
        $this->seed();
        Product::where('sku', 'SW-RG-001')->update(['stock_quantity' => 6]);
        $this->seed();

        $this->assertDatabaseCount('categories', 5);
        $this->assertDatabaseCount('products', 10);
        $this->assertDatabaseCount('inventory_transactions', 2);
        $this->assertSame('6.000', Product::where('sku', 'SW-RG-001')->value('stock_quantity'));
        $this->assertSame('450.000', Product::where('sku', 'CB-FO-001')->value('stock_quantity'));
    }
}
