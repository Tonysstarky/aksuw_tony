<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\WaterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web routes (10-dan köp route) — Water Suw Factory
|--------------------------------------------------------------------------
*/

// 1. Dil çalşyjy (3 dil: tm, ru, en)
Route::get('/lang/{locale}', [HomeController::class, 'setLocale'])->name('locale.set');

// 2. Baş sahypa (hemmeler görüp biler)
Route::get('/', [HomeController::class, 'index'])->name('home');

// 3. Diňe myhmanlar üçin: Giriş / Agza bolmak / Paroly unutmak (Gmail kody)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Agza bolandan soň Gmail-e gelen 6 belgili kody tassyklamak
    Route::get('/verify-email', [AuthController::class, 'showVerifyEmail'])->name('email.verify.form');
    Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('email.verify')->middleware('throttle:10,1');
    Route::post('/verify-email/resend', [AuthController::class, 'resendVerification'])->name('email.verify.resend')->middleware('throttle:5,1');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetCode'])->name('password.email')->middleware('throttle:5,1');
    Route::get('/verify-code', [AuthController::class, 'showVerifyCode'])->name('password.verify.form');
    Route::post('/verify-code', [AuthController::class, 'resetPasswordWithCode'])->name('password.verify')->middleware('throttle:10,1');
});

// 4. Diňe registrasiýa edilenler girip bilýär
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Profil: maglumatlary we paroly üýtgetmek
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('profile.password.form');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('profile.password.update');

    // Suwlar: görmek (hemme ulanyjy)
    Route::get('/waters', [WaterController::class, 'index'])->name('waters.index');

    // Kategoriýalar: görmek (hemme ulanyjy)
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    // Sargytlar: ulanyjy öz sargytlaryny görýär we döredýär
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

    // Soraglar: sorag bermek + meniň soraglarym
    Route::get('/questions/ask', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/my-questions', [QuestionController::class, 'myQuestions'])->name('questions.my');

    // 5. Diňe ADMIN: CRUD (döretmek, üýtgetmek, pozmak) we jogap bermek
    Route::middleware('admin')->group(function () {
        // Waters CRUD
        Route::get('/water/create', [WaterController::class, 'create'])->name('waters.create');
        Route::post('/water/store', [WaterController::class, 'store'])->name('waters.store');
        Route::get('/water/{water}/edit', [WaterController::class, 'edit'])->name('waters.edit');
        Route::put('/water/{water}', [WaterController::class, 'update'])->name('waters.update');
        Route::delete('/water/{water}', [WaterController::class, 'destroy'])->name('waters.destroy');

        // Categories CRUD
        Route::get('/category/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/category/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/category/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Orders (admin)
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

        // Questions (admin: ähli soraglar + jogap)
        Route::get('/admin/questions', [QuestionController::class, 'index'])->name('questions.index');
        Route::post('/questions/{question}/answer', [QuestionController::class, 'answer'])->name('questions.answer');
        Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    });

    // Suw maglumaty (şu route /water/create-den soň gelmeli däl; öz prefiksi bilen)
    Route::get('/waters/{water}', [WaterController::class, 'show'])->name('waters.show');
});
