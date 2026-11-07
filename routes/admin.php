<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes (Exactly 6 routes)
|--------------------------------------------------------------------------
*/

// Admin Login & Logout
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login.form');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Protected Admin Pages (Requires Admin Login)
Route::middleware(['web', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/properties', [AdminController::class, 'properties'])->name('admin.properties');
    Route::post('/admin/properties/{id}/status', [AdminController::class, 'updatePropertyStatus'])->name('admin.properties.updateStatus');
});
