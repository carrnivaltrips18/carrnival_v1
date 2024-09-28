<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CompanyDetailController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DestinationController;
use App\Http\Controllers\PopularTourController;
use App\Http\Controllers\ItineraryController;




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

    Route::get('/assign-role', [AdminController::class, 'assignRoleForm'])->name('admin.assign.role');
    Route::post('/assign-role', [AdminController::class, 'assignRole'])->name('admin.assign.role.submit');
    
    Route::get('/assign-permission', [AdminController::class, 'assignPermissionForm'])->name('admin.assign.permission');
    Route::post('/assign-permission', [AdminController::class, 'assignPermission'])->name('admin.assign.permission.submit');

    Route::get('/company', [CompanyDetailController::class, 'index'])->name('admin.company.index');
    Route::get('/company/edit', [CompanyDetailController::class, 'edit'])->name('admin.company.edit');
    Route::post('/company/update', [CompanyDetailController::class, 'update'])->name('admin.company.update');
    Route::delete('company-details/{id}', [CompanyDetailController::class, 'destroy'])->name('company.details.destroy');
});

Route::middleware(['auth:admin', 'role:superadmin|sales'])->group(function () {
    Route::get('admin/sales/dashboard', [AdminController::class, 'salesDashboard'])->name('admin.sales_dashboard');
});

Route::middleware(['auth:admin', 'role:superadmin|operations'])->group(function () {
    Route::get('admin/operations/dashboard', [AdminController::class, 'operationsDashboard'])->name('admin.operations_dashboard');
});

Route::middleware(['auth:admin', 'role:sales', 'permission:manage sales'])->group(function () {
    Route::get('/admin/sales', [AdminController::class, 'manageSales'])->name('admin.manage_sales');
});

Route::middleware(['auth:admin', 'role:operations', 'permission:manage operations'])->group(function () {
    Route::get('/admin/operations', [AdminController::class, 'manageOperations'])->name('admin.manage_operations');
});

Route::middleware(['auth:admin', 'role:superadmin|subAdmin','permission:manage users'])->group(function () {
    // Route to manage users
    Route::get('/admins', [AdminUserController::class, 'index'])->name('admin.admins.index');
    Route::get('/admins/create', [AdminUserController::class, 'create'])->name('admin.admins.create');
    Route::post('/admins', [AdminUserController::class, 'store'])->name('admin.admins.store');
    Route::get('/admins/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.admins.edit');
    Route::put('/admins/{id}', [AdminUserController::class, 'update'])->name('admin.admins.update');
    Route::delete('/admins/{id}', [AdminUserController::class, 'destroy'])->name('admin.admins.destroy');
    Route::patch('admin/admins/{id}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin.admins.toggleStatus');
    Route::get('/admin/users/csv', [AdminUserController::class, 'exportCsv'])->name('admin.users.csv');

    // Destinations
    Route::resource('admin/destinations', DestinationController::class)->names('admin.destinations');
    Route::patch('admin/destinations/{id}/toggleStatus', [DestinationController::class, 'toggleStatus'])->name('admin.destinations.toggleStatus');
    Route::get('admin/destinations/export/csv', [DestinationController::class, 'exportCsvDestination'])->name('admin.destinations.exportCsv');
    Route::post('admin/destinations/upload-csv', [DestinationController::class, 'uploadCsvDestination'])->name('admin.destinations.uploadCsv');

    // Popular Tours

    Route::resource('admin/popular_tours', PopularTourController::class)->names('admin.popular_tours');
    Route::get('admin/popular_tours/export/csv', [PopularTourController::class, 'exportCsvPopularTours'])->name('admin.popular_tours.exportCsv');
    Route::post('admin/popular_tours/upload/csv', [PopularTourController::class, 'importCsvPopularTours'])->name('admin.popular_tours.uploadCsv');
    Route::get('admin/download-sample-popular-tour', [PopularTourController::class, 'downloadSampleCsv'])->name('admin.popular_tours.downloadSampleCsv');
    Route::get('admin/download-sample-destinations', [DestinationController::class, 'downloadSampleCsv'])->name('admin.destinations.downloadSampleCsv');

    Route::resource('admin/itineraries', ItineraryController::class)->names('admin.itineraries');
    
    Route::get('itineraries/check-title', [ItineraryController::class, 'checkTitle'])->name('admin.itineraries.checkTitle');

});





