@extends('layouts.admin')

@section('title', 'Quản lý Barber - Tâm Barbershop Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4">

    <!-- HEADER SECTION -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
         style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex items-center gap-3 mb-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                <i class="fa-solid fa-[#f2d788] fa-user-gear text-xs"></i>
            </span>
            <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase">
                Quản Lý Đội Ngũ Barber
            </h1>
        </div>
        <p class="text-xs text-[#f4ecd8]/70 pl-11">
            Quản lý danh sách thợ cắt tóc, thông tin kinh nghiệm, cập nhật ảnh đại diện và bật/tắt trạng thái hoạt động đặt lịch của thợ.
        </p>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- CREATE BARBER FORM CARD -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 sm:p-8 shadow-2xl relative overflow-hidden transition-all duration-300 hover:border-[#a8342f]/50">
        
        <div class="flex items-center gap-2 mb-6 border-b border-[#3c2c15] pb-3">
            <i class="fa-solid fa-[#f2d788] fa-user-plus text-[#a8342f] text-sm"></i>
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">
                Thêm Barber Mới
            </h2>
        </div>

        <form action="{{ route('admin.barbers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Grid 3 Cột: Tên, Chức danh, Kinh nghiệm -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                
                <!-- Barber Name -->
                <div class="space-y-1.5">
                    <label for="name" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Tên Barber <span class="text-[#a8342f]">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Ví dụ: Hoàng Tâm"
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                </div>

                <!-- Title -->
                <div class="space-y-1.5">
                    <label for="title" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Chức danh
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Ví dụ: Master Barber / Senior Style"
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                </div>

                <!-- Experience -->
                <div class="space-y-1.5">
                    <label for="years_experience" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Số năm kinh nghiệm
                    </label>
                    <input type="number" id="years_experience" name="years_experience" min="0" max="80" value="{{ old('years_experience') }}" placeholder="Số năm (ví dụ: 5)"
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                </div>
            </div>

            <!-- Avatar Image Picker -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                    Ảnh đại diện
                </label>
                <div class="relative flex items-center gap-3">
                    <label for="avatar-input" 
                           class="cursor-pointer inline-flex items-center gap-2 rounded-[2px] border border-[#8a641d] bg-[#070503] px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-[#f2d788] transition-all hover:bg-[#8a641d] hover:text-[#0b0805]">
                        <i class="fa-solid fa-image"></i>
                        <span>➕ Chọn ảnh đại diện (không bắt buộc)</span>
                    </label>
                    <input type="file" id="avatar-input" name="avatar" accept="image/*" class="hidden" 
                           onchange="document.getElementById('avatar-filename').textContent = this.files[0] ? this.files[0].name : '';">
                    <span id="avatar-filename" class="text-xs text-[#6f6248] italic truncate max-w-[250px]"></span>
                </div>
            </div>

            <!-- Bio -->
            <div class="space-y-1.5">
                <label for="bio" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                    Giới thiệu / Tiểu sử
                </label>
                <textarea id="bio" name="bio" rows="3" placeholder="Đôi nét về phong cách cắt, sở trường hoặc châm ngôn nghề nghiệp..."
                          class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] p-4 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">{{ old('bio') }}</textarea>
            </div>

            <!-- Status Checkbox & Submit Button -->
            <div class="pt-3 flex flex-wrap items-center justify-between gap-4 border-t border-[#3c2c15]/60">
                <label class="inline-flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked 
                           class="h-4 w-4 rounded-[2px] border-[#3c2c15] bg-[#070503] text-[#a8342f] focus:ring-0 focus:ring-offset-0">
                    <span class="text-xs font-semibold text-[#f4ecd8] flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-check text-xs text-emerald-500"></i>
                        Đang hoạt động (hiển thị cho khách đặt lịch)
                    </span>
                </label>

                <button type="submit" 
                        class="inline-flex items-center gap-2 rounded-[2px] border border-[#f2d788]/60 bg-gradient-to-r from-[#7c1f22] via-[#cf9f3f] to-[#8a641d] px-8 py-2.5 text-xs font-bold uppercase tracking-[0.15em] text-[#f4ecd8] shadow-[0_0_15px_rgba(124,31,34,0.4)] transition-all hover:brightness-125 hover:shadow-[0_0_25px_rgba(168,52,47,0.6)] active:scale-[0.98]">
                    <i class="fa-solid fa-user-plus text-[10px]"></i>
                    <span>Thêm Barber</span>
                </button>
            </div>
        </form>
    </div>

    <!-- BARBERS TABLE LIST -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-4">
        
        <div class="flex items-center justify-between border-b border-[#3c2c15] pb-3">
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase flex items-center gap-2">
                <i class="fa-solid fa-users text-xs text-[#a8342f]"></i>
                Danh Sách Barber
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#f4ecd8]/90">
                <thead class="border-b border-[#3c2c15] bg-[#070503] text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">
                    <tr>
                        <th class="py-3 px-4">Ảnh</th>
                        <th class="py-3 px-4">Tên Barber</th>
                        <th class="py-3 px-4">Chức danh</th>
                        <th class="py-3 px-4">Kinh nghiệm</th>
                        <th class="py-3 px-4">Trạng thái</th>
                        <th class="py-3 px-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#3c2c15]/50">
                    @forelse ($barbers as $barber)
                        <tr class="hover:bg-[#171008] transition-colors">
                            <!-- Avatar -->
                            <td class="py-3 px-4">
                                @if ($barber->avatar)
                                    <div class="h-12 w-12 rounded-full overflow-hidden border border-[#8a641d] bg-[#070503] shadow-md">
                                        <img src="{{ $barber->avatar }}" alt="{{ $barber->name }}" class="h-full w-full object-cover">
                                    </div>
                                @else
                                    <div class="h-12 w-12 rounded-full border border-[#3c2c15] bg-[#070503] flex items-center justify-center text-[#6f6248]">
                                        <i class="fa-solid fa-user-scissors text-sm"></i>
                                    </div>
                                @endif
                            </td>

                            <!-- Name -->
                            <td class="py-3 px-4 font-bold text-[#f2d788]">
                                {{ $barber->name }}
                            </td>

                            <!-- Title -->
                            <td class="py-3 px-4 text-[#f4ecd8]/80">
                                {{ $barber->title ?? '—' }}
                            </td>

                            <!-- Experience -->
                            <td class="py-3 px-4 font-semibold text-[#f4ecd8]/90">
                                {{ $barber->years_experience ? $barber->years_experience . ' năm' : '—' }}
                            </td>

                            <!-- Status -->
                            <td class="py-3 px-4">
                                @if ($barber->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-emerald-500/30 bg-emerald-950/40 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        Đang hoạt động
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-[#3c2c15] bg-[#070503] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#6f6248]"></span>
                                        Đang nghỉ phép
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-4 text-right space-x-2 whitespace-nowrap">
                                <!-- Quick Toggle Status Form -->
                                <form action="{{ route('admin.barbers.update', $barber) }}" method="POST" class="inline-block">
                                    @csrf 
                                    @method('PUT')
                                    <input type="hidden" name="name" value="{{ $barber->name }}">
                                    <input type="hidden" name="title" value="{{ $barber->title }}">
                                    <input type="hidden" name="years_experience" value="{{ $barber->years_experience }}">
                                    <input type="hidden" name="bio" value="{{ $barber->bio }}">
                                    <input type="hidden" name="is_active" value="{{ $barber->is_active ? 0 : 1 }}">
                                    
                                    @if ($barber->is_active)
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 rounded-[2px] border border-[#8a641d] bg-[#070503] px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-[#f2d788] transition-all hover:bg-[#8a641d] hover:text-[#0b0805]">
                                            <i class="fa-solid fa-pause text-[10px]"></i>
                                            <span>Tạm ngưng</span>
                                        </button>
                                    @else
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 rounded-[2px] border border-emerald-600 bg-emerald-950/50 px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-emerald-300 transition-all hover:bg-emerald-600 hover:text-white">
                                            <i class="fa-solid fa-play text-[10px]"></i>
                                            <span>Kích hoạt</span>
                                        </button>
                                    @endif
                                </form>

                                <!-- Delete Form -->
                                <form action="{{ route('admin.barbers.destroy', $barber) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xoá barber này?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1 rounded-[2px] border border-[#a8342f] bg-[#7c1f22]/30 px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-red-300 transition-all hover:bg-[#a8342f] hover:text-white">
                                        <i class="fa-solid fa-trash text-[10px]"></i>
                                        <span>Xoá</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#6f6248] italic">
                                <i class="fa-solid fa-user-slash text-2xl mb-2 block"></i>
                                Chưa có thông tin barber nào trong hệ thống.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-4 border-t border-[#3c2c15]">
            {{ $barbers->links() }}
        </div>
    </div>

</div>
@endsection