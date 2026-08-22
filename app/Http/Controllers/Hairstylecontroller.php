<?php

namespace App\Http\Controllers;

use App\Models\Hairstyle;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class HairstyleController extends Controller
{
    /**
     * Danh sách kiểu tóc, hỗ trợ tìm kiếm theo tên/mô tả và lọc theo độ khó.
     */
    public function index(Request $request): View
    {
        $hairstyles = collect();
        $search = trim((string) $request->query('q', ''));
        $difficulty = $request->query('difficulty');

        try {
            $hairstyles = Hairstyle::query()
                ->search($search)
                ->when($difficulty, fn ($query) => $query->where('difficulty', $difficulty))
                ->orderBy('name')
                ->get();
        } catch (QueryException $exception) {
            report($exception);
        }

        return view('hairstyles.index', [
            'hairstyles' => $hairstyles,
            'search' => $search,
            'difficulty' => $difficulty,
        ]);
    }

    /**
     * Chi tiết một kiểu tóc: mô tả, khuôn mặt phù hợp, độ khó, giá tham khảo.
     */
    public function show(string $slug): View
    {
        $hairstyle = Hairstyle::where('slug', $slug)->firstOrFail();

        $related = Hairstyle::where('id', '!=', $hairstyle->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('hairstyles.show', [
            'hairstyle' => $hairstyle,
            'related' => $related,
        ]);
    }
}