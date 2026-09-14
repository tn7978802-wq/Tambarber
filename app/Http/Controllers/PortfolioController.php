<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
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
            $portfolios = PortfolioItem::query()
                ->with('barber')
                ->when($category, fn ($query) => $query->where('category', $category))
                ->orderByDesc('is_featured')
                ->orderByDesc('id')
                ->get();
        } catch (QueryException $exception) {
            report($exception);
        }

        $categories = array_keys(PortfolioItem::CATEGORIES);

        return view('portfolio.index', [
            'portfolios' => $portfolios,
            'categories' => $categories,
            'selectedCategory' => $category,
        ]);
    }

    public function show(PortfolioItem $portfolioItem): View
    {
        $portfolioItem->load('barber');

        return view('portfolio.show', [
            'portfolio' => $portfolioItem,
            'related' => PortfolioItem::query()
                ->where('category', $portfolioItem->category)
                ->whereKeyNot($portfolioItem->id)
                ->orderByDesc('is_featured')
                ->orderByDesc('id')
                ->limit(4)
                ->get(),
        ]);
    }
}