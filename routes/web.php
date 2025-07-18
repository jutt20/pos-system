<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\SimOrderController;
use App\Http\Controllers\OnlineSimOrderController;
use App\Http\Controllers\DeliveryServiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SimStockController;
use App\Http\Controllers\SimStockImportController;
use App\Http\Controllers\SimStockExportController;
use App\Http\Controllers\RetailerController;
use App\Http\Controllers\CustomerPortalController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\RetailerLoginController;
use App\Http\Controllers\Auth\CustomerLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Public Online SIM Order Routes
Route::get('/order-sim', [OnlineSimOrderController::class, 'publicCreate'])->name('sim-order.create');
Route::post('/order-sim', [OnlineSimOrderController::class, 'publicStore'])->name('sim-order.store');
Route::get('/track/{orderNumber}', [OnlineSimOrderController::class, 'track'])->name('online-sim-orders.track');

// Authentication Routes
Route::get('/staff-login', function () {
    return view('auth.login');
})->name('staff.login');

// Retailer Authentication
Route::get('/retailer-login', [RetailerLoginController::class, 'create'])->name('retailer.login');
Route::post('/retailer-login', [RetailerLoginController::class, 'login']);
Route::post('/retailer-logout', [RetailerLoginController::class, 'destroy'])->name('retailer.logout');

// Customer Authentication
Route::get('/customer-login', [CustomerLoginController::class, 'create'])->name('customer.login');
Route::post('/customer-login', [CustomerLoginController::class, 'login']);
Route::post('/customer-logout', [CustomerLoginController::class, 'destroy'])->name('customer.logout');

// Staff Dashboard Routes (Protected)
Route::middleware(['auth:employee'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Customer Management
    Route::resource('customers', CustomerController::class);
    Route::post('customers/{customer}/upload-document', [CustomerController::class, 'uploadDocument'])->name('customers.upload-document');
    Route::delete('customers/{customer}/documents/{document}', [CustomerController::class, 'deleteDocument'])->name('customers.delete-document');
    
    // Employee Management
    Route::resource('employees', EmployeeController::class);
    
    // Invoice Management
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'generatePDF'])->name('invoices.pdf');
    
    // Activation Management
    Route::resource('activations', ActivationController::class);
    
    // SIM Order Management
    Route::resource('sim-orders', SimOrderController::class);
    
    // Online SIM Order Management
    Route::resource('online-sim-orders', OnlineSimOrderController::class);
    Route::post('online-sim-orders/{onlineSimOrder}/approve', [OnlineSimOrderController::class, 'approve'])->name('online-sim-orders.approve');
    Route::patch('online-sim-orders/{onlineSimOrder}/status', [OnlineSimOrderController::class, 'updateStatus'])->name('online-sim-orders.update-status');
    
    // Delivery Service Management
    Route::resource('delivery-services', DeliveryServiceController::class);
    Route::post('delivery-services/{deliveryService}/toggle', [DeliveryServiceController::class, 'toggle'])->name('delivery-services.toggle');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    
    // Role Management
    Route::resource('roles', RoleController::class);
    
    // SIM Stock Management
    Route::resource('sim-stocks', SimStockController::class);
    Route::patch('sim-stocks/{simStock}/activate', [SimStockController::class, 'activate'])->name('sim-stocks.activate');
    Route::post('sim-stocks/bulk-update', [SimStockController::class, 'bulkUpdate'])->name('sim-stocks.bulk-update');
    Route::get('sim-stocks-export', [SimStockController::class, 'export'])->name('sim-stocks.export');
    Route::post('sim-stocks-import', [SimStockController::class, 'import'])->name('sim-stocks.import');
    
    // Chat System
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{room}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{room}/message', [ChatController::class, 'sendMessage'])->name('chat.send-message');
});

// Retailer Dashboard Routes
Route::middleware(['auth:employee', 'role:Retailer'])->prefix('retailer')->name('retailer.')->group(function () {
    Route::get('/dashboard', [RetailerController::class, 'dashboard'])->name('dashboard');
    Route::get('/reports', [RetailerController::class, 'reports'])->name('reports');
    Route::get('/transactions', [RetailerController::class, 'transactions'])->name('transactions');
});

// Customer Portal Routes
Route::middleware(['auth:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [CustomerPortalController::class, 'orders'])->name('orders');
    Route::get('/invoices', [CustomerPortalController::class, 'invoices'])->name('invoices');
    Route::get('/profile', [CustomerPortalController::class, 'profile'])->name('profile');
});

require __DIR__.'/auth.php';
