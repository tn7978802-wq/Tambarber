<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    // Trang công khai: Thư viện tác phẩm (Portfolio)
    public function index(Request $request)
    {
        $category = $request->query('danh-muc', 'tat-ca');

        $items = PortfolioItem::query()
            ->category($category)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = PortfolioItem::CATEGORIES;

        return view('portfolio.index', compact('items', 'categories', 'category'));
    }
}
