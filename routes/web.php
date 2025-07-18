<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\SimOrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SimStockController;
use App\Http\Controllers\SimStockImportController;
use App\Http\Controllers\SimStockExportController;
use App\Http\Controllers\RetailerController;
use App\Http\Controllers\CustomerPortalController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
require __DIR__.'/auth.php';

// Dashboard Routes (Protected)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes (Protected with permissions)
Route::middleware(['auth'])->group(function () {
    
    // Customer Management
    Route::resource('customers', CustomerController::class);
    
    // Employee Management
    Route::resource('employees', EmployeeController::class);
    
    // Invoice Management
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
    
    // Activation Management
    Route::resource('activations', ActivationController::class);
    
    // SIM Order Management
    Route::resource('sim-orders', SimOrderController::class);
    
    // Role Management
    Route::resource('roles', RoleController::class);
    
    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/overview', [ReportController::class, 'overview'])->name('reports.overview');
    Route::post('reports/export', [ReportController::class, 'export'])->name('reports.export');
    
    // SIM Stock Management
    Route::resource('sim-stocks', SimStockController::class);
    Route::patch('sim-stocks/{simStock}/activate', [SimStockController::class, 'activate'])->name('sim-stocks.activate');
    Route::post('sim-stocks/bulk-update', [SimStockController::class, 'bulkUpdate'])->name('sim-stocks.bulk-update');
    Route::get('sim-stocks-export', [SimStockController::class, 'export'])->name('sim-stocks.export');
    Route::post('sim-stocks-import', [SimStockController::class, 'import'])->name('sim-stocks.import');
});

// Customer Portal Routes (Protected)
Route::middleware(['auth'])->prefix('customer-portal')->name('customer-portal.')->group(function () {
    Route::get('/', [CustomerPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/activations', [CustomerPortalController::class, 'activations'])->name('activations');
    Route::get('/orders', [CustomerPortalController::class, 'orders'])->name('orders');
    Route::get('/invoices', [CustomerPortalController::class, 'invoices'])->name('invoices');
});

// Retailer Portal Routes (Protected)
Route::middleware(['auth'])->prefix('retailer')->name('retailer.')->group(function () {
    Route::get('/', [RetailerController::class, 'dashboard'])->name('dashboard');
    Route::get('/transactions', [RetailerController::class, 'transactions'])->name('transactions');
    Route::get('/reports', [RetailerController::class, 'reports'])->name('reports');
    Route::get('/profile', [RetailerController::class, 'profile'])->name('profile');
});
