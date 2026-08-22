<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Gallery / Portfolio: ảnh trước - sau, fade, tạo kiểu, cạo râu, cắt cho trẻ em...
     * Hỗ trợ lọc theo category.
     */
    public function index(Request $request): View
    {
        $portfolios = collect();
        $category = $request->query('category');

        try {
            $portfolios = Portfolio::query()
                ->with(['hairstyle', 'barber'])
                ->when($category, fn ($query) => $query->where('category', $category))
                ->orderByDesc('is_featured')
                ->orderByDesc('id')
                ->get();
        } catch (QueryException $exception) {
            report($exception);
        }

        $categories = ['fade', 'tao-kieu', 'cao-rau', 'tre-em'];

        return view('portfolio.index', [
            'portfolios' => $portfolios,
            'categories' => $categories,
            'selectedCategory' => $category,
        ]);
    }
}