<?php

namespace Database\Seeders;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\Hairstyle;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===================== BARBERS =====================
        $barberTam = Barber::updateOrCreate(
            ['slug' => 'tam-barber'],
            [
                'name' => 'Tâm',
                'title' => 'Barber trưởng',
                'bio' => 'Hơn 8 năm kinh nghiệm, chuyên fade và tạo kiểu nam hiện đại.',
                'avatar' => '/images/shop-working.jpg',
                'years_experience' => 8,
                'is_active' => true,
            ]
        );

        $barberAn = Barber::updateOrCreate(
            ['slug' => 'an-barber'],
            [
                'name' => 'An',
                'title' => 'Thợ chính',
                'bio' => 'Chuyên cạo râu truyền thống và các kiểu tóc classic.',
                'avatar' => '/images/shop-interior.jpg',
                'years_experience' => 4,
                'is_active' => true,
            ]
        );

        // ===================== SERVICES =====================
        $servicesData = [
            ['name' => 'Cắt tóc', 'description' => 'Cắt và tạo kiểu theo yêu cầu.', 'price' => 80000, 'duration_minutes' => 30],
            ['name' => 'Cạo râu', 'description' => 'Cạo râu truyền thống bằng dao cạo.', 'price' => 50000, 'duration_minutes' => 20],
            ['name' => 'Gội đầu', 'description' => 'Gội đầu kết hợp massage thư giãn.', 'price' => 40000, 'duration_minutes' => 20],
            ['name' => 'Tạo kiểu', 'description' => 'Sấy tạo kiểu, vuốt keo/wax hoàn thiện.', 'price' => 30000, 'duration_minutes' => 15],
            ['name' => 'Combo cắt + gội + tạo kiểu', 'description' => 'Trọn gói cắt, gội và tạo kiểu.', 'price' => 130000, 'duration_minutes' => 60],
        ];

        foreach ($servicesData as $service) {
            Service::updateOrCreate(
                ['slug' => Str::slug($service['name'])],
                array_merge($service, [
                    'slug' => Str::slug($service['name']),
                    'image' => '/images/fade-cut-closeup.jpg',
                    'is_active' => true,
                ])
            );
        }

        // ===================== HAIRSTYLES =====================
        $hairstylesData = [
            [
                'name' => 'Fade',
                'description' => 'Tóc mờ dần từ chân tóc lên đỉnh, gọn gàng và dễ phối mọi kiểu tóc mái.',
                'suitable_face_shapes' => 'Vuông, Tròn, Trái xoan',
                'difficulty' => 'medium',
                'reference_price' => 100000,
            ],
            [
                'name' => 'Low Fade',
                'description' => 'Vùng fade bắt đầu thấp gần tai, tạo cảm giác nhẹ nhàng, lịch sự.',
                'suitable_face_shapes' => 'Trái xoan, Dài',
                'difficulty' => 'easy',
                'reference_price' => 90000,
            ],
            [
                'name' => 'Mid Fade',
                'description' => 'Vùng fade ở giữa đầu, cân bằng giữa cá tính và gọn gàng.',
                'suitable_face_shapes' => 'Vuông, Trái xoan',
                'difficulty' => 'medium',
                'reference_price' => 100000,
            ],
            [
                'name' => 'High Fade',
                'description' => 'Vùng fade cao sát đỉnh đầu, tạo độ tương phản mạnh và cá tính.',
                'suitable_face_shapes' => 'Tròn, Vuông',
                'difficulty' => 'hard',
                'reference_price' => 120000,
            ],
            [
                'name' => 'Undercut',
                'description' => 'Hai bên và sau cắt sát, phần trên để dài tạo điểm nhấn.',
                'suitable_face_shapes' => 'Trái xoan, Dài, Vuông',
                'difficulty' => 'medium',
                'reference_price' => 110000,
            ],
            [
                'name' => 'Pompadour',
                'description' => 'Tóc phía trước dựng cao, vuốt ngược ra sau, phong cách cổ điển.',
                'suitable_face_shapes' => 'Trái xoan, Tròn',
                'difficulty' => 'hard',
                'reference_price' => 130000,
            ],
            [
                'name' => 'Quiff',
                'description' => 'Tương tự Pompadour nhưng phần tóc trước ngắn và bồng bềnh hơn.',
                'suitable_face_shapes' => 'Trái xoan, Vuông',
                'difficulty' => 'medium',
                'reference_price' => 110000,
            ],
            [
                'name' => 'Mullet',
                'description' => 'Ngắn phía trước và hai bên, dài phía sau, cá tính và nổi bật.',
                'suitable_face_shapes' => 'Trái xoan, Dài',
                'difficulty' => 'hard',
                'reference_price' => 120000,
            ],
            [
                'name' => 'Buzz Cut',
                'description' => 'Cắt sát toàn bộ đầu bằng tông đơ, đơn giản và dễ chăm sóc.',
                'suitable_face_shapes' => 'Mọi khuôn mặt',
                'difficulty' => 'easy',
                'reference_price' => 70000,
            ],
            [
                'name' => 'Layer',
                'description' => 'Tóc cắt tỉa nhiều lớp tạo độ phồng và chuyển động tự nhiên.',
                'suitable_face_shapes' => 'Tròn, Vuông',
                'difficulty' => 'medium',
                'reference_price' => 100000,
            ],
            [
                'name' => 'Side Part',
                'description' => 'Rẽ ngôi lệch một bên, phong cách lịch lãm, phù hợp môi trường công sở.',
                'suitable_face_shapes' => 'Trái xoan, Vuông',
                'difficulty' => 'easy',
                'reference_price' => 90000,
            ],
        ];

        foreach ($hairstylesData as $hairstyle) {
            Hairstyle::updateOrCreate(
                ['slug' => Str::slug($hairstyle['name'])],
                array_merge($hairstyle, [
                    'slug' => Str::slug($hairstyle['name']),
                    'image' => '/images/fade-cut-closeup.jpg',
                ])
            );
        }

        // ===================== PORTFOLIO =====================
        $fadeHairstyle = Hairstyle::where('slug', 'fade')->first();

        Portfolio::updateOrCreate(
            ['title' => 'Fade gọn gàng cho khách nam'],
            [
                'title' => 'Fade gọn gàng cho khách nam',
                'image' => '/images/fade-cut-closeup.jpg',
                'category' => 'fade',
                'hairstyle_id' => $fadeHairstyle?->id,
                'barber_id' => $barberTam->id,
                'is_featured' => true,
            ]
        );

        Portfolio::updateOrCreate(
            ['title' => 'Không gian tiệm và khách đang chờ'],
            [
                'title' => 'Không gian tiệm và khách đang chờ',
                'image' => '/images/shop-interior.jpg',
                'category' => 'tao-kieu',
                'hairstyle_id' => null,
                'barber_id' => null,
                'is_featured' => true,
            ]
        );

        Portfolio::updateOrCreate(
            ['title' => 'Barber đang phục vụ khách'],
            [
                'title' => 'Barber đang phục vụ khách',
                'image' => '/images/shop-working.jpg',
                'category' => 'cao-rau',
                'hairstyle_id' => null,
                'barber_id' => $barberAn->id,
                'is_featured' => false,
            ]
        );

        // ===================== BLOG POSTS =====================
        $postsData = [
            [
                'title' => '10 kiểu tóc nam đẹp năm 2026',
                'excerpt' => 'Tổng hợp những kiểu tóc nam được yêu thích nhất trong năm nay.',
                'content' => 'Nội dung chi tiết về các kiểu tóc nam thịnh hành năm 2026, cách chọn kiểu phù hợp với khuôn mặt và phong cách sống...',
                'category' => 'kien-thuc',
            ],
            [
                'title' => 'Cách chọn kiểu tóc theo khuôn mặt',
                'excerpt' => 'Hướng dẫn xác định khuôn mặt và gợi ý kiểu tóc phù hợp.',
                'content' => 'Mỗi khuôn mặt (tròn, vuông, trái xoan, dài...) sẽ hợp với những kiểu tóc khác nhau. Bài viết hướng dẫn cách nhận biết khuôn mặt và chọn kiểu tóc tôn dáng...',
                'category' => 'huong-dan',
            ],
            [
                'title' => 'Fade là gì? Phân biệt Low, Mid, High Fade',
                'excerpt' => 'Giải thích khái niệm fade và sự khác nhau giữa các loại fade phổ biến.',
                'content' => 'Fade là kỹ thuật cắt tóc mờ dần độ dài từ chân tóc lên trên. Bài viết phân tích chi tiết Low Fade, Mid Fade, High Fade và cách chọn loại phù hợp...',
                'category' => 'kien-thuc',
            ],
            [
                'title' => 'Bao lâu nên cắt tóc một lần?',
                'excerpt' => 'Giải đáp thắc mắc về tần suất cắt tóc lý tưởng cho từng kiểu tóc.',
                'content' => 'Tần suất cắt tóc phụ thuộc vào kiểu tóc, tốc độ mọc tóc và nhu cầu giữ dáng. Thông thường nên cắt lại sau 3-5 tuần...',
                'category' => 'kien-thuc',
            ],
            [
                'title' => 'Cách chăm sóc tóc nam đúng cách',
                'excerpt' => 'Bí quyết giữ tóc khoẻ và kiểu tóc lâu đẹp giữa các lần cắt.',
                'content' => 'Chăm sóc tóc đúng cách giúp tóc chắc khoẻ và giữ nếp lâu hơn. Bài viết chia sẻ các bước gội đầu, dưỡng tóc và tạo kiểu hàng ngày...',
                'category' => 'huong-dan',
            ],
            [
                'title' => 'Những dụng cụ barber cần có',
                'excerpt' => 'Danh sách dụng cụ cơ bản cho người mới học nghề barber.',
                'content' => 'Tông đơ, kéo cắt, kéo tỉa, dao cạo, lược, khăn quấn cổ... là những dụng cụ không thể thiếu với một barber. Bài viết giới thiệu công dụng từng loại...',
                'category' => 'huong-dan',
            ],
            [
                'title' => 'Học nghề barber mất bao lâu?',
                'excerpt' => 'Lộ trình học nghề từ người mới đến khi trở thành barber chuyên nghiệp.',
                'content' => 'Thời gian học nghề barber phụ thuộc vào năng lực và mức độ luyện tập, thường mất từ 6 tháng đến 2 năm để thành thạo...',
                'category' => 'tin-tuc',
            ],
        ];

        foreach ($postsData as $post) {
            Post::updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                array_merge($post, [
                    'slug' => Str::slug($post['title']),
                    'thumbnail' => '/images/shop-interior.jpg',
                    'status' => 'published',
                    'publish_at' => now(),
                ])
            );
        }

        // ===================== REVIEWS =====================
        $reviewsData = [
            ['customer_name' => 'Minh Khang', 'rating' => 5, 'comment' => 'Cắt đẹp, thợ tư vấn nhiệt tình, không gian thoải mái.'],
            ['customer_name' => 'Quốc Bảo', 'rating' => 5, 'comment' => 'Fade cực gọn, đúng ý mình, sẽ quay lại tiệm.'],
            ['customer_name' => 'Thành Đạt', 'rating' => 4, 'comment' => 'Dịch vụ tốt, giá hợp lý, chỉ hơi đông vào cuối tuần.'],
        ];

        foreach ($reviewsData as $review) {
            Review::updateOrCreate(
                ['customer_name' => $review['customer_name'], 'comment' => $review['comment']],
                array_merge($review, ['is_visible' => true])
            );
        }

        // ===================== SAMPLE BOOKING =====================
        $service = Service::first();
        if ($service) {
            Booking::updateOrCreate(
                ['booking_code' => 'BAR-DEMO0001'],
                [
                    'customer_name' => 'Khách demo',
                    'customer_phone' => '0900000000',
                    'customer_email' => null,
                    'service_id' => $service->id,
                    'barber_id' => $barberTam->id,
                    'booking_date' => now()->addDay()->toDateString(),
                    'booking_time' => '14:00',
                    'note' => 'Đặt lịch mẫu để kiểm tra giao diện.',
                    'status' => 'pending',
                ]
            );
        }
    }
}