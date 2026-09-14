<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Hiển thị trang gửi đánh giá & danh sách TẤT CẢ phản hồi của khách hàng
     */
    public function index(): View
    {
        // Lấy tất cả đánh giá được duyệt/hiển thị, không phân biệt số sao, sắp xếp mới nhất
        $reviews = Review::visible()->latest()->paginate(10);
        $totalReviews = Review::visible()->count();
        $averageRating = Review::visible()->avg('rating') ?? 0;

        return view('reviews.index', compact('reviews', 'totalReviews', 'averageRating'));
    }

    /**
     * Lưu đánh giá mới từ người dùng
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email'         => 'nullable|email|max:255',
            'rating'        => 'required|integer|min:1|max:5',
            'comment'       => 'required|string|max:1000',
        ], [
            'customer_name.required' => 'Vui lòng nhập họ và tên của bạn.',
            'rating.required'        => 'Vui lòng chọn số sao đánh giá.',
            'rating.min'             => 'Đánh giá tối thiểu là 1 sao.',
            'rating.max'             => 'Đánh giá tối đa là 5 sao.',
            'comment.required'       => 'Vui lòng nhập nội dung phản hồi.',
        ]);

        Review::create([
            'customer_name' => $validated['customer_name'],
            'email'         => $validated['email'] ?? null,
            'rating'        => $validated['rating'],
            'comment'       => $validated['comment'],
            'is_visible'    => true,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã gửi phản hồi!');
    }
}