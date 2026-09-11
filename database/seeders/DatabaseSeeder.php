<?php

namespace Database\Seeders;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\Hairstyle;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::updateOrCreate(
            ['email' => 'khach@barbershop.vn'],
            [
                'fullname' => 'KH1',
                'password' => Hash::make('password'),
                'phone' => '0900000003',
                'admin_role' => User::ROLE_CLIENT,
            ]
        );
        // ===================== BARBERS =====================
        $barberTam = Barber::updateOrCreate(
            ['slug' => 'Tâm'],
            [
                'name' => 'Tâm',
                'title' => 'Barber chuyên nghiệp',
                'bio' => 'Hơn 4 năm kinh nghiệm, chuyên fade và tạo kiểu nam hiện đại.',
                'avatar' => '/images/shop-working.jpg',
                'years_experience' => 4,
                'is_active' => true,
            ]
        );

        // ===================== SERVICES =====================
        $servicesData = [
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
                'barber_id' => $barberTam->id,
                'is_featured' => false,
            ]
        );

        // ===================== BLOG POSTS =====================
        $postsData = [
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
                    'user_id' => $customer->id,
                    'customer_name' => $customer->fullname,
                    'customer_phone' => $customer->phone,
                    'customer_email' => $customer->email,
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
