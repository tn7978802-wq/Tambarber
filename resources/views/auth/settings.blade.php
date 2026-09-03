@extends('layouts.admin')

@section('title', 'Cài đặt Tài khoản Quản lý Tối cao')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- HEADER TITLE -->
    <div class="flex items-center justify-between border-b border-[#3c2c15] pb-4">
        <div>
            <h1 class="font-['Bebas_Neue'] text-4xl tracking-wider text-[#f2d788] flex items-center gap-3">
                <i class="fa-solid fa-gear text-2xl text-[#a8342f] animate-spin-slow"></i> 
                Cài Đặt Tài Khoản
            </h1>
            <p class="text-xs text-[#6f6248] uppercase tracking-widest mt-1">Thay đổi ảnh đại diện và mật khẩu</p>
        </div>
        <a href="{{ url()->previous() }}" class="text-xs font-bold uppercase tracking-wider text-[#f2d788] hover:underline flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- SECTION 1: AVATAR & THÔNG TIN CƠ BẢN -->
        <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-6 shadow-gold-panel">
            <h2 class="font-['Bebas_Neue'] text-2xl text-[#f2d788] mb-6 border-b border-[#3c2c15] pb-2 flex items-center gap-2">
                <i class="fa-solid fa-user-gear text-sm text-[#8a641d]"></i> Thông tin & Ảnh Đại Diện
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <!-- AVATAR PREVIEW -->
                <div class="flex flex-col items-center justify-center space-y-3">
                    <div class="relative group">
                        <img id="avatarPreview" 
                             src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=7c1f22&color=f2d788' }}" 
                             alt="Avatar" 
                             class="h-32 w-32 rounded-full border-2 border-[#8a641d] object-cover shadow-[0_0_20px_rgba(207,159,63,0.3)]">
                        <label for="avatar" class="absolute inset-0 flex items-center justify-center rounded-full bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                            <i class="fa-solid fa-camera text-2xl text-[#f2d788]"></i>
                        </label>
                    </div>
                    <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewImage(event)">
                    <span class="text-[10px] text-[#6f6248] uppercase tracking-wider">Nhấp để tải ảnh lên (PNG, JPG)</span>
                </div>

                <!-- INPUT FIELDS -->
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] mb-1">Họ và Tên</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                               class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] mb-1">Email Chủ Tiệm</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                               class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] mb-1">Số Điện Thoại</label>
                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                               class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: ĐỔI MẬT KHẨU TỐI CAO (MASTER PASSWORD) -->
        <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-6 shadow-gold-panel">
            <h2 class="font-['Bebas_Neue'] text-2xl text-[#a8342f] mb-6 border-b border-[#3c2c15] pb-2 flex items-center gap-2">
                <i class="fa-solid fa-key text-sm text-[#a8342f]"></i> Thay Đổi Mật Khẩu (Master Password)
            </h2>

            <div class="space-y-4 max-w-xl">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] mb-1">Mật khẩu hiện tại</label>
                    <input type="password" name="current_password" placeholder="••••••••"
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] mb-1">Mật khẩu mới</label>
                        <input type="password" name="password" placeholder="••••••••"
                               class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] mb-1">Xác nhận mật khẩu mới</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••"
                               class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none">
                    </div>
                </div>
                <p class="text-[11px] text-[#6f6248]">Có thể để trống nếu bạn không có nhu cầu thay đổi.</p>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="flex items-center justify-end gap-4">
            <button type="submit" class="rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-6 py-2.5 text-xs font-extrabold uppercase tracking-widest text-[#0b0805] shadow transition-all hover:brightness-110 active:scale-95">
                <i class="fa-solid fa-floppy-disk mr-1.5"></i> Lưu
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('avatarPreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection