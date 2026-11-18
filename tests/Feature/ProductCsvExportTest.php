<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCsvExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_contains_only_selected_products_and_includes_utf8_bom(): void
    {
        $admin = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $category = Category::create(['name' => 'Thiết bị mạng']);
        $selected = $this->createProduct($category, 'SW-SELECTED-001', 'Switch chọn');
        $this->createProduct($category, 'RT-OTHER-001', 'Router khác');

        $response = $this->actingAs($admin)->get(route('admin.exports.products', [
            'product_ids' => [$selected->id],
            'q' => 'không khớp',
        ]));

        $response->assertOk()->assertDownload();
        $csv = $response->streamedContent();

        $this->assertStringStartsWith("\xEF\xBB\xBF", $csv);
        $this->assertStringContainsString('SW-SELECTED-001', $csv);
        $this->assertStringNotContainsString('RT-OTHER-001', $csv);
    }

    public function test_export_without_selected_ids_uses_search_category_and_low_stock_filters(): void
    {
        $admin = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $networkCategory = Category::create(['name' => 'Thiết bị mạng']);
        $cableCategory = Category::create(['name' => 'Cáp quang']);
        $matching = $this->createProduct($networkCategory, 'SW-LOW-001', 'Switch Ruijie', 1, 2);
        $this->createProduct($networkCategory, 'SW-ENOUGH-001', 'Switch Ruijie dự phòng', 10, 2);
        $this->createProduct($cableCategory, 'SW-CATEGORY-001', 'Switch Ruijie cáp', 1, 2);
        $this->createProduct($networkCategory, 'RT-BRAND-001', 'Router Cisco', 1, 2);

        $response = $this->actingAs($admin)->get(route('admin.exports.products', [
            'q' => 'Ruijie',
            'category_id' => $networkCategory->id,
            'stock' => 'low',
        ]));

        $response->assertOk();
        $csv = $response->streamedContent();

        $this->assertStringContainsString($matching->sku, $csv);
        $this->assertStringNotContainsString('SW-ENOUGH-001', $csv);
        $this->assertStringNotContainsString('SW-CATEGORY-001', $csv);
        $this->assertStringNotContainsString('RT-BRAND-001', $csv);
    }

    public function test_product_list_shows_select_all_and_export_controls(): void
    {
        $admin = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $category = Category::create(['name' => 'Thiết bị mạng']);
        $product = $this->createProduct($category, 'SW-VIEW-001', 'Switch hiển thị');

        $this->actingAs($admin)->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('product-export-form')
            ->assertSee('select-all-products')
            ->assertSee('name="product_ids[]"', false)
            ->assertSee('value="'.$product->id.'"', false)
            ->assertSee('nếu không chọn dòng nào, CSV sẽ gồm toàn bộ kết quả theo bộ lọc hiện tại.');
    }

    private function createProduct(
        Category $category,
        string $sku,
        string $name,
        float $stock = 1,
        float $minimum = 2,
    ): Product {
        return Product::create([
            'sku' => $sku,
            'name' => $name,
            'category_id' => $category->id,
            'unit' => 'Cái',
            'stock_quantity' => $stock,
            'min_stock_alert' => $minimum,
        ]);
    }
}
