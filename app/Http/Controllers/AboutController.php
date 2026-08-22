<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;

class AboutController extends Controller
{
    /**
     * Trang "Giới thiệu": về nghề barber, lộ trình học nghề, kỹ năng cần thiết,
     * cùng danh sách các barber đang làm việc tại tiệm.
     */
    public function index(): View
    {
        $barbers = collect();

        try {
            $barbers = Barber::where('is_active', true)
                ->orderByDesc('years_experience')
                ->get();
        } catch (QueryException $exception) {
            report($exception);
        }

        // Nội dung lộ trình học nghề, có thể chuyển sang bảng "settings" hoặc CMS sau này.
        $careerPath = [
            [
                'step' => 'Người mới bắt đầu',
                'description' => 'Học cách cầm kéo, tông đơ, gội đầu, phụ việc và làm quen dụng cụ nghề.',
            ],
            [
                'step' => 'Thợ phụ',
                'description' => 'Thực hành cắt các kiểu cơ bản, cạo râu, chăm sóc khách dưới sự hướng dẫn của thợ chính.',
            ],
            [
                'step' => 'Thợ chính',
                'description' => 'Tự tin nhận khách, tạo kiểu phức tạp, tư vấn kiểu tóc phù hợp khuôn mặt.',
            ],
            [
                'step' => 'Barber chuyên nghiệp',
                'description' => 'Xây dựng thương hiệu cá nhân, đào tạo thợ mới, có thể mở tiệm riêng.',
            ],
        ];

        $skills = [
            'Sử dụng thành thạo kéo, tông đơ, dao cạo',
            'Con mắt thẩm mỹ, khả năng tư vấn theo khuôn mặt',
            'Kỹ năng giao tiếp, chăm sóc khách hàng',
            'Kiên nhẫn và tỉ mỉ trong từng đường cắt',
            'Cập nhật xu hướng tóc liên tục',
        ];

        return view('about', [
            'barbers' => $barbers,
            'careerPath' => $careerPath,
            'skills' => $skills,
        ]);
    }
}