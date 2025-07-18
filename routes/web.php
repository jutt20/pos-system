<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\SimOrderController;
use App\Http\Controllers\SimStockController;
use App\Http\Controllers\SimStockImportController;
use App\Http\Controllers\SimStockExportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RetailerController;
use App\Http\Controllers\CustomerPortalController;
use App\Http\Controllers\Auth\RetailerLoginController;
use App\Http\Controllers\Auth\CustomerLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Staff Authentication Routes
Route::middleware('guest:employee')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
});

// Retailer Authentication Routes
Route::middleware('guest:employee')->group(function () {
    Route::get('/retailer/login', [RetailerLoginController::class, 'showLoginForm'])->name('retailer.login');
    Route::post('/retailer/login', [RetailerLoginController::class, 'login']);
});

Route::middleware('auth:employee')->group(function () {
    Route::post('/retailer/logout', [RetailerLoginController::class, 'logout'])->name('retailer.logout');
});

// Customer Authentication Routes
Route::middleware('guest:customer')->group(function () {
    Route::get('/customer/login', [CustomerLoginController::class, 'showLoginForm'])->name('customer.login');
    Route::post('/customer/login', [CustomerLoginController::class, 'login']);
});

Route::middleware('auth:customer')->group(function () {
    Route::post('/customer/logout', [CustomerLoginController::class, 'logout'])->name('customer.logout');
});

// Staff Dashboard and Routes
Route::middleware(['auth:employee'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource routes with permission middleware
    Route::middleware(['permission:manage customers'])->group(function () {
        Route::resource('customers', CustomerController::class);
    });

    Route::middleware(['permission:manage employees'])->group(function () {
        Route::resource('employees', EmployeeController::class);
    });

    Route::middleware(['permission:manage invoices'])->group(function () {
        Route::resource('invoices', InvoiceController::class);
        Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'generatePDF'])->name('invoices.pdf');
    });

    Route::middleware(['permission:manage activations'])->group(function () {
        Route::resource('activations', ActivationController::class);
    });

    Route::middleware(['permission:manage sim orders'])->group(function () {
        Route::resource('sim-orders', SimOrderController::class);
    });

    Route::middleware(['permission:manage sim stocks'])->group(function () {
        Route::resource('sim-stocks', SimStockController::class);
        Route::post('sim-stocks/import', [SimStockImportController::class, 'import'])->name('sim-stocks.import');
        Route::get('sim-stocks/export', [SimStockExportController::class, 'export'])->name('sim-stocks.export');
    });

    Route::middleware(['permission:view reports'])->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/overview', [ReportController::class, 'overview'])->name('reports.overview');
        Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
    });

    Route::middleware(['permission:manage roles'])->group(function () {
        Route::resource('roles', RoleController::class);
    });
});

// Retailer Dashboard Routes
Route::middleware(['auth:employee', 'role:retailer'])->prefix('retailer')->name('retailer.')->group(function () {
    Route::get('/dashboard', [RetailerController::class, 'dashboard'])->name('dashboard');
    Route::get('/transactions', [RetailerController::class, 'transactions'])->name('transactions');
    Route::get('/reports', [RetailerController::class, 'reports'])->name('reports');
    Route::get('/profile', [RetailerController::class, 'profile'])->name('profile');
});

// Customer Portal Routes
Route::middleware(['auth:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/invoices', [CustomerPortalController::class, 'invoices'])->name('invoices');
    Route::get('/activations', [CustomerPortalController::class, 'activations'])->name('activations');
    Route::get('/profile', [CustomerPortalController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerPortalController::class, 'updateProfile'])->name('profile.update');
});

require __DIR__.'/auth.php';
