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
    return redirect('/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth:employee'])->name('dashboard');

Route::middleware('auth:employee')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Employee Management
    Route::resource('employees', EmployeeController::class);
    
    // Customer Management
    Route::resource('customers', CustomerController::class);
    
    // Invoice Management
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
    
    // Activation Management
    Route::resource('activations', ActivationController::class);
    
    // SIM Order Management
    Route::resource('sim-orders', SimOrderController::class);
    
    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/overview', [ReportController::class, 'overview'])->name('reports.overview');
    Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
});

// Customer Portal Routes
Route::prefix('customer-portal')->group(function () {
    Route::get('/', function () {
        return view('customer-portal.dashboard');
    })->name('customer-portal.dashboard');
});

require __DIR__.'/auth.php';
