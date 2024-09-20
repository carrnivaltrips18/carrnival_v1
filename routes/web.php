<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;



Route::get('/', function () {
    // Redirect to the home page if the user is logged in
    if (Auth::check()) {
        return redirect('/home');
    }
    // Otherwise, redirect to login
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/chat', function () {
    return view('chat');
})->middleware('auth');


// routes/web.php


// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    
    // Admin Registration (optional, you might only want admins to be created manually)
    Route::get('/register', [AdminController::class, 'registerForm'])->name('admin.register');
    Route::post('/register', [AdminController::class, 'register'])->name('admin.register.submit');
   
});

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['auth:admin','role:superadmin'])->prefix('admin')->group(function () {
    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('/assign-role', [AdminController::class, 'assignRoleForm'])->name('admin.assign.role');
    Route::post('/assign-role', [AdminController::class, 'assignRole'])->name('admin.assign.role.submit');
    
    Route::get('/assign-permission', [AdminController::class, 'assignPermissionForm'])->name('admin.assign.permission');
    Route::post('/assign-permission', [AdminController::class, 'assignPermission'])->name('admin.assign.permission.submit');
});

Route::middleware(['auth:admin', 'role:superadmin|sales'])->group(function () {
    Route::get('admin/sales/dashboard', [AdminController::class, 'salesDashboard'])->name('admin.sales_dashboard');
});

Route::middleware(['auth:admin', 'role:superadmin|operations'])->group(function () {
    Route::get('admin/operations/dashboard', [AdminController::class, 'operationsDashboard'])->name('admin.operations_dashboard');
});


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
