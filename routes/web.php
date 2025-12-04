<?php

use App\Http\Controllers\AdminBmiFeedbackController;
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

// Tambahkan ini agar middleware auth TIDAK ERROR
Route::get('/login', function () {
    return redirect()->route('signin');  // <-- tambahan
})->name('login');


// ============ HALAMAN UMUM ============

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// ============ HANYA UNTUK USER YANG BELUM LOGIN (Guest) ============

Route::middleware('isGuest')->group(function () {
    Route::get('/signin', fn() => view('auth.signin'))->name('signin');
    Route::get('/signup', fn() => view('auth.signup'))->name('signup');
});


// ============ TEACHER ============

Route::middleware(['auth', 'isTeacher'])->prefix('/teacher')->name('teacher.')->group(function () {
    Route::get('dashboard', fn() => view('teacher.dashboard'))->name('dashboard');
    Route::get('progress', [TeacherFeedbackController::class, 'progress'])->name('progress');
    Route::post('progress/toggle/{recordId}', [TeacherFeedbackController::class, 'toggleChecked'])->name('progress.toggle');
    Route::resource('feedback', TeacherFeedbackController::class);
    Route::resource('exercise', PhysicalActivityController::class);
    Route::get('exercise/trash', [PhysicalActivityController::class, 'trash'])->name('exercise.trash');
    Route::patch('exercise/restore/{id}', [PhysicalActivityController::class, 'restore'])->name('exercise.restore');
    Route::delete('exercise/force-delete/{id}', [PhysicalActivityController::class, 'forceDelete'])->name('exercise.force-delete');
});


// ============ ADMIN ============

Route::middleware(['auth', 'isAdmin'])->prefix('/admin')->name('admin.')->group(function () {

    Route::get('dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/index', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
        Route::get('/export', [UserController::class, 'export'])->name('export');
        Route::get('/trash', [UserController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [UserController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [UserController::class, 'deletePermanent'])->name('delete_permanent');
    });

    Route::resource('role', RoleController::class);
    Route::resource('system-log', SystemLogController::class);

    Route::get('/feedback', [AdminBmiFeedbackController::class, 'index'])->name('feedback.index');
    Route::put('/feedback/{bmiRecord}', [AdminBmiFeedbackController::class, 'update'])->name('feedback.update');
});


// ============ UNTUK SEMUA USER YANG SUDAH LOGIN ============

Route::middleware(['auth'])->group(function () {

    // Profile
    Route::name('profile.')->group(function () {
        Route::get('/profile/', [UserController::class, 'profile'])->name('index');
        Route::put('/profile/update/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/profile/edit', [UserController::class, 'edit'])->name('edit');
        Route::post('/profile/upload-photo', [UserController::class, 'uploadPhoto'])->name('upload-photo');
        Route::put('/profile/update-photo', [UserController::class, 'updatePhoto'])->name('update-photo');
        Route::delete('/profile/delete-photo', [UserController::class, 'deletePhoto'])->name('delete-photo');
    });

    // User-specific routes
    Route::get('/history', [BmiRecordController::class, 'index'])->name('history');
    Route::get('/bmicalculator', fn() => view('bmicalculator'))->name('bmicalculator');
    Route::post('/bmi/store', [BmiRecordController::class, 'store'])->name('bmi.store');
    Route::get('/physical-activity', [PhysicalActivityController::class, 'index'])->name('physical.activity');
    Route::resource('/nutrition-goal', NutritionGoalController::class);
});
