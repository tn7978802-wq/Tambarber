<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;

class BlogController extends Controller
{
    /**
     * Danh sách bài viết đã xuất bản (kiến thức về tóc, xu hướng, hướng dẫn học nghề...).
     */
    public function index(): View
    {
        $posts = collect();

        try {
            $posts = Post::published()
                ->orderByDesc('publish_at')
                ->paginate(9);
        } catch (QueryException $exception) {
            report($exception);
        }

        return view('blog.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Chi tiết bài viết.
     */
    public function show(string $slug): View
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->latest('publish_at')
            ->limit(3)
            ->get();

        return view('blog.show', [
            'post' => $post,
            'related' => $related,
        ]);
    }
}