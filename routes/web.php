<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\SimOrderController;
use App\Http\Controllers\SimStockController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RetailerController;
use App\Http\Controllers\CustomerPortalController;
use App\Http\Controllers\Auth\RetailerLoginController;
use App\Http\Controllers\Auth\CustomerLoginController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Staff Authentication Routes
Route::middleware('guest:employee')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth:employee')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Employees
    Route::resource('employees', EmployeeController::class);
    
    // Customers
    Route::resource('customers', CustomerController::class);
    
    // Invoices
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
    
    // Activations
    Route::resource('activations', ActivationController::class);
    
    // SIM Orders
    Route::resource('sim-orders', SimOrderController::class);
    
    // SIM Stock
    Route::resource('sim-stocks', SimStockController::class);
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/overview', [ReportController::class, 'overview'])->name('reports.overview');
    
    // Roles (Super Admin only)
    Route::resource('roles', RoleController::class);
});

// Retailer Authentication Routes
Route::prefix('retailer')->name('retailer.')->group(function () {
    Route::middleware('guest:employee')->group(function () {
        Route::get('/login', [RetailerLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [RetailerLoginController::class, 'login']);
    });
    
    Route::middleware('auth:employee')->group(function () {
        Route::post('/logout', [RetailerLoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [RetailerController::class, 'dashboard'])->name('dashboard');
        Route::get('/reports', [RetailerController::class, 'reports'])->name('reports');
        Route::get('/transactions', [RetailerController::class, 'transactions'])->name('transactions');
    });
});

// Customer Authentication Routes
Route::prefix('customer')->name('customer.')->group(function () {
    Route::middleware('guest:customer')->group(function () {
        Route::get('/login', [CustomerLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [CustomerLoginController::class, 'login']);
    });
    
    Route::middleware('auth:customer')->group(function () {
        Route::post('/logout', [CustomerLoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [CustomerPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/invoices', [CustomerPortalController::class, 'invoices'])->name('invoices');
        Route::get('/activations', [CustomerPortalController::class, 'activations'])->name('activations');
        Route::get('/profile', [CustomerPortalController::class, 'profile'])->name('profile');
        Route::patch('/profile', [CustomerPortalController::class, 'updateProfile'])->name('profile.update');
    });
});

require __DIR__.'/auth.php';
