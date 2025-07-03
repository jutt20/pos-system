<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'POS System')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #64748b;
            --success-color: #16a34a;
            --danger-color: #dc2626;
            --warning-color: #d97706;
            --info-color: #0891b2;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #334155;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Enhanced Header */
        .app-header {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
            color: white;
            padding: 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 3px solid #3b82f6;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 100%;
            padding: 16px 24px;
            margin-left: var(--sidebar-width);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-brand {
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-brand i {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            padding: 8px;
            border-radius: 8px;
            font-size: 1.2rem;
        }

        .breadcrumb-nav {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .breadcrumb-nav a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb-nav a:hover {
            color: white;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-notifications {
            position: relative;
        }

        .notification-btn {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
        }

        .notification-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-dropdown {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            padding: 8px 16px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
            min-width: 200px;
        }

        .user-dropdown:hover {
            background: rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.75rem;
            opacity: 0.8;
            color: #94a3b8;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-radius: 12px;
            padding: 8px 0;
            min-width: 220px;
            margin-top: 8px;
        }

        .dropdown-item {
            padding: 12px 20px;
            color: #374151;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            color: #111827;
            transform: translateX(4px);
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
        }

        /* Enhanced Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
            color: white;
            padding: 0;
            overflow-y: auto;
            z-index: 999;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
        }

        .sidebar-brand i {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            padding: 10px;
            border-radius: 10px;
            font-size: 1.2rem;
        }

        .sidebar-brand h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }

        .sidebar-subtitle {
            font-size: 0.8rem;
            opacity: 0.7;
            margin-top: 4px;
        }

        .sidebar-nav {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }

        .sidebar-nav li {
            margin-bottom: 4px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            position: relative;
        }

        .sidebar-nav a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: #3b82f6;
            transform: translateX(4px);
        }

        .sidebar-nav a.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.2));
            color: white;
            border-left-color: #3b82f6;
            box-shadow: inset 0 0 20px rgba(59, 130, 246, 0.1);
        }

        .sidebar-nav i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: transparent;
            padding-top: 0;
        }

        .main-container {
            max-width: 100%;
            margin: 0;
            padding: 30px;
        }

        /* Enhanced Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.2);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
        }

        .page-header-content {
            flex: 1;
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title i {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 1rem;
            margin: 0;
            font-weight: 400;
        }

        .header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-shrink: 0;
        }

        /* Enhanced Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.875rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: white;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
        }

        .btn-sm:hover {
            background: #f9fafb;
            color: #111827;
            text-decoration: none;
            border-color: #d1d5db;
            transform: translateY(-1px);
        }

        /* Enhanced Content Sections */
        .content-section {
            background: white;
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.2);
            position: relative;
            overflow: hidden;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        /* Enhanced Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .stat-icon.green {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .stat-icon.purple {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .stat-content {
            flex: 1;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 4px;
        }

        .stat-value.green {
            color: var(--success-color);
        }

        .stat-value.blue {
            color: var(--primary-color);
        }

        .stat-change {
            font-size: 0.8rem;
            font-weight: 500;
        }

        .stat-change.positive {
            color: #059669;
        }

        .stat-change.negative {
            color: #dc2626;
        }

        /* Enhanced Tables */
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            background: white;
        }

        .data-table th {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border: none;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #334155;
        }

        .data-table tr:hover {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        /* Brand Performance */
        .brand-performance {
            space-y: 16px;
        }

        .brand-item {
            padding: 16px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .brand-item:last-child {
            border-bottom: none;
        }

        .brand-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .brand-name {
            font-weight: 600;
            color: #111827;
        }

        .brand-count {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .brand-progress {
            height: 6px;
            background: #f1f5f9;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            border-radius: 3px;
            transition: width 0.3s;
        }

        /* Transaction List */
        .transaction-list {
            space-y: 12px;
        }

        .transaction-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        .transaction-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
        }

        .transaction-details {
            flex: 1;
        }

        .transaction-title {
            font-weight: 500;
            color: #111827;
            margin-bottom: 2px;
        }

        .transaction-meta {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .transaction-amount {
            font-weight: 600;
            color: #059669;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content,
            .header-content {
                margin-left: 0;
            }

            .page-header {
                flex-direction: column;
                gap: 20px;
                align-items: stretch;
            }

            .header-actions {
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
                gap: 16px;
            }

            .user-dropdown {
                min-width: auto;
            }
        }

        /* Form Enhancements */
        .form-select {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 12px;
            background: white;
            color: #374151;
            font-size: 0.9rem;
        }

        .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-paid {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #166534;
        }

        .status-unpaid {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }

        .status-active {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
        }

        /* Text Colors */
        .text-success {
            color: var(--success-color) !important;
        }

        .text-danger {
            color: var(--danger-color) !important;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            color: #065f46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #991b1b;
        }
    </style>
</head>
<body>
    <!-- Enhanced Header -->
    <div class="app-header">
        <div class="header-content">
            <div class="header-left">
                <div class="breadcrumb-nav">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    @if(!request()->routeIs('dashboard'))
                        <i class="fas fa-chevron-right"></i>
                        <span>@yield('title', 'Page')</span>
                    @endif
                </div>
            </div>
            
            <div class="header-right">
                <div class="header-notifications">
                    <a href="#" class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </a>
                </div>
                
                <div class="dropdown">
                    <a href="#" class="user-dropdown" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth('employee')->user()->name, 0, 2)) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ auth('employee')->user()->name }}</div>
                            <div class="user-role">
                                {{ auth('employee')->user()->roles->pluck('name')->join(', ') }}
                            </div>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user"></i> Profile Settings
                        </a></li>
                        @if(auth('employee')->user()->hasRole('Super Admin'))
                        <li><a class="dropdown-item" href="{{ route('roles.index') }}">
                            <i class="fas fa-users-cog"></i> Role Management
                        </a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <i class="fas fa-store"></i>
                <div>
                    <h3>Nexitel POS</h3>
                    <div class="sidebar-subtitle">Point of Sales System</div>
                </div>
            </a>
        </div>
        
        <ul class="sidebar-nav">
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a></li>
            
            @can('manage employees')
            <li><a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Employees
            </a></li>
            @endcan
            
            @can('manage customers')
            <li><a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
                <i class="fas fa-user-friends"></i> Customers
            </a></li>
            @endcan
            
            @can('manage invoices')
            <li><a href="{{ route('invoices.index') }}" class="{{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i> Invoices
            </a></li>
            @endcan
            
            @can('manage activations')
            <li><a href="{{ route('activations.index') }}" class="{{ request()->routeIs('activations.*') ? 'active' : '' }}">
                <i class="fas fa-mobile-alt"></i> Activations
            </a></li>
            @endcan
            
            @can('manage orders')
            <li><a href="{{ route('sim-orders.index') }}" class="{{ request()->routeIs('sim-orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> SIM Orders
            </a></li>
            @endcan
            
            @can('view reports')
            <li><a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Reports
            </a></li>
            @endcan
            
            @if(auth('employee')->user()->hasRole('Super Admin'))
            <li><a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i> Role Management
            </a></li>
            @endif
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @if(session('success'))
            <div class="main-container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="main-container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
