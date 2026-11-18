<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImageUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_product_image_is_stored_and_rendered_with_a_relative_storage_url(): void
    {
        $category = Category::create(['name' => 'Thiết bị mạng']);
        $admin = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->get(route('admin.products.create'))
            ->assertOk()
            ->assertSee('Bấm để chọn ảnh, kéo thả ảnh vào đây, hoặc nhấn Ctrl+V để dán ảnh trực tiếp')
            ->assertSee('Xóa ảnh / Chọn lại');

        $response = $this->post(route('admin.products.store'), [
            'sku' => 'IMAGE-001',
            'name' => 'Switch kiểm thử',
            'category_id' => $category->id,
            'unit' => 'Cái',
            'min_stock_alert' => 1,
            'image' => UploadedFile::fake()->image('switch.jpg'),
        ]);

        $product = Product::where('sku', 'IMAGE-001')->firstOrFail();
        $this->assertStringStartsWith('products/', $product->image);
        Storage::disk('public')->assertExists($product->image);
        $response->assertRedirect(route('admin.products.show', $product));

        $imageUrl = '/storage/'.$product->image;
        $this->get(route('admin.products.index'))->assertOk()->assertSee($imageUrl);
        $this->get(route('admin.products.show', $product))->assertOk()->assertSee($imageUrl);
        $this->get(route('admin.products.edit', $product))
            ->assertOk()
            ->assertSee($imageUrl)
            ->assertSee('Bấm để chọn ảnh, kéo thả ảnh vào đây, hoặc nhấn Ctrl+V để dán ảnh trực tiếp')
            ->assertSee('Xóa ảnh / Chọn lại');
    }

    public function test_replacing_product_image_removes_old_file_and_keeps_old_image_when_no_new_file_is_uploaded(): void
    {
        $category = Category::create(['name' => 'Thiết bị mạng']);
        $product = Product::create([
            'sku' => 'IMAGE-002',
            'name' => 'Camera kiểm thử',
            'category_id' => $category->id,
            'unit' => 'Cái',
            'image' => UploadedFile::fake()->image('old.png')->store('products', 'public'),
        ]);
        $admin = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $oldImage = $product->image;

        $this->actingAs($admin)->put(route('admin.products.update', $product), [
            'sku' => $product->sku,
            'name' => $product->name,
            'category_id' => $category->id,
            'unit' => $product->unit,
            'min_stock_alert' => 0,
        ])->assertRedirect(route('admin.products.show', $product));

        $this->assertSame($oldImage, $product->fresh()->image);
        Storage::disk('public')->assertExists($oldImage);

        $this->put(route('admin.products.update', $product), [
            'sku' => $product->sku,
            'name' => $product->name,
            'category_id' => $category->id,
            'unit' => $product->unit,
            'min_stock_alert' => 0,
            'image' => UploadedFile::fake()->image('new.webp'),
        ])->assertRedirect(route('admin.products.show', $product));

        $newImage = $product->fresh()->image;
        $this->assertNotSame($oldImage, $newImage);
        Storage::disk('public')->assertMissing($oldImage);
        Storage::disk('public')->assertExists($newImage);
    }

    public function test_edit_can_remove_an_existing_product_image(): void
    {
        $category = Category::create(['name' => 'Thiết bị mạng']);
        $product = Product::create([
            'sku' => 'IMAGE-REMOVE',
            'name' => 'Camera cần xóa ảnh',
            'category_id' => $category->id,
            'unit' => 'Cái',
            'image' => UploadedFile::fake()->image('current.jpg')->store('products', 'public'),
        ]);
        $admin = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $oldImage = $product->image;

        $this->actingAs($admin)->put(route('admin.products.update', $product), [
            'sku' => $product->sku,
            'name' => $product->name,
            'category_id' => $category->id,
            'unit' => $product->unit,
            'min_stock_alert' => 0,
            'remove_image' => 1,
        ])->assertRedirect(route('admin.products.show', $product));

        $this->assertNull($product->fresh()->image);
        Storage::disk('public')->assertMissing($oldImage);
    }

    public function test_product_image_validation_rejects_unsupported_formats_and_files_over_five_megabytes(): void
    {
        $category = Category::create(['name' => 'Thiết bị mạng']);
        $admin = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $data = [
            'sku' => 'IMAGE-003',
            'name' => 'Router kiểm thử',
            'category_id' => $category->id,
            'unit' => 'Cái',
            'min_stock_alert' => 0,
        ];

        $this->actingAs($admin)->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $data + [
                'image' => UploadedFile::fake()->createWithContent(
                    'device.gif',
                    base64_decode('R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs='),
                ),
            ])
            ->assertSessionHasErrors('image');

        $this->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $data + [
                'image' => UploadedFile::fake()->image('large.jpg')->size(5121),
            ])
            ->assertSessionHasErrors('image');

        $this->assertDatabaseMissing('products', ['sku' => 'IMAGE-003']);
    }
}
