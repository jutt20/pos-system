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
    Route::get('sim-orders/export', [\App\Http\Controllers\SimOrderController::class, 'export'])->name('sim-orders.export');
    Route::resource('sim-orders', SimOrderController::class);

    // SIM Stock
    Route::middleware(['permission:manage sim stocks'])->group(function () {
        Route::post('sim-stocks/import', [SimStockController::class, 'import'])->name('sim-stocks.import');
        Route::get('sim-stocks/export', [SimStockController::class, 'export'])->name('sim-stocks.export');
        Route::post('sim-stocks/activate', [SimStockController::class, 'activate'])->name('sim-stocks.activate');
        Route::post('sim-stocks/bulk-update', [SimStockController::class, 'bulkUpdate'])->name('sim-stocks.bulk-update');
        Route::resource('sim-stocks', SimStockController::class);
    });

    // Reports
    Route::middleware(['permission:view reports'])->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/overview', [ReportController::class, 'overview'])->name('reports.overview');
        Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
    });

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

        Route::get('/nexitel-services', function () {
            return view('retailer.nexitel-services'); // create this blade view
        })->name('nexitel.services');

        Route::get('/voip-menu', function () {
            return view('retailer.voip-menu'); // Adjust path if needed
        })->name('voip.menu');

        Route::get('/retailer/global-menu', function () {
            return view('retailer.global-menu');
        })->name('global.menu');

        Route::get('/nexitel-activation', function () {
            return view('retailer.nexitel-activation');
        })->name('nexitel.activation');

        Route::get('/nexitel-recharge', function () {
            return view('retailer.nexitel-recharge');
        })->name('nexitel.recharge');

        Route::get('/nexitel-recharge-report', function () {
            return view('retailer.nexitel-recharge-report');
        })->name('nexitel.recharge.report');

        Route::get('/nexitel-activation-report', function () {
            return view('retailer.nexitel-activation-report');
        })->name('nexitel.activation.report');

        Route::get('/nexitel-sim-swap', function () {
            return view('retailer.nexitel-sim-swap');
        })->name('nexitel.sim.swap');

        Route::get('/nexitel-port-status', function () {
            return view('retailer.nexitel-port-status');
        })->name('nexitel.port.status');

        Route::get('/bulk-activation', function () {
            return view('retailer.bulk-activation');
        })->name('nexitel.bulk.activation');

        Route::get('/wifi-enable', function () {
            return view('retailer.wifi-enable');
        })->name('nexitel.wifi.enable');
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

require __DIR__ . '/auth.php';
