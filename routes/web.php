<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\SimOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest:employee')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest:employee');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:employee')
    ->name('logout');

// Protected Routes with Spatie Permission
Route::middleware(['auth:employee'])->group(function () {
    
    // Dashboard - accessible to all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile - accessible to all authenticated users
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Role Management - Only Super Admin
    Route::middleware(['role:Super Admin'])->group(function () {
        Route::resource('roles', RoleController::class);
    });
    
    // Employee Management - Only Super Admin and Admin
    Route::middleware(['permission:manage employees'])->group(function () {
        Route::resource('employees', EmployeeController::class);
    });
    
    // Customer Management - Multiple roles can access
    Route::middleware(['permission:manage customers'])->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::get('/customers/{customer}/documents', [CustomerController::class, 'documents'])->name('customers.documents');
        Route::post('/customers/{customer}/documents', [CustomerController::class, 'uploadDocument'])->name('customers.documents.upload');
    });
    
    // Invoice Management
    Route::middleware(['permission:manage invoices'])->group(function () {
        Route::resource('invoices', InvoiceController::class);
        Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
        Route::post('/invoices/{invoice}/send', [InvoiceController::class, 'sendEmail'])->name('invoices.send');
    });
    
    // Activation Management
    Route::middleware(['permission:manage activations'])->group(function () {
        Route::resource('activations', ActivationController::class);
        Route::post('/activations/{activation}/activate', [ActivationController::class, 'activate'])->name('activations.activate');
    });
    
    // SIM Order Management
    Route::middleware(['permission:manage orders'])->group(function () {
        Route::resource('sim-orders', SimOrderController::class);
        Route::post('/sim-orders/{simOrder}/fulfill', [SimOrderController::class, 'fulfill'])->name('sim-orders.fulfill');
    });
    
    // Reports - Managers and above
    Route::middleware(['permission:view reports'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/overview', [ReportController::class, 'overview'])->name('reports.overview');
    });
    
    // Export functionality
    Route::middleware(['permission:export data'])->group(function () {
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    });
    
});
