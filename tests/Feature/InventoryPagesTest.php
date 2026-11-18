<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\InventoryTransaction;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_routes_require_an_authorized_staff_role(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create(['admin_role' => User::ROLE_CLIENT]))
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_inventory_pages_render_for_an_authorized_staff_user(): void
    {
        $category = Category::create(['name' => 'Thiết bị mạng']);
        $product = $category->products()->create([
            'sku' => 'SW-TEST001',
            'name' => 'Switch kiểm thử',
            'unit' => 'Cái',
            'stock_quantity' => 2,
            'min_stock_alert' => 1,
        ]);
        $transaction = InventoryTransaction::create([
            'transaction_code' => 'PN-TEST0001',
            'type' => InventoryTransaction::TYPE_IMPORT,
            'project_or_supplier_name' => 'Nhà cung cấp kiểm thử',
            'transaction_date' => now(),
            'status' => 'completed',
        ]);
        $transaction->items()->create(['product_id' => $product->id, 'quantity' => 2]);
        Project::create(['name' => 'Dự án kiểm thử', 'code' => 'PRJ-TEST001']);

        $this->actingAs(User::factory()->create(['admin_role' => User::ROLE_ADMIN]));

        foreach ([
            '/admin',
            '/admin/products',
            '/admin/products/create',
            '/admin/categories',
            '/admin/suppliers',
            '/admin/projects',
            '/admin/transactions',
            '/admin/transactions/create/import',
            '/admin/transactions/create/export',
            '/admin/transactions/create/adjustment',
        ] as $uri) {
            $this->get($uri)->assertOk();
        }

        $this->get(route('admin.products.show', $product))->assertOk();
        $this->get(route('admin.transactions.show', $transaction))->assertOk();
        $this->get(route('admin.transactions.print', $transaction))
            ->assertOk()
            ->assertSee('Chỉnh sửa nội dung phiếu')
            ->assertSee('contenteditable', false)
            ->assertSee('paper-a5')
            ->assertSee('Người nhận');

        $inventoryCsv = $this->get(route('admin.exports.products'));
        $inventoryCsv->assertOk()->assertDownload();
        $this->assertStringContainsString('SW-TEST001', $inventoryCsv->streamedContent());

        $transactionsCsv = $this->get(route('admin.exports.transactions'));
        $transactionsCsv->assertOk()->assertDownload();
        $this->assertStringContainsString('PN-TEST0001', $transactionsCsv->streamedContent());

        $this->post(route('admin.products.store'), [
            'sku' => 'SW-TEST001',
            'name' => 'SKU trùng',
            'category_id' => $category->id,
            'unit' => 'Cái',
            'min_stock_alert' => 0,
        ])->assertSessionHasErrors('sku');

        $this->post(route('admin.categories.store'), [
            'name' => $category->name,
        ])->assertSessionHasErrors('name');

        $this->post(route('admin.projects.store'), [
            'name' => 'Mã dự án trùng',
            'code' => 'PRJ-TEST001',
        ])->assertSessionHasErrors('code');
    }
}
