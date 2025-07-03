<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nexitel POS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
    --nexitel-blue: #2563eb;
    --nexitel-purple: #7c3aed;
}

body {
    font-family: 'Inter', sans-serif;
    background-color: #fafafa;
    color: #333;
}

.main-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.page-header {
    background: white;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.page-title {
    font-size: 24px;
    font-weight: 600;
    color: #1a1a1a;
    margin: 0;
}

.nav-tabs {
    border-bottom: 2px solid #e5e7eb;
    margin-bottom: 30px;
}

.nav-tabs .nav-link {
    border: none;
    background: none;
    color: #6b7280;
    font-weight: 500;
    padding: 12px 24px;
    border-radius: 0;
    border-bottom: 2px solid transparent;
}

.nav-tabs .nav-link.active {
    color: #1f2937;
    border-bottom-color: #2563eb;
    background: none;
}

.content-section {
    background: white;
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 20px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    text-align: center;
}

.stat-label {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 8px;
}

.stat-value {
    font-size: 24px;
    font-weight: 700;
    color: #1a1a1a;
}

.stat-value.green {
    color: #059669;
}

.stat-value.blue {
    color: #2563eb;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 16px;
}

.data-table th {
    background: #f9fafb;
    padding: 12px 16px;
    text-align: left;
    font-weight: 500;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.data-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #f3f4f6;
    color: #1f2937;
}

.data-table tr:hover {
    background: #f9fafb;
}

.btn-primary {
    background: #1f2937;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 500;
    text-decoration: none;
    display: inline-block;
    transition: background 0.2s;
}

.btn-primary:hover {
    background: #111827;
    color: white;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-weight: 500;
    color: #374151;
    margin-bottom: 6px;
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
}

.form-control:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.status-paid {
    background: #d1fae5;
    color: #065f46;
}

.status-unpaid {
    background: #fee2e2;
    color: #991b1b;
}

.status-active {
    background: #dbeafe;
    color: #1e40af;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 4px;
    text-decoration: none;
    border: 1px solid #d1d5db;
    background: white;
    color: #374151;
}

.btn-sm:hover {
    background: #f3f4f6;
}

.welcome-header {
    font-size: 28px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 30px;
}

.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.sidebar .nav-link {
    color: rgba(255, 255, 255, 0.8);
    padding: 12px 20px;
    margin: 2px 10px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active {
    color: white;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.sidebar .nav-link i {
    margin-right: 8px;
}

main.col-md-9 {
    margin-left: 16.66667%;
}

@media (max-width: 767.98px) {
    main.col-md-9 {
        margin-left: 0;
    }
    .sidebar {
        position: relative;
    }
}
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Nexitel POS</h4>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        
                        @can('manage employees')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                                <i class="bi bi-people me-2"></i>
                                Employees
                            </a>
                        </li>
                        @endcan
                        
                        @can('manage customers')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                                <i class="bi bi-person-lines-fill me-2"></i>
                                Customers
                            </a>
                        </li>
                        @endcan
                        
                        @can('manage billing')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
                                <i class="bi bi-receipt me-2"></i>
                                Invoices
                            </a>
                        </li>
                        @endcan
                        
                        @can('manage activations')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('activations.*') ? 'active' : '' }}" href="{{ route('activations.index') }}">
                                <i class="bi bi-phone me-2"></i>
                                Activations
                            </a>
                        </li>
                        @endcan
                        
                        @can('manage orders')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('sim-orders.*') ? 'active' : '' }}" href="{{ route('sim-orders.index') }}">
                                <i class="bi bi-box-seam me-2"></i>
                                SIM Orders
                            </a>
                        </li>
                        @endcan
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('reports.index') }}">
                                <i class="bi bi-graph-up me-2"></i>
                                Reports
                            </a>
                        </li>
                    </ul>
                    
                    <hr class="text-white-50">
                    
                    <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
       id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-person-circle me-2"></i>
        <span>{{ auth()->user()->name }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
            <i class="bi bi-person me-2"></i>Profile
        </a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="bi bi-box-arrow-right me-2"></i>Sign out
                </button>
            </form>
        </li>
    </ul>
</div>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title', 'Dashboard')</h1>
                    @yield('actions')
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
