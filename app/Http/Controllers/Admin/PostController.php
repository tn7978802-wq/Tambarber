<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Support\Traits\HandlesImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    use HandlesImageUpload;

    public function index(): View
    {
        Post::syncScheduledStatuses();

        $posts = Post::query()
            ->latest('publish_at')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.blog.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.blog.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:draft,scheduled,published'],
            'publish_at' => ['nullable', 'date'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,gif', 'max:5120'],
        ]);

        $slug = trim((string) ($data['slug'] ?? $data['title']));
        $slug = Str::slug($slug) ?: 'bai-viet';
        $base = $slug;
        $index = 2;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $index;
            $index++;
        }

        $data['slug'] = $slug;
        $data['status'] = $data['status'] ?? 'draft';

        if ($data['status'] === 'published') {
            $data['publish_at'] = $data['publish_at'] ?? now();
        } elseif ($data['status'] === 'scheduled') {
            $data['publish_at'] = $data['publish_at'] ?? now();
        } else {
            $data['publish_at'] = $data['publish_at'] ?? null;
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->storeUploadedImage($request, 'thumbnail', 'uploads/posts');
        }

        Post::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Đã lưu bài viết vào Góc chia sẻ.');
    }

    public function edit(Post $blog): View
    {
        return view('admin.blog.edit', [
            'post' => $blog,
        ]);
    }

    public function update(Request $request, Post $blog): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug,' . $blog->id],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:draft,scheduled,published'],
            'publish_at' => ['nullable', 'date'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,gif', 'max:5120'],
        ]);

        $slug = trim((string) ($data['slug'] ?? $data['title']));
        $slug = Str::slug($slug) ?: 'bai-viet';
        $base = $slug;
        $index = 2;

        while (Post::where('slug', $slug)->whereKeyNot($blog->id)->exists()) {
            $slug = $base . '-' . $index;
            $index++;
        }

        $data['slug'] = $slug;
        $data['status'] = $data['status'] ?? $blog->status;

        if ($data['status'] === 'published') {
            $data['publish_at'] = $data['publish_at'] ?? $blog->publish_at ?? now();
        } elseif ($data['status'] === 'scheduled') {
            $data['publish_at'] = $data['publish_at'] ?? $blog->publish_at ?? now();
        } else {
            $data['publish_at'] = $data['publish_at'] ?? $blog->publish_at ?? null;
        }

        if ($request->hasFile('thumbnail')) {
            if ($blog->thumbnail && ! str_starts_with((string) $blog->thumbnail, 'http')) {
                Storage::disk('public')->delete($blog->thumbnail);
            }
            $data['thumbnail'] = $this->storeUploadedImage($request, 'thumbnail', 'uploads/posts');
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Đã cập nhật bài viết.');
    }

    public function destroy(Post $blog): RedirectResponse
    {
        if ($blog->thumbnail && ! str_starts_with((string) $blog->thumbnail, 'http')) {
            Storage::disk('public')->delete($blog->thumbnail);
        }

        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Đã xóa bài viết khỏi Góc chia sẻ.');
    }
}
