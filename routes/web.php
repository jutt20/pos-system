<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\SimOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SimStockController;
use App\Http\Controllers\SimStockImportController;
use App\Http\Controllers\SimStockExportController;
use App\Http\Controllers\RetailerController;
use App\Http\Controllers\CustomerPortalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OnlineSimOrderController;
use App\Http\Controllers\DeliveryServiceController;
use App\Http\Controllers\Auth\RetailerLoginController;
use App\Http\Controllers\Auth\CustomerLoginController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Staff Authentication Routes
Route::middleware('guest:employee')->group(function () {
    Route::get('login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
                ->name('login');
    Route::post('login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth:employee')->group(function () {
    Route::post('logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});

// Retailer Authentication Routes
Route::prefix('retailer')->name('retailer.')->group(function () {
    Route::middleware('guest:employee')->group(function () {
        Route::get('login', [RetailerLoginController::class, 'create'])->name('login');
        Route::post('login', [RetailerLoginController::class, 'login']);
    });
    
    Route::middleware('auth:employee')->group(function () {
        Route::post('logout', [RetailerLoginController::class, 'destroy'])->name('logout');
        Route::get('dashboard', [RetailerController::class, 'dashboard'])->name('dashboard');
        Route::get('reports', [RetailerController::class, 'reports'])->name('reports');
        Route::get('transactions', [RetailerController::class, 'transactions'])->name('transactions');
    });
});

// Customer Authentication Routes
Route::prefix('customer')->name('customer.')->group(function () {
    Route::middleware('guest:customer')->group(function () {
        Route::get('login', [CustomerLoginController::class, 'create'])->name('login');
        Route::post('login', [CustomerLoginController::class, 'login']);
    });
    
    Route::middleware('auth:customer')->group(function () {
        Route::post('logout', [CustomerLoginController::class, 'destroy'])->name('logout');
        Route::get('dashboard', [CustomerPortalController::class, 'dashboard'])->name('dashboard');
    });
});

// Public Online SIM Order Routes
Route::get('/order-sim', [OnlineSimOrderController::class, 'create'])->name('online-sim-orders.create');
Route::post('/order-sim', [OnlineSimOrderController::class, 'store'])->name('online-sim-orders.store');
Route::get('/track-order/{orderNumber}', [OnlineSimOrderController::class, 'track'])->name('online-sim-orders.track');

// Staff Protected Routes
Route::middleware(['auth:employee'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Employee Management
    Route::middleware(['permission:manage employees'])->group(function () {
        Route::resource('employees', EmployeeController::class);
    });

    // Customer Management
    Route::middleware(['permission:manage customers'])->group(function () {
        Route::resource('customers', CustomerController::class);
    });

    // Invoice Management
    Route::middleware(['permission:manage invoices'])->group(function () {
        Route::resource('invoices', InvoiceController::class);
        Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
    });

    // Activation Management
    Route::middleware(['permission:manage activations'])->group(function () {
        Route::resource('activations', ActivationController::class);
    });

    // SIM Order Management
    Route::middleware(['permission:manage orders'])->group(function () {
        Route::resource('sim-orders', SimOrderController::class);
    });

    // Online SIM Order Management
    Route::middleware(['permission:manage online orders'])->group(function () {
        Route::get('/admin/online-sim-orders', [OnlineSimOrderController::class, 'index'])->name('admin.online-sim-orders.index');
        Route::get('/admin/online-sim-orders/{order}', [OnlineSimOrderController::class, 'show'])->name('admin.online-sim-orders.show');
        Route::patch('/admin/online-sim-orders/{order}/approve', [OnlineSimOrderController::class, 'approve'])->name('admin.online-sim-orders.approve');
        Route::patch('/admin/online-sim-orders/{order}/update-status', [OnlineSimOrderController::class, 'updateStatus'])->name('admin.online-sim-orders.update-status');
    });

    // Delivery Service Management
    Route::middleware(['permission:manage delivery services'])->group(function () {
        Route::resource('delivery-services', DeliveryServiceController::class);
    });

    // SIM Stock Management
    Route::middleware(['permission:manage sim stock'])->group(function () {
        Route::resource('sim-stocks', SimStockController::class);
        Route::post('sim-stocks/{simStock}/activate', [SimStockController::class, 'activate'])->name('sim-stocks.activate');
        Route::get('sim-stocks-import', [SimStockImportController::class, 'create'])->name('sim-stocks.import');
        Route::post('sim-stocks-import', [SimStockImportController::class, 'store'])->name('sim-stocks.import.store');
        Route::get('sim-stocks-export', [SimStockExportController::class, 'export'])->name('sim-stocks.export');
    });

    // Reports
    Route::middleware(['permission:view reports'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/overview', [ReportController::class, 'overview'])->name('reports.overview');
    });

    // Role Management (Super Admin only)
    Route::middleware(['role:Super Admin'])->group(function () {
        Route::resource('roles', RoleController::class);
    });

    // Chat System
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
        Route::get('/room/{room}', [ChatController::class, 'show'])->name('show');
        Route::post('/room/{room}/message', [ChatController::class, 'sendMessage'])->name('send-message');
        Route::post('/create-room', [ChatController::class, 'createRoom'])->name('create-room');
    });
});

require __DIR__.'/auth.php';
