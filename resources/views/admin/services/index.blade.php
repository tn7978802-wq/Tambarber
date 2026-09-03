@extends('layouts.admin')

@section('title', 'Quản lý Dịch vụ - Tâm Barbershop Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4">

    <!-- HEADER SECTION -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
         style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex items-center gap-3 mb-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                <i class="fa-solid fa-[#f2d788] fa-concierge-bell text-xs"></i>
            </span>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a8342f]">Quản trị hệ thống</span>
                <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase leading-tight">
                    Quản Lý Dịch Vụ
                </h1>
            </div>
        </div>
        <p class="text-xs text-[#f4ecd8]/70 pl-11">
            Quản lý bảng giá, thời gian thực hiện dịch vụ, cập nhật hình ảnh minh hoạ và thiết lập trạng thái ẩn/hiện dịch vụ.
        </p>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- CREATE SERVICE FORM CARD -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 sm:p-8 shadow-2xl relative overflow-hidden transition-all duration-300 hover:border-[#a8342f]/50">
        
        <div class="flex items-center gap-2 mb-6 border-b border-[#3c2c15] pb-3">
            <i class="fa-solid fa-[#f2d788] fa-plus text-[#a8342f] text-sm"></i>
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">
                Thêm Dịch Vụ Mới
            </h2>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Grid 3 Cột: Tên dịch vụ, Giá, Thời gian -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                
                <!-- Service Name -->
                <div class="space-y-1.5">
                    <label for="name" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Tên dịch vụ <span class="text-[#a8342f]">*</span>
                    </label>
                    <input type="text" id="name" name="name" placeholder="Ví dụ: Combo cắt + gội + tạo kiểu" required
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                </div>

                <!-- Price -->
                <div class="space-y-1.5">
                    <label for="price" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Giá dịch vụ (VND) <span class="text-[#a8342f]">*</span>
                    </label>
                    <input type="number" id="price" name="price" placeholder="Ví dụ: 130000" required
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                </div>

                <!-- Duration -->
                <div class="space-y-1.5">
                    <label for="duration_minutes" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                        Thời gian (Phút) <span class="text-[#a8342f]">*</span>
                    </label>
                    <input type="number" id="duration_minutes" name="duration_minutes" placeholder="Ví dụ: 45" required
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-1.5">
                <label for="description" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                    Mô tả dịch vụ
                </label>
                <textarea id="description" name="description" rows="3" placeholder="Chi tiết quy trình thực hiện, các bước tư vấn hoặc hoá chất sử dụng..."
                          class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] p-4 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all"></textarea>
            </div>

            <!-- Image Picker -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                    Hình ảnh minh hoạ
                </label>
                <div class="relative flex items-center gap-3">
                    <label for="service-image-input" 
                           class="cursor-pointer inline-flex items-center gap-2 rounded-[2px] border border-[#8a641d] bg-[#070503] px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-[#f2d788] transition-all hover:bg-[#8a641d] hover:text-[#0b0805]">
                        <i class="fa-solid fa-file-image"></i>
                        <span>➕ Chọn ảnh từ máy</span>
                    </label>
                    <input type="file" id="service-image-input" name="image" accept="image/*" class="hidden" 
                           onchange="document.getElementById('service-image-filename').textContent = this.files[0] ? this.files[0].name : '';">
                    <span id="service-image-filename" class="text-xs text-[#6f6248] italic truncate max-w-[250px]"></span>
                </div>
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
                    <i class="fa-solid fa-plus text-[10px]"></i>
                    <span>Thêm Dịch Vụ</span>
                </button>
            </div>
        </form>
    </div>

    <!-- SERVICES TABLE LIST -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-4">
        
        <div class="flex items-center justify-between border-b border-[#3c2c15] pb-3">
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase flex items-center gap-2">
                <i class="fa-solid fa-list-check text-xs text-[#a8342f]"></i>
                Danh Sách Dịch Vụ
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#f4ecd8]/90">
                <thead class="border-b border-[#3c2c15] bg-[#070503] text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">
                    <tr>
                        <th class="py-3 px-4">Ảnh</th>
                        <th class="py-3 px-4">Tên dịch vụ</th>
                        <th class="py-3 px-4">Giá</th>
                        <th class="py-3 px-4">Thời gian</th>
                        <th class="py-3 px-4">Trạng thái</th>
                        <th class="py-3 px-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#3c2c15]/50">
                    @forelse ($services as $service)
                        <tr class="hover:bg-[#171008] transition-colors">
                            <!-- Image -->
                            <td class="py-3 px-4">
                                @if ($service->image)
                                    <div class="h-12 w-16 overflow-hidden rounded-[2px] border border-[#3c2c15] bg-[#070503]">
                                        <img src="{{ $service->image }}" alt="{{ $service->name }}" class="h-full w-full object-cover">
                                    </div>
                                @else
                                    <span class="text-[#6f6248] italic text-[11px]">Không ảnh</span>
                                @endif
                            </td>

                            <!-- Name -->
                            <td class="py-3 px-4 font-bold text-[#f2d788]">
                                {{ $service->name }}
                            </td>

                            <!-- Price -->
                            <td class="py-3 px-4 font-semibold text-[#f2d788]">
                                {{ number_format((float) $service->price, 0, ',', '.') }}đ
                            </td>

                            <!-- Duration -->
                            <td class="py-3 px-4 text-[#f4ecd8]/80 font-medium">
                                {{ $service->duration_minutes }} phút
                            </td>

                            <!-- Status Badge -->
                            <td class="py-3 px-4">
                                @if ($service->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-emerald-500/30 bg-emerald-950/40 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        Hoạt động
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-[#3c2c15] bg-[#070503] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#6f6248]"></span>
                                        Tạm ẩn
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xoá dịch vụ này?')">
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
                                <i class="fa-solid fa-concierge-bell text-2xl mb-2 block"></i>
                                Chưa có dịch vụ nào trong hệ thống.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-4 border-t border-[#3c2c15]">
            {{ $services->links() }}
        </div>
    </div>

</div>
@endsection