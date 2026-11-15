<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\Project;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $categoryDescriptions = [
            'Thiết bị mạng' => 'Router, switch, access point và thiết bị truyền dẫn.',
            'Cáp mạng & cáp quang' => 'Cáp đồng, cáp quang và vật tư kết nối.',
            'Camera IP & đầu ghi' => 'Camera giám sát, đầu ghi NVR và phụ kiện CCTV.',
            'Phụ kiện thi công' => 'Đầu nối, dây rút, patch cord và vật tư lắp đặt.',
            'Dụng cụ & máy in nhãn' => 'Dụng cụ kỹ thuật và thiết bị nhận diện vật tư.',
        ];

        $categories = [];
        foreach ($categoryDescriptions as $name => $description) {
            $categories[$name] = Category::firstOrCreate(
                ['name' => $name],
                ['description' => $description],
            );
        }

        $supplier = Supplier::firstOrCreate(
            ['name' => 'Nhà cung cấp thiết bị mẫu'],
            [
                'contact_person' => 'Bộ phận kinh doanh',
                'phone' => '0900000000',
                'email' => 'sales@example.com',
                'address' => 'Địa chỉ mẫu - cập nhật theo nhà cung cấp thực tế',
                'notes' => 'Dữ liệu minh họa, thay bằng thông tin nhà cung cấp thực tế.',
            ],
        );

        $project = Project::firstOrCreate(
            ['code' => 'PRJ-DEMO'],
            [
                'name' => 'Dự án trang trại mẫu',
                'location' => 'Khu vực dự án - dữ liệu minh họa',
                'contact_person' => 'Nguyễn Văn Kỹ thuật',
                'phone' => '0910000000',
                'notes' => 'Dữ liệu minh họa, thay bằng dự án thực tế.',
            ],
        );

        $products = [
            ['sku' => 'SW-RG-001', 'name' => 'Switch PoE Ruijie 8 cổng', 'category' => 'Thiết bị mạng', 'brand' => 'Ruijie', 'unit' => 'Cái', 'stock' => 8, 'min' => 2, 'location' => 'Kệ A-01'],
            ['sku' => 'RT-CB-001', 'name' => 'Router Cambium cnPilot', 'category' => 'Thiết bị mạng', 'brand' => 'Cambium', 'unit' => 'Cái', 'stock' => 3, 'min' => 1, 'location' => 'Kệ A-02'],
            ['sku' => 'SFP-1G-001', 'name' => 'Module quang SFP 1G single-mode', 'category' => 'Thiết bị mạng', 'brand' => 'Cisco', 'unit' => 'Cái', 'stock' => 5, 'min' => 2, 'location' => 'Tủ linh kiện B-01'],
            ['sku' => 'CB-CAT6-001', 'name' => 'Cáp mạng Cat6 UTP', 'category' => 'Cáp mạng & cáp quang', 'brand' => 'CommScope', 'unit' => 'Cuộn', 'stock' => 8, 'min' => 2, 'location' => 'Kệ C-01'],
            ['sku' => 'CB-FO-001', 'name' => 'Cáp quang single-mode 4FO', 'category' => 'Cáp mạng & cáp quang', 'brand' => 'ComNet', 'unit' => 'Mét', 'stock' => 450, 'min' => 100, 'location' => 'Giá cáp C-02'],
            ['sku' => 'CAM-CP-001', 'name' => 'Camera IP dome 4MP', 'category' => 'Camera IP & đầu ghi', 'brand' => 'CP PLUS', 'unit' => 'Cái', 'stock' => 16, 'min' => 4, 'location' => 'Kệ D-01'],
            ['sku' => 'NVR-CP-001', 'name' => 'Đầu ghi NVR 16 kênh', 'category' => 'Camera IP & đầu ghi', 'brand' => 'CP PLUS', 'unit' => 'Cái', 'stock' => 2, 'min' => 1, 'location' => 'Kệ D-02'],
            ['sku' => 'RJ45-CAT6-001', 'name' => 'Đầu bấm RJ45 Cat6', 'category' => 'Phụ kiện thi công', 'brand' => 'Dintek', 'unit' => 'Hộp', 'stock' => 12, 'min' => 3, 'location' => 'Ngăn E-01'],
            ['sku' => 'TIE-200-001', 'name' => 'Dây rút nhựa 200 mm', 'category' => 'Phụ kiện thi công', 'brand' => 'Generic', 'unit' => 'Bịch', 'stock' => 4, 'min' => 2, 'location' => 'Ngăn E-02'],
            ['sku' => 'LBL-BR-001', 'name' => 'Máy in nhãn cầm tay M211', 'category' => 'Dụng cụ & máy in nhãn', 'brand' => 'Brady', 'unit' => 'Cái', 'stock' => 1, 'min' => 1, 'location' => 'Tủ dụng cụ F-01'],
        ];

        $productModels = [];
        foreach ($products as $data) {
            $categoryName = $data['category'];
            unset($data['category']);
            $stock = $data['stock'];
            unset($data['stock']);
            $minimum = $data['min'];
            unset($data['min']);

            $productModels[$data['sku']] = Product::firstOrCreate(
                ['sku' => $data['sku']],
                array_merge($data, [
                    'category_id' => $categories[$categoryName]->id,
                    'stock_quantity' => $stock,
                    'min_stock_alert' => $minimum,
                    'description' => 'Dữ liệu minh họa phục vụ kiểm thử ban đầu.',
                ]),
            );
        }

        $this->seedTransaction(
            code: 'PN-DEMO0001',
            type: InventoryTransaction::TYPE_IMPORT,
            name: $supplier->name,
            supplierId: $supplier->id,
            projectId: null,
            date: now()->subDays(10),
            quantities: [
                'SW-RG-001' => 10,
                'RT-CB-001' => 5,
                'SFP-1G-001' => 6,
                'CB-CAT6-001' => 10,
                'CB-FO-001' => 500,
                'CAM-CP-001' => 20,
                'NVR-CP-001' => 3,
                'RJ45-CAT6-001' => 15,
                'TIE-200-001' => 5,
                'LBL-BR-001' => 1,
            ],
            products: $productModels,
        );

        $this->seedTransaction(
            code: 'PX-DEMO0001',
            type: InventoryTransaction::TYPE_EXPORT,
            name: $project->name,
            supplierId: null,
            projectId: $project->id,
            date: now()->subDays(2),
            quantities: [
                'SW-RG-001' => 2,
                'RT-CB-001' => 2,
                'SFP-1G-001' => 1,
                'CB-CAT6-001' => 2,
                'CB-FO-001' => 50,
                'CAM-CP-001' => 4,
                'NVR-CP-001' => 1,
                'RJ45-CAT6-001' => 3,
                'TIE-200-001' => 1,
            ],
            products: $productModels,
        );
    }

    /**
     * @param  array<string, int|float>  $quantities
     * @param  array<string, Product>  $products
     */
    private function seedTransaction(
        string $code,
        string $type,
        string $name,
        ?int $supplierId,
        ?int $projectId,
        Carbon $date,
        array $quantities,
        array $products,
    ): void {
        $transaction = InventoryTransaction::firstOrCreate(
            ['transaction_code' => $code],
            [
                'type' => $type,
                'project_or_supplier_name' => $name,
                'supplier_id' => $supplierId,
                'project_id' => $projectId,
                'user_id' => null,
                'transaction_date' => $date,
                'note' => 'Phiếu mẫu được tạo từ InventorySeeder.',
                'status' => 'completed',
            ],
        );

        if (! $transaction->wasRecentlyCreated) {
            return;
        }

        foreach ($quantities as $sku => $quantity) {
            $transaction->items()->create([
                'product_id' => $products[$sku]->id,
                'quantity' => $quantity,
            ]);
        }
    }
}
