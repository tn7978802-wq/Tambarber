<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\InventorySeeder;
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
        $this->seed(InventorySeeder::class);
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

        $product = Product::firstOrFail();
        $transaction = InventoryTransaction::firstOrFail();
        $this->get(route('admin.products.show', $product))->assertOk();
        $this->get(route('admin.transactions.show', $transaction))->assertOk();
        $this->get(route('admin.transactions.print', $transaction))->assertOk();

        $inventoryCsv = $this->get(route('admin.exports.products'));
        $inventoryCsv->assertOk()->assertDownload();
        $this->assertStringContainsString('SW-RG-001', $inventoryCsv->streamedContent());

        $transactionsCsv = $this->get(route('admin.exports.transactions'));
        $transactionsCsv->assertOk()->assertDownload();
        $this->assertStringContainsString('PN-DEMO0001', $transactionsCsv->streamedContent());

        $category = Category::firstOrFail();
        $this->post(route('admin.products.store'), [
            'sku' => 'SW-RG-001',
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
            'code' => 'PRJ-DEMO',
        ])->assertSessionHasErrors('code');
    }
}
