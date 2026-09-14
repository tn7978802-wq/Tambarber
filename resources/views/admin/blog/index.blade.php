@extends('layouts.admin')

@section('title', 'Góc chia sẻ')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#6f6248]">Quản trị nội dung</p>
            <h1 class="font-['Bebas_Neue'] text-4xl sm:text-5xl tracking-wider text-[#f2d788] uppercase">Góc chia sẻ</h1>
        </div>

        <a href="{{ route('admin.blog.create') }}" class="inline-flex items-center gap-2 rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#0b0805] shadow-md hover:brightness-110 transition-all">
            <i class="fa-solid fa-plus"></i>
            Thêm bài viết
        </a>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-[2px] border border-[#8a641d] bg-[#251b0e] px-4 py-3 text-sm text-[#f2d788]">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-[2px] border border-[#3c2c15] bg-[#171008] shadow-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-[#0b0805] text-[#6f6248] uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="px-4 py-3">Tiêu đề</th>
                        <th class="px-4 py-3">Danh mục</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3">Ngày đăng</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr class="border-t border-[#3c2c15] align-top">
                            <td class="px-4 py-4">
                                <div class="font-semibold text-[#f4ecd8]">{{ $post->title }}</div>
                                <div class="mt-1 text-[11px] text-[#6f6248]">{{ $post->slug }}</div>
                            </td>
                            <td class="px-4 py-4 text-[#f4ecd8]">
                                {{ $post->category ?? 'Chung' }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-[2px] border px-2 py-1 text-[10px] font-bold uppercase tracking-wider {{
                                    $post->status === 'published' ? 'border-[#8a641d] bg-[#251b0e] text-[#f2d788]' :
                                    ($post->status === 'scheduled' ? 'border-[#8a641d] bg-[#0f1b1d] text-[#8ad9d7]' : 'border-[#3c2c15] bg-[#0b0805] text-[#6f6248]')
                                }}">
                                    {{ $post->status === 'published' ? 'Đã đăng' : ($post->status === 'scheduled' ? 'Chờ xuất bản' : 'Nháp') }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-[#f4ecd8]">
                                {{ $post->publish_at ? $post->publish_at->format('d/m/Y H:i') : '—' }}
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.blog.edit', $post) }}" class="rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-2.5 py-1.5 text-[11px] font-bold uppercase tracking-wider text-[#f4ecd8] hover:border-[#8a641d] hover:text-[#f2d788] transition-all">
                                        Sửa
                                    </a>

                                    <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-[2px] border border-red-900/60 bg-red-950/40 px-2.5 py-1.5 text-[11px] font-bold uppercase tracking-wider text-red-300 hover:bg-red-900/60 hover:text-red-100 transition-all">
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-[#6f6248]">
                                Chưa có bài viết nào trong Góc chia sẻ.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</div>
@endsection
