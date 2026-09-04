@extends('layouts.admin')

@section('title', 'Quản lý liên hệ')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 py-4">
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-[0_10px_30px_rgba(0,0,0,0.45)]">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#8a641d]">Inbox</p>
                <h1 class="font-['Bebas_Neue'] text-3xl tracking-[0.08em] text-[#f2d788] uppercase">Quản lý liên hệ</h1>
            </div>
            <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] px-3 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-[#f4ecd8]">
                {{ $messages->total() }} tin nhắn
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-[4px] border border-[#3c2c15] bg-[#110d07] shadow-[0_10px_30px_rgba(0,0,0,0.35)]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#3c2c15] text-left text-sm">
                <thead class="bg-[#171008] text-[#f2d788] uppercase tracking-[0.12em] text-[10px]">
                    <tr>
                        <th class="px-4 py-3 font-bold">#</th>
                        <th class="px-4 py-3 font-bold">Họ tên</th>
                        <th class="px-4 py-3 font-bold">Email</th>
                        <th class="px-4 py-3 font-bold">SĐT</th>
                        <th class="px-4 py-3 font-bold">Nội dung</th>
                        <th class="px-4 py-3 font-bold">Thời gian</th>
                        <th class="px-4 py-3 font-bold text-right">Xem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#3c2c15] text-[#f4ecd8]">
                    @forelse ($messages as $message)
                        <tr class="hover:bg-[#171008] transition-colors">
                            <td class="px-4 py-3 text-[#6f6248]">{{ $message->id }}</td>
                            <td class="px-4 py-3 font-semibold text-[#f2d788]">{{ $message->name }}</td>
                            <td class="px-4 py-3 text-[#f4ecd8]">
                                <a href="mailto:{{ $message->email ?? '' }}" class="text-[#f2d788] hover:underline">
                                    {{ $message->email ?? '—' }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-[#f4ecd8]">{{ $message->phone }}</td>
                            <td class="px-4 py-3 max-w-[420px]">
                                <div class="line-clamp-2 text-[#f4ecd8]/80">
                                    {{ Illuminate\Support\Str::limit($message->message, 110) }}
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[#6f6248]">
                                {{ \Carbon\Carbon::parse($message->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.contact.show', $message->id) }}" class="inline-flex items-center gap-2 rounded-[2px] border border-[#8a641d] bg-[#251b0e] px-3 py-1.5 text-[11px] font-bold uppercase tracking-[0.08em] text-[#f2d788] transition hover:border-[#f2d788] hover:text-white">
                                        <i class="fa-solid fa-eye"></i>
                                        Xem
                                    </a>

                                    <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa tin nhắn này không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-[2px] border border-[#a8342f] bg-[#7c1f22]/30 px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-red-300 transition-all hover:bg-[#a8342f] hover:text-white">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                            <span>Xóa</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-[#6f6248]">
                                Chưa có tin nhắn nào được gửi tới.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($messages->hasPages())
        <div class="flex justify-center pt-2">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection
