<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HairstyleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// ===================== TRANG CHỦ =====================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ===================== GIỚI THIỆU =====================
Route::get('/gioi-thieu', [AboutController::class, 'index'])->name('about');

// ===================== KIỂU TÓC =====================
Route::get('/kieu-toc', [HairstyleController::class, 'index'])->name('hairstyles.index');
Route::get('/kieu-toc/{slug}', [HairstyleController::class, 'show'])->name('hairstyles.show');

// ===================== DỊCH VỤ =====================
Route::get('/dich-vu', [ServiceController::class, 'index'])->name('services.index');

// ===================== PORTFOLIO / GALLERY =====================
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');

// ===================== BLOG =====================
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// ===================== ĐẶT LỊCH =====================
Route::get('/dat-lich', [BookingController::class, 'create'])->name('booking.create');
Route::post('/dat-lich', [BookingController::class, 'store'])->name('booking.store');
Route::get('/dat-lich/thanh-cong/{code}', [BookingController::class, 'success'])->name('booking.success');

// ===================== LIÊN HỆ =====================
Route::get('/lien-he', [ContactController::class, 'index'])->name('contact.index');
Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');

// ===================== TRẠNG THÁI & SỰ KIỆN =====================
// Xem công khai, mở cho TẤT CẢ mọi người bình luận (không cần đăng nhập).
Route::get('/trang-thai', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/trang-thai/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
Route::post('/trang-thai/{announcement}/binh-luan', [AnnouncementController::class, 'storeComment'])->name('announcements.comment');

// ===================== ĐĂNG NHẬP / ĐĂNG KÝ =====================
Route::get('/dang-nhap', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/dang-nhap', [AuthController::class, 'login'])->name('login.post');
Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');

// Cổng đăng nhập riêng dành cho Quản lý tối cao (Master Password).
Route::get('/quan-ly-toi-cao/dang-nhap', [AuthController::class, 'showSystemOwnerLoginForm'])->name('system-owner.portal');

Route::get('/dang-ky', function () {
    return view('auth.register');
})->name('register');
Route::post('/dang-ky', [AuthController::class, 'register'])->name('register.post');

// Đăng nhập Google (tuỳ chọn, cần cài đặt package laravel/socialite).
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/quen-mat-khau', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/quen-mat-khau', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/dat-lai-mat-khau/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/dat-lai-mat-khau', [AuthController::class, 'resetPassword'])->name('password.update');

// ===================== XÁC THỰC OTP (SAU KHI ĐĂNG KÝ) =====================
Route::get('/otp/gui', [OtpController::class, 'sendOtp'])->name('otp.send');
Route::get('/otp/xac-thuc', [OtpController::class, 'showVerifyForm'])->name('otp.form');
Route::post('/otp/xac-thuc', [OtpController::class, 'verifyOtp'])->name('otp.verify');

// ===================== TÀI KHOẢN CỦA TÔI (khách hàng đã đăng nhập) =====================
Route::middleware('auth')->group(function () {
    Route::get('/tai-khoan', [AccountController::class, 'index'])->name('account.index');
});

// ===================== KHU VỰC QUẢN TRỊ (ADMIN) =====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/lich-hen', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::put('/lich-hen/{booking}/xac-nhan', [App\Http\Controllers\Admin\BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::put('/lich-hen/{booking}/hoan-thanh', [App\Http\Controllers\Admin\BookingController::class, 'complete'])->name('bookings.complete');
    Route::put('/lich-hen/{booking}/huy', [App\Http\Controllers\Admin\BookingController::class, 'cancel'])->name('bookings.cancel');

    Route::get('/dich-vu', [App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('services.index');
    Route::post('/dich-vu', [App\Http\Controllers\Admin\ServiceController::class, 'store'])->name('services.store');
    Route::put('/dich-vu/{service}', [App\Http\Controllers\Admin\ServiceController::class, 'update'])->name('services.update');
    Route::delete('/dich-vu/{service}', [App\Http\Controllers\Admin\ServiceController::class, 'destroy'])->name('services.destroy');

    Route::get('/kieu-toc', [App\Http\Controllers\Admin\HairstyleController::class, 'index'])->name('hairstyles.index');
    Route::post('/kieu-toc', [App\Http\Controllers\Admin\HairstyleController::class, 'store'])->name('hairstyles.store');
    Route::put('/kieu-toc/{hairstyle}', [App\Http\Controllers\Admin\HairstyleController::class, 'update'])->name('hairstyles.update');
    Route::delete('/kieu-toc/{hairstyle}', [App\Http\Controllers\Admin\HairstyleController::class, 'destroy'])->name('hairstyles.destroy');

    Route::get('/barber', [App\Http\Controllers\Admin\BarberController::class, 'index'])->name('barbers.index');
    Route::post('/barber', [App\Http\Controllers\Admin\BarberController::class, 'store'])->name('barbers.store');
    Route::put('/barber/{barber}', [App\Http\Controllers\Admin\BarberController::class, 'update'])->name('barbers.update');
    Route::delete('/barber/{barber}', [App\Http\Controllers\Admin\BarberController::class, 'destroy'])->name('barbers.destroy');

    Route::get('/trang-thai', [App\Http\Controllers\Admin\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/trang-thai', [App\Http\Controllers\Admin\AnnouncementController::class, 'store'])->name('announcements.store');
    Route::delete('/trang-thai/{announcement}', [App\Http\Controllers\Admin\AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // Dành riêng cho Quản lý tối cao (System Owner).
    Route::middleware('system_owner')->group(function () {
        Route::get('/quan-ly-toi-cao', [App\Http\Controllers\Admin\SystemOwnerController::class, 'index'])->name('system-owner.index');
        Route::put('/quan-ly-toi-cao/nguoi-dung/{user}/quyen', [App\Http\Controllers\Admin\SystemOwnerController::class, 'updateRole'])->name('system-owner.update-role');

        Route::post('/quan-ly-toi-cao/co-van', [App\Http\Controllers\Admin\SystemOwnerController::class, 'addSubOwner'])->name('system-owner.sub-owners.store');
        Route::delete('/quan-ly-toi-cao/co-van/{subOwner}', [App\Http\Controllers\Admin\SystemOwnerController::class, 'removeSubOwner'])->name('system-owner.sub-owners.destroy');
    });
});
