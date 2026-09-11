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
