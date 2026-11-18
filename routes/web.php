<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Inventory\CategoryController;
use App\Http\Controllers\Inventory\DashboardController;
use App\Http\Controllers\Inventory\InventoryExportController;
use App\Http\Controllers\Inventory\InventoryTransactionController;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\Inventory\ProjectController;
use App\Http\Controllers\Inventory\SupplierController;
use App\Http\Controllers\Inventory\AccountController as InventoryAccountController;
use App\Http\Controllers\OtpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('account.index')
        : redirect()->route('login');
})->name('home');

Route::get('/dang-nhap', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/dang-nhap', [AuthController::class, 'login'])->name('login.post');
Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');
Route::get('/quan-ly-toi-cao/dang-nhap', [AuthController::class, 'showSystemOwnerLoginForm'])->name('system-owner.portal');
Route::get('/dang-ky', fn () => view('auth.register'))->name('register');
Route::post('/dang-ky', [AuthController::class, 'register'])->name('register.post');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('/quen-mat-khau', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/quen-mat-khau', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/dat-lai-mat-khau/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/dat-lai-mat-khau', [AuthController::class, 'resetPassword'])->name('password.update');
Route::get('/otp/gui', [OtpController::class, 'sendOtp'])->name('otp.send');
Route::get('/otp/xac-thuc', [OtpController::class, 'showVerifyForm'])->name('otp.form');
Route::post('/otp/xac-thuc', [OtpController::class, 'verifyOtp'])->name('otp.verify');

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/tai-khoan', [AccountController::class, 'index'])->name('account.index');
});

Route::middleware(['auth', 'active', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/exports/products.csv', [InventoryExportController::class, 'products'])->name('exports.products');
    Route::get('/exports/transactions.csv', [InventoryExportController::class, 'transactions'])->name('exports.transactions');

    Route::get('/products/lookup', [ProductController::class, 'lookup'])->name('products.lookup');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('suppliers', SupplierController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('projects', ProjectController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('/accounts', [InventoryAccountController::class, 'index'])->name('accounts.index');
    Route::post('/accounts', [InventoryAccountController::class, 'store'])->name('accounts.store');
    Route::get('/accounts/{account}/edit', [InventoryAccountController::class, 'edit'])->name('accounts.edit');
    Route::put('/accounts/{account}', [InventoryAccountController::class, 'update'])->name('accounts.update');
    Route::delete('/accounts/{account}', [InventoryAccountController::class, 'destroy'])->name('accounts.destroy');

    Route::get('/transactions', [InventoryTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create/{type}', [InventoryTransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [InventoryTransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}/print', [InventoryTransactionController::class, 'print'])->name('transactions.print');
    Route::get('/transactions/{transaction}', [InventoryTransactionController::class, 'show'])->name('transactions.show');

});
