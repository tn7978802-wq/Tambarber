<?php

namespace Database\Seeders;

use App\Models\Barber;
use App\Models\PortfolioItem;
use Illuminate\Database\Seeder;

class PortfolioItemSeeder extends Seeder
{
    public function run(): void
    {
        $barberId = Barber::query()->value('id');

        $demo = [
            ['title' => 'Skin Fade gọn gàng', 'category' => 'fade', 'featured' => true],
            ['title' => 'Low Fade phong cách', 'category' => 'fade', 'featured' => false],
            ['title' => 'Tạo kiểu vuốt sáp bồng bềnh', 'category' => 'tao-kieu', 'featured' => true],
            ['title' => 'Undercut kết hợp tạo kiểu', 'category' => 'tao-kieu', 'featured' => false],
            ['title' => 'Cạo râu truyền thống bằng dao cạo', 'category' => 'cao-rau', 'featured' => false],
            ['title' => 'Tỉa gọn râu quai nón', 'category' => 'cao-rau', 'featured' => false],
            ['title' => 'Cắt tóc cho bé trai', 'category' => 'tre-em', 'featured' => false],
            ['title' => 'Buzz Cut cho bé', 'category' => 'tre-em', 'featured' => false],
            ['title' => 'Mullet cá tính', 'category' => 'khac', 'featured' => false],
            ['title' => 'Pompadour lịch lãm', 'category' => 'khac', 'featured' => true],
        ];

        foreach ($demo as $i => $d) {
            PortfolioItem::create([
                'title' => $d['title'],
                'description' => 'Tác phẩm thực hiện tại salon, khách hàng hài lòng với kết quả.',
                'category' => $d['category'],
                // Ảnh minh hoạ tạm thời — thay bằng ảnh thật của tiệm qua trang Admin.
                'image_after' => 'https://picsum.photos/seed/barber-after-' . $i . '/800/800',
                'image_before' => $i % 3 === 0 ? 'https://picsum.photos/seed/barber-before-' . $i . '/800/800' : null,
                'barber_id' => $barberId,
                'is_featured' => $d['featured'],
                'sort_order' => $i,
            ]);
        }
    }
}
