<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Nexitel POS') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #2563eb;
            --secondary-color: #64748b;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            z-index: 1000;
            overflow-y: auto;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-item {
            margin: 0.25rem 1rem;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }
        
        .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        .top-navbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .content-area {
            padding: 2rem;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 0.75rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            border-radius: 0.5rem;
            min-width: 250px;
        }
        
        .user-dropdown {
            position: relative;
        }
        
        .user-dropdown .dropdown-toggle {
            background: none;
            border: none;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .user-dropdown .dropdown-toggle:hover {
            background-color: #f8fafc;
        }
        
        .user-dropdown .dropdown-toggle:after {
            margin-left: 0.5rem;
        }
        
        .dropdown-header {
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 0.5rem 0.5rem 0 0;
            margin: -0.5rem -0.5rem 0.5rem -0.5rem;
        }
        
        .dropdown-item {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background-color: #f8fafc;
            transform: translateX(5px);
        }
        
        .dropdown-item i {
            width: 20px;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        
        /* Custom styles for the UI */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .page-header {
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }
        
        .nav-tabs {
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 30px;
        }
        
        .nav-tabs .nav-link {
            color: #6b7280;
            border: none;
            padding: 12px 24px;
            font-weight: 500;
            border-radius: 0;
            border-bottom: 2px solid transparent;
        }
        
        .nav-tabs .nav-link.active {
            color: #2563eb;
            background: none;
            border-bottom-color: #2563eb;
        }
        
        .content-section {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
        }
        
        .form-control {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .btn-primary {
            background: #2563eb;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }
        
        .btn-sm {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            background: white;
            color: #374151;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }
        
        .btn-sm:hover {
            background: #f9fafb;
            color: #374151;
            text-decoration: none;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .data-table th {
            background: #f9fafb;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .data-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .data-table tr:hover {
            background: #f9fafb;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
        }
        
        .alert-success {
            background: #ecfdf5;
            color: #065f46;
        }
        
        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }
        
        .list-group-item {
            border: none;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4 class="mb-0">
                <i class="fas fa-store me-2"></i>
                Nexitel POS
            </h4>
            <small class="text-light opacity-75">Point of Sales System</small>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </div>
            
            @can('manage employees')
            <div class="nav-item">
                <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    Employees
                </a>
            </div>
            @endcan
            
            @if(auth()->user()->isSuperAdmin())
            <div class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i>
                    Roles & Permissions
                </a>
            </div>
            @endif
            
            @can('manage customers')
            <div class="nav-item">
                <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                    <i class="fas fa-user-friends"></i>
                    Customers
                </a>
            </div>
            @endcan
            
            @can('manage invoices')
            <div class="nav-item">
                <a href="{{ route('invoices.index') }}" class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i>
                    Invoices
                </a>
            </div>
            @endcan
            
            @can('manage activations')
            <div class="nav-item">
                <a href="{{ route('activations.index') }}" class="nav-link {{ request()->routeIs('activations.*') ? 'active' : '' }}">
                    <i class="fas fa-mobile-alt"></i>
                    Activations
                </a>
            </div>
            @endcan
            
            @can('manage orders')
            <div class="nav-item">
                <a href="{{ route('sim-orders.index') }}" class="nav-link {{ request()->routeIs('sim-orders.*') ? 'active' : '' }}">
                    <i class="fas fa-sim-card"></i>
                    SIM Orders
                </a>
            </div>
            @endcan
            
            @can('view reports')
            <div class="nav-item">
                <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    Reports
                </a>
            </div>
            @endcan
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <div class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link d-md-none me-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
            </div>
            
            <div class="user-dropdown dropdown">
                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle fa-lg me-2"></i>
                    <span>{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <div class="dropdown-header">
                            <div class="fw-bold">{{ auth()->user()->name }}</div>
                            <small class="opacity-75">
                                @foreach(auth()->user()->roles as $role)
                                    {{ $role->name }}@if(!$loop->last), @endif
                                @endforeach
                            </small>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user me-2"></i>
                            Profile Settings
                        </a>
                    </li>
                    @if(auth()->user()->isSuperAdmin())
                    <li>
                        <a class="dropdown-item" href="{{ route('roles.index') }}">
                            <i class="fas fa-user-shield me-2"></i>
                            Manage Roles
                        </a>
                    </li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !toggle?.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
