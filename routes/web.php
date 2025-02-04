<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\PasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';



Route::middleware('auth:admin_users')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


    Route::get('change-password', [PasswordController::class, 'edit'])->name('change-password.edit'); // Admin User Change Password
    Route::put('change-password', [PasswordController::class, 'update'])->name('change-password.update');
});


Route::middleware(['auth:admin_users', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); // Admin Dashboard

    Route::resource('admin-user', AdminUserController::class);
    Route::get('admin-user-datatable', [AdminUserController::class, 'datatable'])->name('admin-user-datable'); // Admin User Datatable

    Route::resource('user', UserController::class);
    Route::get('user-datatable', [UserController::class, 'datatable'])->name('user-datable'); // Admin User Datatable
});
