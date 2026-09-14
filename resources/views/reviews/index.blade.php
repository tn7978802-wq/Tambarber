@extends('layouts.app')

@section('title', 'Đánh giá & Phản hồi')

@section('content')
<div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-8 border-b border-[#3c2c15] pb-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-bold uppercase tracking-widest text-[#6f6248]">Ý kiến từ khách hàng</span>
            <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl text-[#f2d788] tracking-wider uppercase mt-1">
                Đánh giá &amp; Phản hồi
            </h1>
        </div>

        <div class="flex items-center gap-4 bg-[#171008] border border-[#3c2c15] px-4 py-2.5 rounded-[2px]">
            <div class="text-center">
                <div class="text-2xl font-bold text-[#f2d788] font-['Bebas_Neue'] tracking-wider">
                    {{ number_format($averageRating, 1) }} / 5.0
                </div>
                <div class="text-[10px] text-[#6f6248] uppercase font-bold tracking-wider">Trung bình</div>
            </div>
            <div class="h-8 w-[1px] bg-[#3c2c15]"></div>
            <div class="text-center">
                <div class="text-2xl font-bold text-[#f4ecd8] font-['Bebas_Neue'] tracking-wider">
                    {{ $totalReviews }}
                </div>
                <div class="text-[10px] text-[#6f6248] uppercase font-bold tracking-wider">Lượt đánh giá</div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-12 gap-8 items-start">
        
        {{-- CỘT TRÁI (5 CỘT) - FORM GỬI ĐÁNH GIÁ MỚI --}}
        <div class="lg:col-span-5 rounded-[2px] border border-[#3c2c15] bg-[#171008] p-6 shadow-2xl">
            <h2 class="font-['Bebas_Neue'] text-2xl text-[#f2d788] tracking-wider uppercase mb-4 border-b border-[#3c2c15] pb-2">
                Gửi phản hồi của bạn
            </h2>

            <form action="{{ route('reviews.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- HỌ & TÊN --}}
                <div>
                    <label for="customer_name" class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] mb-1.5">
                        Họ &amp; Tên <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="customer_name" 
                           id="customer_name" 
                           value="{{ old('customer_name') }}"
                           required
                           placeholder="Nhập họ và tên..."
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] placeholder-[#6f6248] focus:border-[#8a641d] focus:outline-none">
                </div>

                {{-- EMAIL --}}
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] mb-1.5">
                        Email <span class="text-[#6f6248] lowercase">(không bắt buộc)</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}"
                           placeholder="example@gmail.com"
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-4 py-2.5 text-sm text-[#f4ecd8] placeholder-[#6f6248] focus:border-[#8a641d] focus:outline-none">
                </div>

                {{-- CHỌN SAO (STAR RATING CĂN TRÁI - TÍNH TỪ TRÁI SANG PHẢI) --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] mb-1.5">
                        Đánh giá chất lượng <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="star-rating flex items-center justify-start gap-1.5 py-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <input type="radio" 
                                   id="star{{ $i }}" 
                                   name="rating" 
                                   value="{{ $i }}" 
                                   class="hidden" 
                                   {{ old('rating', 5) == $i ? 'checked' : '' }} 
                                   required />
                            <label for="star{{ $i }}" 
                                   title="{{ $i }} sao"
                                   data-value="{{ $i }}"
                                   class="star-label cursor-pointer text-3xl text-[#3c2c15] transition-colors">
                                ★
                            </label>
                        @endfor
                    </div>
                </div>

                {{-- NỘI DUNG --}}
                <div>
                    <label for="comment" class="block text-xs font-bold uppercase tracking-wider text-[#f2d788] mb-1.5">
                        Nội dung phản hồi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="comment" 
                              id="comment" 
                              rows="4" 
                              required
                              placeholder="Cảm nhận của bạn về tay nghề barber, không gian, dịch vụ..."
                              class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] p-3 text-sm text-[#f4ecd8] placeholder-[#6f6248] focus:border-[#8a641d] focus:outline-none leading-relaxed">{{ old('comment') }}</textarea>
                </div>

                <button type="submit" 
                        class="w-full inline-flex justify-center items-center gap-2 rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-6 py-3 text-xs font-bold uppercase tracking-wider text-[#0b0805] shadow-lg transition-all hover:brightness-110 active:scale-[0.99]">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Gửi đánh giá</span>
                </button>
            </form>
        </div>

        {{-- CỘT PHẢI (7 CỘT) - HIỂN THỊ TẤT CẢ ĐÁNH GIÁ --}}
        <div class="lg:col-span-7 space-y-4">
            <h2 class="font-['Bebas_Neue'] text-2xl text-[#f2d788] tracking-wider uppercase border-b border-[#3c2c15] pb-2">
                Tất cả đánh giá từ khách hàng
            </h2>

            @forelse ($reviews as $review)
                <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-5 space-y-3 transition-colors hover:border-[#8a641d]/50">
                    <div class="flex items-center justify-between border-b border-[#3c2c15]/60 pb-2.5">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-full bg-[#251b0e] border border-[#8a641d] flex items-center justify-center font-bold text-[#f2d788] text-sm uppercase">
                                {{ mb_substr($review->customer_name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-sm text-[#f4ecd8]">{{ $review->customer_name }}</div>
                                <div class="text-[10px] text-[#6f6248]">
                                    {{ $review->created_at ? $review->created_at->format('d/m/Y H:i') : 'Mới đây' }}
                                </div>
                            </div>
                        </div>

                        {{-- HIỂN THỊ SỐ SAO (1 - 5 SAO) --}}
                        <div class="flex items-center gap-1 text-[#f2d788]">
                            @for ($s = 1; $s <= 5; $s++)
                                @if ($s <= $review->rating)
                                    <i class="fa-solid fa-star text-xs"></i>
                                @else
                                    <i class="fa-solid fa-star text-xs text-[#3c2c15]"></i>
                                @endif
                            @endfor
                            <span class="text-xs font-bold ml-1 text-[#8a641d]">({{ $review->rating }}/5)</span>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-[#f4ecd8]/90 leading-relaxed italic">
                        "{{ $review->comment }}"
                    </p>
                </div>
            @empty
                <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-8 text-center text-xs text-[#6f6248]">
                    Chưa có đánh giá nào. Hãy là người đầu tiên viết phản hồi!
                </div>
            @endforelse

            {{-- PHÂN TRANG --}}
            <div class="pt-4">
                {{ $reviews->links() }}
            </div>
        </div>

    </div>
</div>

<style>
    .star-label.active,
    .star-label.hover {
        color: #f2d788 !important;
    }
</style>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ratingContainer = document.querySelector('.star-rating');
        if (!ratingContainer) return;

        const labels = ratingContainer.querySelectorAll('.star-label');

        function updateStars(val) {
            labels.forEach(label => {
                const labelVal = parseInt(label.getAttribute('data-value'));
                if (labelVal <= val) {
                    label.classList.add('active');
                } else {
                    label.classList.remove('active');
                }
            });
        }

        // Khởi tạo trạng thái ban đầu dựa vào radio được chọn
        const checkedInput = ratingContainer.querySelector('input[type="radio"]:checked');
        if (checkedInput) {
            updateStars(parseInt(checkedInput.value));
        }

        labels.forEach(label => {
            // Khi hover
            label.addEventListener('mouseenter', function () {
                const hoverVal = parseInt(this.getAttribute('data-value'));
                labels.forEach(l => {
                    if (parseInt(l.getAttribute('data-value')) <= hoverVal) {
                        l.classList.add('hover');
                    } else {
                        l.classList.remove('hover');
                    }
                });
            });

            // Khi chọn click
            label.addEventListener('click', function () {
                const val = parseInt(this.getAttribute('data-value'));
                const targetInput = document.getElementById('star' + val);
                if (targetInput) targetInput.checked = true;
                updateStars(val);
            });
        });

        // Khi di chuột ra khỏi vùng chọn sao
        ratingContainer.addEventListener('mouseleave', function () {
            labels.forEach(l => l.classList.remove('hover'));
            const currentChecked = ratingContainer.querySelector('input[type="radio"]:checked');
            if (currentChecked) {
                updateStars(parseInt(currentChecked.value));
            }
        });
    });
</script>
@endsection
@endsection