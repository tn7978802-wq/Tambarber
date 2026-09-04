@extends('layouts.app')

@section('title', 'Liên hệ - Barbershop')

@section('content')

    <div class="max-w-6xl mx-auto px-4 py-4">
        <!-- Eyebrow & Tiêu đề -->
        <span class="text-xs uppercase tracking-widest text-[#6f6248] font-medium block mb-1">Ghé thăm chúng tôi</span>
        <h1 class="text-4xl font-bold text-[#f2d788] uppercase tracking-wide mb-3">Liên hệ</h1>
        
        <!-- Pole Divider -->
        <div class="h-1 w-28 mb-8 rounded-full bg-[repeating-linear-gradient(-45deg,#7c1f22_0_14px,#f4ecd8_14px_28px,#171008_28px_42px)] shadow-md"></div>

        <!-- Bố cục 2 cột -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            
            <!-- Cột trái: Thông tin & Bản đồ -->
            <section class="space-y-6">
                <div class="bg-[#171008] border border-[#3c2c15] p-6 rounded-sm">
                    <h2 class="text-xl font-bold text-[#f2d788] uppercase mb-4 border-b border-[#3c2c15] pb-2">Thông tin liên hệ</h2>
                    <ul class="space-y-2.5 text-sm text-[#f4ecd8]">
                        <li><strong class="text-[#cf9f3f]">Địa chỉ:</strong> 93/8A Lê Lợi, Hóc Môn, TPHCM</li>
                        <li><strong class="text-[#cf9f3f]">Điện thoại:</strong> 0949146767</li>
                        <li><strong class="text-[#cf9f3f]">Giờ mở cửa:</strong> 08:00 - 20:00 <span class="text-[#6f6248]">(Tất cả các ngày trong tuần)</span></li>
                    </ul>
                </div>

                <div class="border border-[#3c2c15] rounded-sm overflow-hidden h-80 shadow-lg">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125373.55880388526!2d106.44279034335939!3d10.893402300000007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d52f5093ee55%3A0x925063b512a7a562!2sT%C3%82M%20BARBER%20SHOP!5e0!3m2!1svi!2s!4v1787395393636!5m2!1svi!2s" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="strict-origin-when-cross-origin">
                    </iframe>
                </div>
            </section>

            <!-- Cột phải: Form liên hệ -->
            <section class="bg-[#171008] border border-[#3c2c15] p-6 rounded-sm shadow-[0_0_0_1px_rgba(207,159,63,0.35),0_18px_40px_-20px_rgba(0,0,0,0.8)]">
                <h2 class="text-xl font-bold text-[#f2d788] uppercase mb-6 border-b border-[#3c2c15] pb-2">Gửi góp ý / câu hỏi</h2>
                
                @auth
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="rounded-sm border border-[#3c2c15] bg-[#0b0805] p-3 text-sm text-[#f4ecd8]">
                            <div class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#6f6248] mb-1">Tài khoản đang gửi</div>
                            <div class="font-semibold text-[#f2d788]">{{ auth()->user()->fullname ?? auth()->user()->name }}</div>
                            <div class="text-[#6f6248]">{{ auth()->user()->email }}</div>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-[#6f6248] mb-1.5">Số điện thoại</label>
                            <input 
                                id="phone" 
                                type="text" 
                                name="phone" 
                                value="{{ old('phone', auth()->user()->phone ?? '') }}" 
                                required 
                                placeholder="Nhập số điện thoại..."
                                class="w-full px-3.5 py-2 bg-[#0b0805] border border-[#3c2c15] text-[#f4ecd8] rounded-sm text-sm focus:outline-none focus:border-[#cf9f3f] focus:ring-1 focus:ring-[#cf9f3f] placeholder-[#6f6248]/50"
                            >
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-[#6f6248] mb-1.5">Nội dung</label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="4" 
                                required 
                                placeholder="Nhập nội dung tin nhắn..."
                                class="w-full px-3.5 py-2 bg-[#0b0805] border border-[#3c2c15] text-[#f4ecd8] rounded-sm text-sm focus:outline-none focus:border-[#cf9f3f] focus:ring-1 focus:ring-[#cf9f3f] placeholder-[#6f6248]/50 resize-y"
                            >{{ old('message') }}</textarea>
                        </div>

                        <button 
                            type="submit" 
                            class="w-full mt-2 py-2.5 px-4 bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] text-[#0b0805] font-semibold text-sm uppercase tracking-wider rounded-sm border border-[#8a641d] shadow-md hover:brightness-110 active:scale-[0.99] transition"
                        >
                            Gửi liên hệ
                        </button>
                    </form>
                @else
                    <div class="rounded-sm border border-[#8a641d]/40 bg-[#0b0805] p-5 text-sm text-[#f4ecd8]">
                        <div class="mb-3 text-[10px] font-bold uppercase tracking-[0.22em] text-[#f2d788]">Yêu cầu đăng nhập</div>
                        <p class="mb-4 leading-6 text-[#f4ecd8]/80">
                            Để gửi góp ý hoặc câu hỏi, bạn cần đăng nhập tài khoản trước khi gửi thông tin tới tiệm.
                        </p>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-sm border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-4 py-2.5 text-xs font-bold uppercase tracking-[0.12em] text-[#0b0805] transition hover:brightness-110">
                            Đăng nhập ngay
                        </a>
                    </div>
                @endauth
            </section>

        </div>
    </div>

@endsection