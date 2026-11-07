<?php

use Illuminate\Support\Facades\Route;

// Redirect root to admin dashboard
Route::get('/', function () {
    return redirect('/admin/dashboard');
});

// Load Admin Routes from routes/admin.php
require __DIR__ . '/admin.php';
