<?php

namespace App\Http\Controllers;

use App\Models\Hairstyle;
use App\Models\Post;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredHairstyles = collect();
        $services = collect();
        $reviews = collect();
        $latestPosts = collect();

        try {
            $featuredHairstyles = Hairstyle::query()->orderByDesc('id')->limit(6)->get();
            $services = Service::active()->orderBy('name')->limit(4)->get();
            $reviews = Review::visible()->latest()->limit(6)->get();
            $latestPosts = Post::published()->orderByDesc('publish_at')->limit(3)->get();
        } catch (QueryException $exception) {
            report($exception);
        }

        return view('home', [
            'featuredHairstyles' => $featuredHairstyles,
            'services' => $services,
            'reviews' => $reviews,
            'latestPosts' => $latestPosts,
        ]);
    }
}
