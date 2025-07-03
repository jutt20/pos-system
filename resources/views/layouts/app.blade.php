<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'NexiTel POS') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/enhanced-styles.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <div class="app-wrapper">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <i class="fas fa-mobile-alt brand-icon"></i>
                    <span class="brand-text">NexiTel POS</span>
                </div>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="sidebar-content">
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    
                    @can('view customers')
                    <li class="nav-item">
                        <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <span class="nav-text">Customers</span>
                        </a>
                    </li>
                    @endcan
                    
                    @can('view employees')
                    <li class="nav-item">
                        <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <span class="nav-text">Employees</span>
                        </a>
                    </li>
                    @endcan
                    
                    @can('view invoices')
                    <li class="nav-item">
                        <a href="{{ route('invoices.index') }}" class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-invoice"></i>
                            <span class="nav-text">Invoices</span>
                        </a>
                    </li>
                    @endcan
                    
                    @can('view activations')
                    <li class="nav-item">
                        <a href="{{ route('activations.index') }}" class="nav-link {{ request()->routeIs('activations.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-mobile-alt"></i>
                            <span class="nav-text">Activations</span>
                        </a>
                    </li>
                    @endcan
                    
                    @can('manage orders')
                    <li class="nav-item">
                        <a href="{{ route('sim-orders.index') }}" class="nav-link {{ request()->routeIs('sim-orders.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <span class="nav-text">SIM Orders</span>
                        </a>
                    </li>
                    @endcan
                    
                    @can('view reports')
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <span class="nav-text">Reports</span>
                        </a>
                    </li>
                    @endcan
                    
                    @can('manage roles')
                    <li class="nav-item">
                        <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shield-alt"></i>
                            <span class="nav-text">Roles & Permissions</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</div>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="header-left">
                    <button class="mobile-sidebar-toggle" id="mobileSidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <!-- Breadcrumb -->
                    <nav class="breadcrumb-nav">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    <i class="fas fa-home"></i>
                                </a>
                            </li>
                            @if(request()->routeIs('dashboard'))
                                <li class="breadcrumb-item active">Dashboard</li>
                            @elseif(request()->routeIs('customers.*'))
                                <li class="breadcrumb-item active">Customers</li>
                            @elseif(request()->routeIs('employees.*'))
                                <li class="breadcrumb-item active">Employees</li>
                            @elseif(request()->routeIs('invoices.*'))
                                <li class="breadcrumb-item active">Invoices</li>
                            @elseif(request()->routeIs('activations.*'))
                                <li class="breadcrumb-item active">Activations</li>
                            @elseif(request()->routeIs('sim-orders.*'))
                                <li class="breadcrumb-item active">SIM Orders</li>
                            @elseif(request()->routeIs('reports.*'))
                                <li class="breadcrumb-item active">Reports</li>
                            @elseif(request()->routeIs('roles.*'))
                                <li class="breadcrumb-item active">Roles & Permissions</li>
                            @endif
                        </ol>
                    </nav>
                </div>
                
                <div class="header-right">
                    <!-- Notifications -->
                    <div class="dropdown notification-dropdown">
                        <button class="notification-btn" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        <div class="dropdown-menu notification-menu">
                            <div class="notification-header">
                                <h6>Notifications</h6>
                                <span class="badge bg-primary">3 New</span>
                            </div>
                            <div class="notification-list">
                                <div class="notification-item">
                                    <div class="notification-icon bg-success">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="notification-content">
                                        <div class="notification-title">New activation completed</div>
                                        <div class="notification-time">2 minutes ago</div>
                                    </div>
                                </div>
                                <div class="notification-item">
                                    <div class="notification-icon bg-info">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>
                                    <div class="notification-content">
                                        <div class="notification-title">Invoice #1234 generated</div>
                                        <div class="notification-time">5 minutes ago</div>
                                    </div>
                                </div>
                                <div class="notification-item">
                                    <div class="notification-icon bg-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="notification-content">
                                        <div class="notification-title">Low SIM inventory alert</div>
                                        <div class="notification-time">1 hour ago</div>
                                    </div>
                                </div>
                            </div>
                            <div class="notification-footer">
                                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="dropdown user-dropdown">
                        <button class="user-menu-btn" type="button" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ auth()->user()->name }}</div>
                                <div class="user-role">{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</div>
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu user-menu">
                            <div class="user-menu-header">
                                <div class="user-avatar large">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ auth()->user()->name }}</div>
                                    <div class="user-email">{{ auth()->user()->email }}</div>
                                    <div class="user-role">{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user me-2"></i>
                                Profile Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>
                                Account Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="page-content">
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
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        });
        
        document.getElementById('mobileSidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('mobile-open');
        });
        
        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('mobileSidebarToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggleBtn.contains(event.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });
        
        // Auto-dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>
