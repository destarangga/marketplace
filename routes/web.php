<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController; 
use Illuminate\Support\Facades\Route;

// Rute untuk halaman login
Route::get('/', [AuthController::class, 'index'])->name('login');

// Rute untuk halaman registrasi
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('daftar');

// Rute untuk login
Route::post('/login', [AuthController::class, 'login'])->name('masuk');

// Rute untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute untuk dashboard
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AuthController::class, 'show'])->name('profile.show');
    Route::post('/profile', [AuthController::class, 'update'])->name('profile.update');
});

// Rute untuk menu (merchant)
Route::prefix('menus')->middleware('auth')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('menus.index'); 
    Route::get('/create', [MenuController::class, 'create'])->name('menus.create'); 
    Route::post('/', [MenuController::class, 'store'])->name('menus.store'); 
    Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit'); 
    Route::put('/{menu}', [MenuController::class, 'update'])->name('menus.update'); 
    Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy'); 
});

// Rute untuk order (customer)
Route::prefix('orders')->middleware('auth')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index'); 
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create'); 
    Route::post('/', [OrderController::class, 'store'])->name('orders.store'); 
    Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit'); 
    Route::put('/{order}', [OrderController::class, 'update'])->name('orders.update'); 
    Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy'); 
});

// Rute untuk invoice
Route::prefix('invoices')->middleware('auth')->group(function () {

    Route::get('/{order}/invoice', [InvoiceController::class, 'generate'])->name('orders.invoice'); 
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/export/{order}', [InvoiceController::class, 'exportPdf'])->name('invoices.export');


});
