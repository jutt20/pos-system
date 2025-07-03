<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\SimOrderController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::middleware(['auth:employee'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Employee routes
    Route::resource('employees', EmployeeController::class);
    
    // Customer routes
    Route::resource('customers', CustomerController::class);
    
    // Invoice routes
    Route::resource('invoices', InvoiceController::class);
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
    
    // Activation routes
    Route::resource('activations', ActivationController::class);
    
    // SIM Order routes
    Route::resource('sim-orders', SimOrderController::class);
    
    // Report routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/overview', [ReportController::class, 'overview'])->name('reports.overview');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
