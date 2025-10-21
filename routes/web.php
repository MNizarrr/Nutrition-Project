<?php

use App\Http\Controllers\BmiRecordController;
use App\Http\Controllers\NutritionGoalController;
use App\Http\Controllers\PhysicalActivityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\TeacherFeedbackController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ============ AUTH ROUTES ============

// SIGNUP (Register)
Route::post('/signup', [UserController::class, 'register'])->name('signup.process');

// SIGNIN (Login)
Route::post('/signin', [UserController::class, 'authentication'])->name('signin.process');

// Logout
Route::get('/logout', [UserController::class, 'logout'])->name('logout');


// ============ HALAMAN UMUM ============
Route::get('/', fn() => view('home'))->name('home');
Route::get('/bmicalculator', fn() => view('bmicalculator'))->name('bmicalculator');


// ============ HANYA UNTUK USER YANG BELUM LOGIN (Guest) ============
Route::middleware('isGuest')->group(function () {
    Route::get('/signin', fn() => view('auth.signin'))->name('signin');
    Route::get('/signup', fn() => view('auth.signup'))->name('signup');
});


// ============ TEACHER ============
Route::prefix('/teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', fn() => view('teacher.dashboard'))->name('dashboard');
});

// ============ ADMIN ============
Route::prefix('/admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
});
